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
        Schema::create('buildings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->foreignId('location_id')->nullable()->constrained()->onDelete('restrict');
            $table->string('building_number');
            $table->decimal('latitude', 10, 8)->index()->nullable();
            $table->decimal('longitude', 11, 8)->index()->nullable();
            $table->integer('radius_meters')->default(50);
            $table->json('description')->nullable();
            $table->integer('floors_count');
            $table->enum('status', ['planned', 'in_progress', 'stopped', 'completed']);

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
        Schema::dropIfExists('buildings');
    }
};
