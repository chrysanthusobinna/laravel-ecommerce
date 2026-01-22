<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Size;
use App\Models\ProductLabel;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = ['name', 'description', 'price', 'category_id', 'product_label_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }


    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function primaryImage()
    {
        return $this->hasOne(ProductImage::class, 'product_id')->where('is_primary', 1);
    }

    public function sizes()
    {
        return $this->belongsToMany(Size::class);
    }

    // public function label()
    // {
    //     return $this->belongsTo(ProductLabel::class);
    // }


    public function label()
    {
        return $this->belongsTo(ProductLabel::class, 'product_label_id');
    }

}
