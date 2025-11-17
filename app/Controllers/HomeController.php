<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\CategoryModel;

class HomeController extends BaseController
{
    public function index()
    {
        $productModel = new ProductModel();
        $categoryModel = new CategoryModel(); 

        // Ambil data produk (ini tidak berubah)
        $data['products'] = $productModel
            ->select('products.*, users.full_name as seller_name, users.prodi, users.kelas')
            ->join('users', 'users.id = products.seller_id')
            ->where('stock >', 0)
            ->findAll();
        
        // PERBAIKAN: Ambil data kategori dan urutkan berdasarkan 'sort_order'
        $data['categories'] = $categoryModel->orderBy('sort_order', 'ASC')->findAll();
        
        return view('shop/home', $data);
    }
}