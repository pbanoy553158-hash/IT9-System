<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::table('orders', function (Blueprint $blueprint) {

        if (!Schema::hasColumn('orders', 'priority')) {
                $blueprint->string('priority')->default('standard')->after('quantity');
            }
            if (!Schema::hasColumn('orders', 'notes')) {
                $blueprint->text('notes')->nullable()->after('priority');
            }
            if (!Schema::hasColumn('orders', 'total_amount')) {
                $blueprint->decimal('total_amount', 12, 2)->default(0)->after('notes');
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['priority', 'notes', 'total_amount']);
        });
    }
};