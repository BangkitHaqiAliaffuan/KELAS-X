<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OwnedGame extends Model
{
    protected $fillable = ['user_id', 'product_id', 'purchase_date', 'install_status', 'is_favorite'];

    // Relasi ke model Product
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    // Cast purchase_date sebagai tanggal
    protected $casts = [
        'purchase_date' => 'datetime',
        'is_favorite' => 'boolean',
    ];
}
