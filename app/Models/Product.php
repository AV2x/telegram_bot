<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'category_id', 'price', 'counts','property_id', 'count_type'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort', 'asc');
    }
    public function properties()
    {
        return $this->belongsToMany(Property::class, 'property_products', 'product_id', 'property_id')
            ->select('properties.*', 'property_products.value as value');
    }
    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_products', 'product_id', 'order_id');
    }
}
