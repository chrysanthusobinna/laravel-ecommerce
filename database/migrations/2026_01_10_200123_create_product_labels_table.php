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
        Schema::create('product_labels', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('color')->nullable(); // For label color
            $table->timestamps();
        });

        // Add product_label_id to products table
        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('product_label_id')->nullable()->constrained()->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove product_label_id from products table
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeignId('product_label_id');
        });

        Schema::dropIfExists('product_labels');
    }
};
