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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('warehouse_id')->constrained()->onDelete('cascade');
            $table->string('sku')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('quantity');
            $table->enum('status', ['in_stock', 'out_of_stock', 'discontinued']);
            $table->date('expiry_date')->nullable();
            $table->date('purchase_date')->nullable();
            $table->date('received_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
