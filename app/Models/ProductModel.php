<?php namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'id';
    protected $allowedFields = ['seller_id', 'category_id', 'name', 'description', 'price', 'unit', 'stock', 'image'];
}