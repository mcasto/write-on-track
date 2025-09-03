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
        Schema::create('submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('market_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->integer('word_count');
            $table->text('notes')->nullable();
            $table->date('submitted_at');
            $table->enum('status', [
                'submitted',
                'accepted',
                'rejected',
                'withdrawn',
                'expired'
            ])->default('submitted');
            $table->date('response_date')->nullable();
            $table->text('response_notes')->nullable();
            $table->decimal('payment_amount', 10, 2)->nullable();
            $table->string('payment_currency', 3)->default('USD');
            $table->date('payment_date')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'status']);
            $table->index('submitted_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('submissions');
    }
};
