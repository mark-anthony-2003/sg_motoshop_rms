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
        Schema::create('shipments', function (Blueprint $table) {
            $table->bigIncrements('shipment_id');
            $table->foreignId('cart_id')->constrained('carts', 'cart_id')->onDelete('cascade');
            $table->unsignedBigInteger('total_amount');
            $table->enum('shipment_item_status', ['pending', 'completed', 'canceled'])->default('pending');
            $table->enum('shipment_method', ['courier', 'on_site_pickup'])->default('courier');
            $table->date('shipment_date');
            $table->enum('payment_method', ['cash_on_delivery', 'gcash'])->default('cash_on_delivery');
            $table->enum('payment_status', ['paid', 'pending', 'failed'])->default('pending');
            $table->string('payment_reference')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};
