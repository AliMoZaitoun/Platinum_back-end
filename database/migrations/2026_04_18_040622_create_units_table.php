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
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->foreignId('building_id')->constrained()->onDelete('cascade');
            $table->string('unit_number');
            $table->integer('floor');
            $table->integer('rooms_count')->default(0);
            $table->decimal('area');
            $table->enum('type', ['social', 'vip']);
            $table->decimal('price', 15, 2)->unsigned();
            $table->enum('status', ['available', 'reserved', 'sold', 'maintenance']);
            $table->index(['building_id', 'price', 'type'], 'idx_units_search_basic');
            $table->index(['rooms_count', 'area'], 'idx_units_specs');
            $table->index('price', 'idx_search_price');
            $table->unique(['building_id', 'unit_number']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};
