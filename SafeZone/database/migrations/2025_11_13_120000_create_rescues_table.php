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
        Schema::create('rescues', function (Blueprint $table) {
            $table->id();

            // Owner of the rescue record
            $table->foreignId('user_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();

            // Core details
            $table->string('title');
            $table->text('description')->nullable();

            // Classification & workflow
            $table->enum('status', ['pending', 'in_progress', 'completed', 'cancelled'])->default('pending');
            $table->enum('priority', ['low', 'medium', 'high', 'critical'])->default('medium');
            $table->string('type', 50)->nullable(); // e.g., evacuation, medical, supply, search, etc.

            // Timeline
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();

            // Contact & extra payload
            $table->string('contact_phone', 30)->nullable();
            $table->json('metadata')->nullable();

            $table->timestamps();

            $table->index(['user_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rescues');
    }
};
