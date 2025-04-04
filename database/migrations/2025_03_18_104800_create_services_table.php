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
        Schema::create('services', function (Blueprint $table) {
            $table->id('service_id');
            $table->decimal('total_amount', 10, 2);
            $table->enum('payment_method', ['cash', 'gcash'])->default('cash');
            $table->enum('payment_status', ['pending', 'completed'])->default('pending');
            $table->string('ref_no')->nullable();
            $table->date('preferred_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
