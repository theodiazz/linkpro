<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('urls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title')->nullable();
            $table->text('original_url');
            $table->string('short_code')->unique();
            $table->string('password')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->boolean('is_custom')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            // Índices para búsquedas frecuentes
            $table->index('short_code');
            $table->index(['user_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('urls');
    }
};
