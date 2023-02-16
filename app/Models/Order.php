<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $connection = 'foody_customers';
    protected $table = 'orders'; 

    protected $fillable = ['store_id', 'order_status', 'order_date', 'total_amount', 'delivery_address'];

    public function orderItem()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    public function feedback()
    {
        return $this->hasOne(Feedback::class, 'order_id');
    }
}
