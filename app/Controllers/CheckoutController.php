<?php

namespace App\Controllers;

use App\Models\OrderModel;
use App\Models\OrderItemModel;
use App\Models\ProductModel;

class CheckoutController extends BaseController
{
    protected $session;

    public function __construct()
    {
        $this->session = \Config\Services::session();
    }

    public function index()
    {
        $cart = $this->session->get('cart');
        if (empty($cart)) {
            return redirect()->to('/cart')->with('error', 'Keranjang Anda kosong!');
        }

        $data['cart_items'] = $cart;
        return view('checkout/index', $data);
    }

    public function process()
    {
        $cart = $this->session->get('cart');
        if (empty($cart)) {
            return redirect()->to('/');
        }

        $productModel = new ProductModel();

        // Validasi stok sekali lagi sebelum proses
        foreach ($cart as $productId => $item) {
            $product = $productModel->find($productId);
            if (!$product || $product['stock'] < $item['quantity']) {
                return redirect()->to('/cart')->with('error', 'Stok produk ' . esc($item['name']) . ' tidak mencukupi.');
            }
        }

        $totalAmount = 0;
        foreach ($cart as $item) {
            $totalAmount += $item['price'] * $item['quantity'];
        }

        $paymentMethod = $this->request->getPost('payment_method');
        $initialStatus = ($paymentMethod == 'cod') ? 'processing' : 'pending_payment';

        $orderModel = new OrderModel();
        $orderData = [
            'customer_name'     => $this->request->getPost('customer_name'),
            'customer_whatsapp' => $this->request->getPost('customer_whatsapp'),
            'payment_method'    => $paymentMethod,
            'total_amount'      => $totalAmount,
            'order_status'      => $initialStatus
        ];

        $orderModel->insert($orderData);
        $orderId = $orderModel->getInsertID();

        $orderItemModel = new OrderItemModel();
        foreach ($cart as $item) {
            $orderItemModel->insert([
                'order_id'   => $orderId,
                'product_id' => $item['id'],
                'quantity'   => $item['quantity'],
                'price'      => $item['price']
            ]);
        }

        // Kurangi stok produk
        foreach ($cart as $item) {
            $productModel->where('id', $item['id'])
                ->set('stock', 'stock - ' . $item['quantity'], false)
                ->update();
        }

        $this->session->remove('cart');

        // === PERUBAHAN UTAMA DI SINI ===
        if ($paymentMethod == 'cod') {
            // Jika COD, langsung ke halaman sukses
            return redirect()->to('/checkout/success/' . $orderId);
        } else {
            // Jika online, arahkan ke halaman pembayaran baru
            return redirect()->to('/checkout/payment/' . $orderId);
        }
    }

    /**
     * Menyiapkan dan menampilkan halaman pembayaran Midtrans.
     */
    public function payment($orderId)
    {
        $orderModel = new OrderModel();
        $orderItemModel = new OrderItemModel();
        $productModel = new ProductModel();

        // Ambil data pesanan
        $order = $orderModel->find($orderId);
        if (empty($order)) {
            return redirect()->to('/')->with('error', 'Pesanan tidak ditemukan.');
        }

        // Ambil item-item pesanan
        $items = $orderItemModel->where('order_id', $orderId)->findAll();

        // --- Konfigurasi Midtrans ---
        $config = config('Midtrans'); // Membaca file app/Config/Midtrans.php
        \Midtrans\Config::$serverKey = $config->serverKey;
        \Midtrans\Config::$isProduction = $config->isProduction;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        // Siapkan detail item untuk Midtrans
        $item_details = [];
        foreach ($items as $item) {
            $product = $productModel->find($item['product_id']);
            $item_details[] = [
                'id'       => $item['product_id'],
                'price'    => (float)$item['price'],
                'quantity' => (int)$item['quantity'],
                'name'     => $product['name']
            ];
        }

        // Siapkan parameter transaksi untuk Midtrans
        $params = [
            'transaction_details' => [
                'order_id'     => $order['id'], // Gunakan ID pesanan unik Anda
                'gross_amount' => (float)$order['total_amount'],
            ],
            'customer_details' => [
                'first_name' => $order['customer_name'],
                'phone'      => $order['customer_whatsapp'],
            ],
            'item_details' => $item_details
        ];

        try {
            // Dapatkan Snap Token dari Midtrans
            $snapToken = \Midtrans\Snap::getSnapToken($params);
            $data['snapToken'] = $snapToken;
            $data['order'] = $order;

            // Tampilkan halaman pembayaran
            return view('checkout/payment', $data);
        } catch (\Exception $e) {
            log_message('error', 'Midtrans Snap Token Error: ' . $e->getMessage());
            return redirect()->to('/cart')->with('error', 'Gagal memproses pembayaran: ' . $e->getMessage());
        }
    }

    public function success($orderId)
    {
        $orderModel = new OrderModel();
        $data['order'] = $orderModel->find($orderId);

        if (empty($data['order'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Order not found');
        }

        return view('checkout/success', $data);
    }

    /**
     * Menerima notifikasi (webhook) dari Midtrans.
     */
    public function notificationHandler()
    {
        // Set konfigurasi Midtrans
        $config = config('Midtrans');
        \Midtrans\Config::$serverKey = $config->serverKey;
        \Midtrans\Config::$isProduction = $config->isProduction;

        // Buat instance Midtrans Notification
        $notif = new \Midtrans\Notification();

        // Ambil data notifikasi
        $order_id = $notif->order_id;
        $transaction_status = $notif->transaction_status;
        $payment_type = $notif->payment_type;
        $fraud_status = $notif->fraud_status ?? null;

        // Verifikasi signature key (keamanan)
        $signature_key = hash('sha512', $order_id . $notif->status_code . $notif->gross_amount . $config->serverKey);
        if ($signature_key != $notif->signature_key) {
            return $this->response->setStatusCode(403, 'Invalid Signature');
        }

        // Update status pesanan di database
        $orderModel = new OrderModel();
        $order = $orderModel->find($order_id);

        if (!$order) {
            return $this->response->setStatusCode(404, 'Order not found');
        }

        if ($transaction_status == 'capture' || $transaction_status == 'settlement') {
            // Jika pembayaran berhasil
            $orderModel->update($order_id, ['order_status' => 'processing']);
        } elseif ($transaction_status == 'expire' || $transaction_status == 'cancel' || $transaction_status == 'deny') {
            // Jika pembayaran gagal atau dibatalkan
            $orderModel->update($order_id, ['order_status' => 'cancelled']);
            // TODO: Kembalikan stok produk (karena pesanan dibatalkan)
        }

        return $this->response->setStatusCode(200, 'OK');
    }
}
