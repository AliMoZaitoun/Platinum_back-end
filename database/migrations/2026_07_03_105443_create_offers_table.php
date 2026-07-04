<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('advertisement_id')->nullable()->constrained()->onDelete('set null');
            $table->morphs('offerable');

            $table->decimal('discount_percentage');

            $table->decimal('old_price', 12, 2);
            $table->decimal('new_price', 12, 2);

            $table->timestamp('start_date');
            $table->timestamp('end_date')->nullable();

            $table->boolean('status')->default(true);
            $table->foreignId('created_by')->nullable()->constrained('employees');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('offers');
    }
};
