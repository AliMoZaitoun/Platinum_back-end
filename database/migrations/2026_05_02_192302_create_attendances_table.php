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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();

            $table->foreignId('engineer_id')->constrained()->onDelete('cascade');
            $table->foreignId('project_id')->constrained()->onDelete('cascade');

            $table->timestamp('check_in')->nullable();
            $table->timestamp('check_out')->nullable();

            $table->decimal('check_in_lat', 10, 8)->nullable();
            $table->decimal('check_in_lng', 11, 8)->nullable();
            $table->decimal('check_out_lat', 10, 8)->nullable();
            $table->decimal('check_out_lng', 11, 8)->nullable();

            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->string('device_id')->nullable();

            $table->timestamp('user_timestamp')->nullable();

            $table->index(['engineer_id', 'project_id']);
            $table->index('status');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
