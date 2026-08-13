<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('features', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique(); // e.g. 'comments' - used in code, never shown to admin
            $table->string('name');           // e.g. 'Product Comments & Feedback' - shown in Settings
            $table->text('description')->nullable();
            $table->boolean('enabled')->default(false);

            // Unused for now - reserved so a real license-key system can be added later
            // without another migration. A key could be validated against these on a schedule.
            $table->string('license_key')->nullable();
            $table->string('license_status')->nullable(); // e.g. 'active', 'expired', 'invalid'
            $table->timestamp('license_expires_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('features');
    }
};
