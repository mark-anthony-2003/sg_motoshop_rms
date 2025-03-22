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
        Schema::create('employees', function (Blueprint $table) {
            $table->id('employee_id');
            $table->uuid('user_id');
            //$table->foreignId('service_transaction_id')->nullable()->constrained('service_transactions', 'service_transaction_id')->onDelete('cascade');
            $table->foreignId('salary_type_id')->constrained('salary_types', 'salary_type_id')->onDelete('cascade');
            $table->foreignId('position_type_id')->constrained('position_types', 'position_type_id')->onDelete('cascade');
            $table->date('date_hired');
            $table->timestamps();

            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
