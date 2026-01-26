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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('cafe_id')->constrained()->cascadeOnDelete();
            $table->foreignId('table_id')->nullable()->constrained()->onDelete('set null');
            $table->string('type'); // online, takeaway, dine_in
            $table->string('status')->default('pending'); // pending, paid, preparing, completed, cancelled
            $table->decimal('total_price', 10, 2);
            $table->decimal('tax_amount', 10, 2)->default(0);
            $table->softDeletes();
            $table->timestamps();
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
