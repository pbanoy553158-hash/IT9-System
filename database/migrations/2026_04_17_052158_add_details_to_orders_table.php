<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            
        });
    }
 
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('priority')->default('standard');
            $table->text('notes')->nullable();
            $table->decimal('total_price', 12, 2)->default(0);
        });
    }
};