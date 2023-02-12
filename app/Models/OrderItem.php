<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $connection = 'foody_customers';
    protected $table = 'order_items'; 
    protected $fillable = ['order_id', 'product', 'quantity'];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
