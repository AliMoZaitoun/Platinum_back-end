<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->cascadeOnDelete();
            $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
            $table->foreignId('contract_id')->constrained()->cascadeOnDelete();
            $table->decimal('amount', 15, 2)->unsigned();

            $table->timestamp('payment_date');
            $table->enum('payment_method', ['cash', 'bank_transfer', 'check', 'card'])->default('cash');
            $table->enum('payment_type', ['down_payment', 'installment', 'final_payment', 'maintenance_fees'])->default('installment');
            $table->enum('status', ['pending', 'paid', 'failed', 'refunded'])->default('pending');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
