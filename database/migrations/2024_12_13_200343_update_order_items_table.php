<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            // Drop the foreign key constraint
            $table->dropForeign(['product_id']); // Replace 'product_id' with the actual name of your foreign key if different
            
            // Remove the 'product_id' column
            $table->dropColumn('product_id');

            // Add the 'product_name' column
            $table->string('product_name')->after('id'); // Adjust 'after' based on your column order preference
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            // Add back the 'product_id' column
            $table->unsignedBigInteger('product_id')->after('id');

            // Recreate the foreign key constraint
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');

            // Remove the 'product_name' column
            $table->dropColumn('product_name');
        });
    }
}
