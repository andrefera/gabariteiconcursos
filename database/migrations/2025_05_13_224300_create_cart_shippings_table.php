<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cart_shippings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cart_id')->index();
            $table->foreign('cart_id')->references('id')->on('carts');
            $table->unsignedBigInteger('address_id');
            $table->foreign('address_id')->references('id')->on('user_addresses');
            $table->string('company');
            $table->string('name');
            $table->integer('days');
            $table->decimal('price', 12, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_shippings');
    }
};
