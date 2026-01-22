<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Product;

class Size extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'short_name'];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
