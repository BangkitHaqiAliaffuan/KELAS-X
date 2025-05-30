<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menus';
    protected $primaryKey = 'idmenu';
    public $timestamps = true;

    protected $fillable = [
        'menu',
        'idkategori',
        'gambar',
        'harga'
    ];
}
