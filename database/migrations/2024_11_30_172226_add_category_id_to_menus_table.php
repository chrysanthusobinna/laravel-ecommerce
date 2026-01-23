<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
 
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            // Adding category_id column and setting up the foreign key constraint
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
        });
    }

 
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            // Drop foreign key constraint and category_id column
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
        });
    }
};
