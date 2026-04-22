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
        Schema::create('panorama_projects', function (Blueprint $table) {
            $table->id();
            $table->string('panorama_url')->nullable();
            $table->string('panorama_job_id')->nullable();
            $table->string('design_style')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('panorama_projects');
    }
};
