<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $connection = 'foody_customers';
    protected $table = 'feedback';

    protected $fillable = [
        'order_id',
        'store_id',
        'customer_name',
        'rating',
        'comment',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
