<?php

// app/Models/CartOrder.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
        'price',
        'cart_id',
        'status',
        'payment_method',
        'payment_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payment()
    {
        return $this->belongsTo(PaymentDetail::class, 'payment_id');
    }
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
