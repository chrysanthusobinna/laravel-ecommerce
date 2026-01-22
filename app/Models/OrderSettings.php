<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderSettings extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'price_per_mile',
        'distance_limit_in_miles',
        'vat_percentage',
    ];

 
}
