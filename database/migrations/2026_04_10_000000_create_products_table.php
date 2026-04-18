<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            
            // 1. Fixed: Match the 'supplier_id' in your Product Model
            // This links to the 'suppliers' table
            $table->foreignId('supplier_id')->constrained()->onDelete('cascade');
            
            // 2. Added: Match the 'category_id' in your Product Model
            // 'nullable' allows you to add products even before categories are set up
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');

            $table->string('name');
            $table->string('sku')->unique(); 
            $table->string('image_path')->nullable();
            $table->decimal('price', 15, 2);
            $table->integer('stock')->default(0);
            $table->string('unit')->default('pcs');
            
            // 3. Status logic: usually 'pending' for supplier systems
            $table->string('status')->default('pending');
            
            $table->softDeletes(); // Required for the 'SoftDeletes' you added to the Model
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('products');
    }
};