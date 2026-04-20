<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Supplier link (IMPORTANT FIX)
            $table->foreignId('supplier_id')->nullable()->constrained()->onDelete('cascade');

            $table->string('order_number')->unique();

            $table->string('product_name');
            $table->integer('quantity');

            $table->decimal('total_amount', 10, 2);

            $table->enum('status', [
                'Pending',
                'Processing',
                'Shipped',
                'Delivered',
                'Rejected'
            ])->default('Pending');

            $table->enum('priority', [
                'standard',
                'high',
                'critical'
            ])->default('standard');

            $table->text('notes')->nullable();

            $table->date('delivery_date')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};