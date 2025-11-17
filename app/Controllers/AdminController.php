<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\OrderModel;
use App\Models\UserModel;
use App\Models\OrderItemModel;
use App\Models\CategoryModel; 

class AdminController extends BaseController
{
    /**
     * Menampilkan halaman utama dashboard dengan data statistik dinamis
     */
    public function index()
    {
        $productModel = new ProductModel();
        $orderModel = new OrderModel();
        $sellerId = session()->get('user_id');

        // Ambil data pesanan yang sudah selesai (completed) milik penjual ini
        $completedOrders = $orderModel->select('orders.id, orders.total_amount, orders.created_at, orders.customer_name')
                                    ->join('order_items', 'order_items.order_id = orders.id')
                                    ->join('products', 'products.id = order_items.product_id')
                                    ->where('products.seller_id', $sellerId)
                                    ->where('orders.order_status', 'completed')
                                    ->groupBy('orders.id, orders.customer_name, orders.created_at, orders.total_amount') 
                                    ->findAll();
        
        $totalRevenue = array_sum(array_column($completedOrders, 'total_amount'));

        // Siapkan data untuk grafik penjualan 7 hari terakhir
        $salesData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-$i days"));
            $salesData[$date] = 0;
        }
        foreach ($completedOrders as $order) {
            $orderDate = date('Y-m-d', strtotime($order['created_at']));
            if (isset($salesData[$orderDate])) {
                $salesData[$orderDate] += (float)$order['total_amount'];
            }
        }
        
        // --- DATA BARU UNTUK TABEL DASHBOARD ---
        // Ambil 5 pesanan yang perlu diproses
        $processing_orders_list = $orderModel
            ->select('orders.id, orders.customer_name, orders.created_at, orders.total_amount')
            ->join('order_items', 'order_items.order_id = orders.id')
            ->join('products', 'products.id = order_items.product_id')
            ->where('products.seller_id', $sellerId)
            ->where('orders.order_status', 'processing')
            ->groupBy('orders.id, orders.customer_name, orders.created_at, orders.total_amount')
            ->orderBy('orders.created_at', 'ASC') // Tampilkan yang paling lama menunggu
            ->limit(5)
            ->findAll();

        $data = [
            'total_products' => $productModel->where('seller_id', $sellerId)->countAllResults(),
            'processing_orders' => $orderModel->join('order_items', 'order_items.order_id = orders.id')
                                             ->join('products', 'products.id = order_items.product_id')
                                             ->where('products.seller_id', $sellerId)
                                             ->where('orders.order_status', 'processing')
                                             ->countAllResults(),
            'total_revenue'  => $totalRevenue,
            'chart_labels'   => json_encode(array_keys($salesData)),
            'chart_data'     => json_encode(array_values($salesData)),
            'processing_orders_list'  => $processing_orders_list // Ganti 'recent_orders'
        ];
        
        return view('admin/dashboard', $data);
    }

    /**
     * Menampilkan halaman untuk mengelola produk
     */
    public function products()
    {
        $productModel = new ProductModel();
        $sellerId = session()->get('user_id');

        $data['products'] = $productModel->where('seller_id', $sellerId)->findAll();
        $data['page_title'] = "Kelola Produk Anda"; 

        return view('admin/products/index', $data);
    }

    /**
     * Menampilkan halaman untuk mengelola pesanan
     */
    public function orders()
    {
        $orderModel = new OrderModel();
        $sellerId = session()->get('user_id');

        $data['orders'] = $orderModel->select('orders.*')
                                    ->join('order_items', 'order_items.order_id = orders.id')
                                    ->join('products', 'products.id = order_items.product_id')
                                    ->where('products.seller_id', $sellerId)
                                    ->groupBy('orders.id, orders.order_id, orders.customer_name, orders.customer_whatsapp, orders.total_amount, orders.payment_method, orders.order_status, orders.logistics_officer_id, orders.created_at')
                                    ->orderBy('orders.created_at', 'DESC')
                                    ->findAll();

        return view('admin/orders/index', $data);
    }

    /**
     * Menampilkan halaman detail untuk satu pesanan.
     */
    public function orderDetail($id)
    {
        $orderModel = new OrderModel();
        $orderItemModel = new OrderItemModel();
        $data['order'] = $orderModel->find($id);

        if (empty($data['order'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Pesanan tidak ditemukan.');
        }

        $data['items'] = $orderItemModel
            ->select('order_items.*, products.name as product_name')
            ->join('products', 'products.id = order_items.product_id')
            ->where('order_items.order_id', $id)
            ->findAll();

        return view('admin/orders/detail', $data);
    }

    /**
     * Menampilkan form untuk menambah produk baru.
     */
    public function newProduct()
    {
        $categoryModel = new CategoryModel();
        $data['categories'] = $categoryModel->orderBy('sort_order', 'ASC')->findAll();
        
        return view('admin/products/new', $data);
    }

    /**
     * Memproses dan menyimpan data produk baru dari form.
     */
    public function createProduct()
    {
        $productModel = new ProductModel();
        $sellerId = session()->get('user_id');

        $imageFile = $this->request->getFile('image');
        $imageName = 'default-product.png';
        if ($imageFile->isValid() && !$imageFile->hasMoved()) {
            $imageName = $imageFile->getRandomName();
            $imageFile->move(ROOTPATH . 'public/uploads/products', $imageName);
        }

        $data = [
            'seller_id'     => $sellerId,
            'name'          => $this->request->getPost('name'),
            'description'   => $this->request->getPost('description'),
            'price'         => $this->request->getPost('price'),
            'unit'          => $this->request->getPost('unit'),
            'stock'         => $this->request->getPost('stock'),
            'category_id'   => $this->request->getPost('category_id'),
            'image'         => $imageName
        ];

        if ($productModel->save($data)) {
            return redirect()->to('/admin/products')->with('success', 'Produk baru berhasil ditambahkan.');
        } else {
            return redirect()->back()->withInput()->with('errors', 'Gagal menambahkan produk.');
        }
    }

    /**
     * Menampilkan form untuk mengedit produk.
     */
    public function editProduct($id)
    {
        $productModel = new ProductModel();
        $categoryModel = new CategoryModel();

        $data['product'] = $productModel->find($id);
        $data['categories'] = $categoryModel->orderBy('sort_order', 'ASC')->findAll();

        if (empty($data['product'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Produk tidak ditemukan.');
        }

        return view('admin/products/edit', $data);
    }

    /**
     * Memproses update data produk.
     */
    public function updateProduct($id)
    {
        $productModel = new ProductModel();
        $product = $productModel->find($id);

        $imageFile = $this->request->getFile('image');
        $imageName = $product['image'];

        if ($imageFile->isValid() && !$imageFile->hasMoved()) {
            if ($imageName != 'default-product.png' && file_exists('uploads/products/' . $imageName)) {
                unlink('uploads/products/' . $imageName);
            }
            $imageName = $imageFile->getRandomName();
            $imageFile->move(ROOTPATH . 'public/uploads/products', $imageName);
        }

        $data = [
            'name'          => $this->request->getPost('name'),
            'description'   => $this->request->getPost('description'),
            'price'         => $this->request->getPost('price'),
            'unit'          => $this->request->getPost('unit'),
            'stock'         => $this->request->getPost('stock'),
            'category_id'   => $this->request->getPost('category_id'),
            'image'         => $imageName
        ];

        if ($productModel->update($id, $data)) {
            return redirect()->to('/admin/products')->with('success', 'Produk berhasil diperbarui.');
        } else {
            return redirect()->back()->withInput()->with('errors', 'Gagal memperbarui produk.');
        }
    }

    /**
     * Menghapus produk dari database.
     */
    public function deleteProduct($id)
    {
        $productModel = new ProductModel();
        $product = $productModel->find($id);

        if ($product) {
            $imageName = $product['image'];
            if ($imageName != 'default-product.png' && file_exists('uploads/products/' . $imageName)) {
                unlink('uploads/products/' . $imageName);
            }

            $productModel->delete($id);

            return redirect()->to('/admin/products')->with('success', 'Produk berhasil dihapus.');
        } else {
            return redirect()->to('/admin/products')->with('error', 'Produk tidak ditemukan.');
        }
    }
    
    /**
     * Membatalkan pesanan.
     */
    public function cancelOrder($id)
    {
        $orderModel = new OrderModel();
        $orderItemModel = new OrderItemModel();
        $productModel = new ProductModel();

        // 1. Ubah status pesanan menjadi 'cancelled'
        $orderModel->update($id, ['order_status' => 'cancelled']);

        // 2. Ambil semua item di dalam pesanan ini
        $items = $orderItemModel->where('order_id', $id)->findAll();

        // 3. Kembalikan stok untuk setiap item
        foreach ($items as $item) {
            $productModel->where('id', $item['product_id'])
                         ->set('stock', 'stock + ' . $item['quantity'], false)
                         ->update();
        }

        return redirect()->to('/admin/orders')->with('success', 'Pesanan #' . $id . ' berhasil dibatalkan dan stok telah dikembalikan.');
    }
}