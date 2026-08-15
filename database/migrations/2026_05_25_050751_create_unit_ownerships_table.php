<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('unit_ownerships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained();
            $table->foreignId('unit_id')->constrained();
            $table->foreignId('contract_id')->constrained()->cascadeOnDelete();

            $table->decimal('purchase_price', 15, 2)->nullable();
            $table->enum('status', ['active', 'pending', 'transferred'])->default('active');

            $table->date('owned_at')->nullable();

            $table->softDeletes();

            $table->unique(['client_id', 'unit_id', 'contract_id', 'deleted_at']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('unit_ownerships');
    }
};
