<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $table = 'details';
    protected $primaryKey = 'idorderdetail';
    public $timestamps = true;

    protected $fillable = [
        'idorder',
        'idmenu',
        'jumlah',
        'hargajual'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'idorder', 'idorder');
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'idmenu', 'idmenu');
    }
}
