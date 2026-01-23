<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('company_addresses', function (Blueprint $table) {
            $table->id();

            $table->enum('label', ['delivery', 'billing'])->default('delivery');

            $table->string('street')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('country')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->boolean('is_default')->default(false);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('company_addresses');
    }
};
