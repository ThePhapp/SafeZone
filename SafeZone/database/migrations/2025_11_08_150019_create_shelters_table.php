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
        Schema::create('shelters', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('address');
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->integer('capacity')->default(0);
            $table->string('type')->default('general'); // general, medical, temporary
            $table->string('status')->default('active'); // active, full, closed
            $table->string('contact_phone')->nullable();
            $table->string('contact_email')->nullable();
            $table->json('facilities')->nullable(); // ['water', 'food', 'medical', 'electricity']
            $table->string('image_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shelters');
    }
};
