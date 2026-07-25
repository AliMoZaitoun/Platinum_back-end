<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contract_exceptions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('contract_id')->constrained()->cascadeOnDelete();
            $table->foreignId('requested_by')->constrained('employees');
            $table->foreignId('action_by')->nullable()->constrained('employees');

            $table->decimal('original_total_price', 15, 2)->unsigned();
            $table->decimal('requested_total_price', 15, 2)->unsigned();

            $table->double('original_down_payment');
            $table->double('requested_down_payment');

            $table->integer('original_installments_count');
            $table->integer('requested_installments_count');

            $table->text('reason');
            $table->text('rejection_reason')->nullable();

            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contract_exceptions');
    }
};
