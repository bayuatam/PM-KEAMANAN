<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table            = 'orders';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    // Izinkan kolom-kolom ini untuk diisi
    protected $allowedFields    = [
        'order_id',
        'customer_name',
        'customer_whatsapp',
        'total_amount',
        'payment_method',
        'order_status',
        'logistics_officer_id'
    ];

    // Nonaktifkan fitur timestamp otomatis
    protected $useTimestamps = false;
}
