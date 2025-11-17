<?php

namespace App\Controllers;

use App\Models\OrderModel;
use App\Models\OrderItemModel;

class LogisticsController extends BaseController
{
    public function index()
    {
        $orderModel = new OrderModel();

        // Ambil pesanan yang sedang diproses penjual
        $data['processing_orders'] = $orderModel
            ->select('orders.id, orders.customer_name, users.full_name as seller_name')
            ->join('order_items', 'order_items.order_id = orders.id')
            ->join('products', 'products.id = order_items.product_id')
            ->join('users', 'users.id = products.seller_id')
            ->where('orders.order_status', 'processing')
            ->groupBy('orders.id, orders.customer_name, users.full_name')
            ->findAll();

        // Ambil pesanan yang siap diambil pembeli
        $data['ready_for_pickup_orders'] = $orderModel
            ->select('id, customer_name, payment_method')
            ->where('order_status', 'at_logistics')
            ->findAll();

        // AMBIL PESANAN YANG SUDAH SELESAI
        $data['completed_orders'] = $orderModel
            ->select('orders.id, orders.customer_name, orders.created_at, users.full_name as logistics_officer_name')
            ->join('users', 'users.id = orders.logistics_officer_id', 'left') // LEFT JOIN untuk jaga-jaga jika petugas dihapus
            ->where('orders.order_status', 'completed')
            ->orderBy('orders.created_at', 'DESC')
            ->findAll();

        return view('logistics/dashboard', $data);
    }

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

        return view('logistics/detail', $data);
    }

    public function confirmReception($orderId)
    {
        $orderModel = new OrderModel();
        $logisticsOfficerId = session()->get('user_id'); 

        $data = [
            'order_status' => 'at_logistics',
            'logistics_officer_id' => $logisticsOfficerId
        ];

        $orderModel->update($orderId, $data);
        return redirect()->to('/logistics')->with('success', 'Pesanan #' . $orderId . ' berhasil dikonfirmasi dan siap diambil pembeli.');
    }

    public function confirmPickup($orderId)
    {
        $orderModel = new OrderModel();
        $orderModel->update($orderId, ['order_status' => 'completed']);
        return redirect()->to('/logistics')->with('success', 'Pesanan #' . $orderId . ' telah diserahkan kepada pelanggan.');
    }
}