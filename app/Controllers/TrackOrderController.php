<?php

namespace App\Controllers;

use App\Models\OrderModel;

class TrackOrderController extends BaseController
{
    /**
     * Menampilkan halaman form untuk melacak pesanan.
     */
    public function index()
    {
        return view('track/index');
    }

    /**
     * Memproses pencarian pesanan berdasarkan ID.
     */
    public function track()
    {
        $orderId = $this->request->getPost('order_id');

        if (empty($orderId)) {
            return redirect()->back()->with('error', 'Silakan masukkan ID Pesanan.');
        }

        $orderModel = new OrderModel();
        // Cari pesanan berdasarkan ID yang dimasukkan
        $order = $orderModel->find($orderId);

        // Kirim data pesanan (atau null jika tidak ditemukan) ke view
        $data['order'] = $order;
        return view('track/index', $data);
    }
}
