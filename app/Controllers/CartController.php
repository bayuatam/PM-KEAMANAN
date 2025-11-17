<?php

namespace App\Controllers;

use App\Models\ProductModel;

class CartController extends BaseController
{
    protected $session;

    public function __construct()
    {
        // Memulai service session
        $this->session = \Config\Services::session();
    }

    /**
     * Menampilkan halaman keranjang dan memvalidasi ulang stok setiap item.
     */
    public function index()
    {
        $cart = $this->session->get('cart') ?? [];
        $productModel = new ProductModel();
        $isCheckoutable = true;

        // Cek ketersediaan stok untuk setiap item di keranjang
        if (!empty($cart)) {
            foreach ($cart as $productId => &$item) {
                $product = $productModel->find($productId);
                if (!$product || $product['stock'] < $item['quantity']) {
                    $item['is_available'] = false; // Tandai item tidak tersedia
                    $isCheckoutable = false;
                } else {
                    $item['is_available'] = true;
                }
            }
            // Simpan kembali ke session dengan status ketersediaan yang sudah diperbarui
            $this->session->set('cart', $cart);
        }

        $data['cart_items'] = $cart;
        $data['is_checkoutable'] = $isCheckoutable; // Kirim status checkout ke view
        
        return view('cart/index', $data);
    }

    /**
     * Menambahkan produk ke keranjang dengan validasi stok dan penjual.
     */
    public function add($productId)
    {
        $productModel = new ProductModel();
        $product = $productModel->find($productId);

        if ($product) {
            // Cek apakah stok masih tersedia
            if ($product['stock'] < 1) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Maaf, stok produk ini telah habis.']);
            }

            $cart = $this->session->get('cart') ?? [];

            // Cek penjual (jika keranjang tidak kosong)
            if (!empty($cart)) {
                $firstItem = reset($cart);
                if ($product['seller_id'] != $firstItem['seller_id']) {
                    return $this->response->setJSON(['status' => 'error', 'message' => 'Anda hanya bisa membeli dari satu penjual dalam satu waktu.']);
                }
            }
            
            // Cek apakah kuantitas di keranjang akan melebihi stok yang ada
            $cartQuantity = isset($cart[$productId]) ? $cart[$productId]['quantity'] : 0;
            if ($product['stock'] <= $cartQuantity) {
                 return $this->response->setJSON(['status' => 'error', 'message' => 'Maaf, kuantitas melebihi stok yang tersedia.']);
            }

            // Lanjutkan proses penambahan ke keranjang
            if (isset($cart[$productId])) {
                $cart[$productId]['quantity']++;
            } else {
                $cart[$productId] = [
                    'id'        => $product['id'],
                    'seller_id' => $product['seller_id'],
                    'name'      => $product['name'],
                    'price'     => $product['price'],
                    'quantity'  => 1,
                    'image'     => $product['image']
                ];
            }
            
            $this->session->set('cart', $cart);
            return $this->response->setJSON(['status' => 'success', 'message' => 'Produk berhasil ditambahkan!', 'total_items' => array_sum(array_column($cart, 'quantity'))]);
        }
        return $this->response->setStatusCode(404);
    }

    /**
     * Memperbarui kuantitas item di keranjang.
     */
    public function update()
    {
        $cart = $this->session->get('cart') ?? [];
        $productId = $this->request->getPost('product_id');
        $quantity = $this->request->getPost('quantity');

        if (isset($cart[$productId])) {
            if ($quantity > 0) {
                $cart[$productId]['quantity'] = $quantity;
            } else {
                unset($cart[$productId]); // Hapus jika kuantitas 0 atau kurang
            }
        }
        $this->session->set('cart', $cart);

        // Jika ini adalah request AJAX, kirim kembali data JSON
        if ($this->request->isAJAX()) {
            $total = 0;
            foreach($cart as $item) {
                $total += $item['price'] * $item['quantity'];
            }

            return $this->response->setJSON([
                'status' => 'success',
                'new_subtotal' => 'Rp ' . number_format($cart[$productId]['price'] * $quantity, 0, ',', '.'),
                'new_total' => 'Rp ' . number_format($total, 0, ',', '.'),
                'total_items' => array_sum(array_column($cart, 'quantity'))
            ]);
        }
        
        return redirect()->to('/cart');
    }

    /**
     * Menghapus satu item dari keranjang.
     */
    public function remove($productId)
    {
        $cart = $this->session->get('cart');
        if (isset($cart[$productId])) {
            unset($cart[$productId]);
        }
        $this->session->set('cart', $cart);
        return redirect()->to('/cart');
    }

    /**
     * Mengosongkan seluruh isi keranjang.
     */
    public function clear()
    {
        $this->session->remove('cart');
        return redirect()->to('/cart');
    }
}