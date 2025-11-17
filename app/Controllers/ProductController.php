<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\CategoryModel; 

class ProductController extends BaseController
{
    /**
     * Menampilkan halaman daftar SEMUA produk.
     */
    public function index()
    {
        $productModel = new ProductModel();
        
        $data['products'] = $productModel
            ->where('stock >', 0)
            ->findAll();
        
        $data['page_title'] = "Semua Produk"; 
        
        return view('products/index', $data);
    }

    /**
     * Menampilkan produk berdasarkan kategori.
     */
    public function category($id)
    {
        $productModel = new ProductModel();
        $categoryModel = new CategoryModel();

        $data['products'] = $productModel
            ->where('stock >', 0)
            ->where('products.category_id', $id)
            ->findAll();
        
        $category = $categoryModel->find($id);
        $data['page_title'] = "Kategori: " . esc($category['name'] ?? 'Tidak Ditemukan');
        
        return view('products/index', $data); 
    }

    /**
     * Menampilkan halaman detail untuk satu produk berdasarkan ID,
     * beserta informasi penjualnya.
     */
    public function detail($id = null)
    {
        $productModel = new ProductModel();
        
        // Query untuk menggabungkan data produk dengan data penjual
        $data['product'] = $productModel
            ->select('products.*, users.full_name as seller_name, users.prodi, users.kelas')
            ->join('users', 'users.id = products.seller_id')
            ->where('products.id', $id)
            ->first(); 

        if (empty($data['product'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Produk tidak ditemukan: '. $id);
        }

        return view('products/detail', $data);
    }
}