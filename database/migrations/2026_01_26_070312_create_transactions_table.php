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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->string('payment_method')->nullable(); // midtrans, cash, qris
            $table->string('reference_number')->nullable();
            $table->string('payment_status')->default('pending'); // pending, settlement, expire, deny
            $table->string('payment_type')->nullable();
            $table->string('snap_token')->nullable();
            $table->decimal('gross_amount', 10, 2);
            $table->timestamp('transaction_time')->nullable();
            $table->string('va_number')->nullable();
            $table->timestamp('expired_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
