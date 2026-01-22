<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
 
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'pickup_address_id')) {
                // Drop old FK (if exists)
                try {
                    $table->dropForeign(['pickup_address_id']);
                } catch (\Exception $e) {}

                // Drop old column
                $table->dropColumn('pickup_address_id');
            }
        });

  
        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('pickup_address_id')
                  ->nullable()
                  ->after('delivery_address_id');
        });

 
        Schema::table('orders', function (Blueprint $table) {
            $table->foreign('pickup_address_id')
                  ->references('id')
                  ->on('company_addresses')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
 
    }
};
