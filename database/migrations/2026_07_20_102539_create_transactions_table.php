<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();

            $table->string('voucher_number')->unique();

            $table->enum('type', ['receipt', 'payment']);

            $table->decimal('amount', 15, 2);
            $table->string('currency', 3)->default('USD');
            $table->decimal('exchange_rate', 10, 4)->default(1.0000);

            $table->nullableMorphs('transactionable');

            $table->nullableMorphs('party');

            $table->string('category', 50);

            $table->enum('payment_method', ['cash', 'bank_transfer', 'check', 'card']);

            $table->enum('status', ['draft', 'posted', 'cancelled'])->default('posted');

            $table->text('description')->nullable();

            $table->foreignId('created_by')->constrained('employees')->cascadeOnDelete();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
