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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('increment_id')->index()->nullable();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('cart_id');
            $table->foreign('cart_id')->references('id')->on('carts');
            $table->unsignedBigInteger('address_id');
            $table->foreign('address_id')->references('id')->on('user_addresses');
            $table->string('status');
            $table->string('method');
            $table->decimal('total_price', 12, 2);
            $table->decimal('final_price', 12, 2);
            $table->decimal('discount', 12, 2)->default(0);
            $table->integer('installments')->default(1);
            $table->decimal('installment_price', 12, 2);
            $table->unsignedBigInteger('coupon_id')->nullable();
            $table->foreign('coupon_id')->references('id')->on('coupons');
            $table->string('shipping_company');
            $table->decimal('shipping_price', 12, 2)->nullable();
            $table->string('shipping_method');
            $table->string('shipping_days', 3)->nullable();
            $table->string("remote_ip", 39)->nullable();
            $table->string('user_agent')->nullable();
            $table->dateTime('paid_at')->nullable();
            $table->dateTime('cancelled_at')->nullable();
            $table->dateTime('refunded_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
