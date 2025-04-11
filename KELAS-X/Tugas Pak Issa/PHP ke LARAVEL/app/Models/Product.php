<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'image', 'price', 'discount', 'release_status', 'category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function productImages()
    {
        return $this->hasMany(ProductImage::class);
    }
}
