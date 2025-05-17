<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'instructions',
        'order_id',
        'expire_time',
        'is_paid',
    ];

    protected $casts = [
        'expire_time' => 'datetime',
        'is_paid' => 'boolean',
    ];

    public function order()
    {
        return $this->hasOne(CartOrder::class, 'id', 'order_id');
    }
}
