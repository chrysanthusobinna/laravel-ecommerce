<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::rename('restaurant_phone_numbers', 'business_phone_numbers');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::rename('business_phone_numbers', 'restaurant_phone_numbers');
    }
};
