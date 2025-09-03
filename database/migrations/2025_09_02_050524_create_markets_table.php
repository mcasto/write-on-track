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
        Schema::create('markets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Owner/Creator
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('website')->nullable();
            $table->string('submission_url')->nullable();
            $table->string('genre')->nullable();
            $table->string('payment_type')->nullable(); // pro-rate, per-word, flat, etc.
            $table->decimal('payment_rate', 10, 2)->nullable();
            $table->string('payment_currency', 3)->default('USD');
            $table->integer('word_count_min')->nullable();
            $table->integer('word_count_max')->nullable();
            $table->enum('status', ['active', 'closed', 'on_hiatus', 'unknown'])->default('active');
            $table->boolean('is_public')->default(false); // For potential future public DB
            $table->boolean('is_verified')->default(false); // For potential future verification
            $table->timestamps();
            $table->softDeletes();

            $table->index(['user_id', 'is_public']);
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('markets');
    }
};
