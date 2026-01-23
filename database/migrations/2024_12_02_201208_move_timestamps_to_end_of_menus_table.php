<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
 
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropTimestamps(); // Remove existing timestamps
        });

        Schema::table('products', function (Blueprint $table) {
            $table->timestamps(); // Re-add timestamps at the end of the table
        });
    }

 
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropTimestamps(); // Remove timestamps from the end
        });

        Schema::table('products', function (Blueprint $table) {
            $table->timestamps(); // Re-add timestamps to the original position
        });
    }
};
