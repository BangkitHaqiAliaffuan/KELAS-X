<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'idorder';
    public $timestamps = true;

    protected $fillable = [
        'idpelanggan',
        'tglorder',
        'total',
        'bayar',
        'kembali',
        'status'
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'idpelanggan', 'idpelanggan');
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'idorder', 'idorder');
    }
}
