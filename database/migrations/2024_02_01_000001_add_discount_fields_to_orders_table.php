<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('subtotal', 10, 2)->default(0)->after('user_id');
            $table->unsignedTinyInteger('discount_percent')->default(0)->after('subtotal');
            $table->decimal('discount_amount', 10, 2)->default(0)->after('discount_percent');
            // 'total' already exists - it now represents the final amount AFTER discount
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['subtotal', 'discount_percent', 'discount_amount']);
        });
    }
};
