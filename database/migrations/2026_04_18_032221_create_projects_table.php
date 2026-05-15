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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->json('name');
            $table->json('description')->nullable();
            $table->foreignId('location_id')->constrained()->onDelete('restrict');
            $table->decimal('latitude', 10, 8)->index()->nullable();
            $table->decimal('longitude', 11, 8)->index()->nullable();
            $table->integer('radius_meters');
            $table->enum('status', ['completed', 'in_progress', 'stopped']);
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
