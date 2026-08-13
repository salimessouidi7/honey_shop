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

            // Nullable because customers can checkout as guests (no account required)
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

            // Guest / shipping info collected at checkout
            $table->string('guest_name');
            $table->string('guest_email');
            $table->string('guest_phone')->nullable();
            $table->text('guest_address');

            $table->decimal('total', 10, 2);
            $table->string('status')->default('pending'); // pending, paid, shipped, completed, cancelled

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
