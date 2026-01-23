<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyPhoneNumber extends Model
{
    use HasFactory;
    protected $table = 'company_phone_numbers';
    protected $fillable = ['phone_number','use_whatsapp'];
}
