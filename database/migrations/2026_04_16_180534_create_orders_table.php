<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            
            // Link to the user who is a supplier (Ref: Page 28)
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); 
            
            // Unique order identifier (Ref: Page 124)
            $table->string('order_number')->unique(); 
            
            // Product details (Ref: Pages 176-177)
            $table->string('product_name'); 
            $table->integer('quantity'); 
            
            // Financials (Ref: Page 178)
            $table->decimal('total_amount', 10, 2); 
            
            // Order Lifecycle Status (Ref: Page 181)
            $table->enum('status', ['Pending', 'Processing', 'Shipped', 'Delivered'])->default('Pending'); 
            
            // Delivery info (Ref: Page 180)
            $table->date('delivery_date')->nullable(); 
            
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