<?php

use App\Enums\Reports\InsightSeverity;
use App\Enums\Reports\InsightType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('construction_insights', function (Blueprint $table) {
            $table->id();
            $table->foreignId('building_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('construction_report_id')->constrained()->cascadeOnDelete();
            $table->string('phase');

            $table->string('type')->default(InsightType::LABOR_OVERCROWDING->value);
            $table->string('severity')->default(InsightSeverity::WARNING->value);

            $table->json('title');
            $table->json('diagnosis');
            $table->json('recommendation')->nullable();
            $table->json('metrics')->nullable();

            $table->boolean('is_read')->default(false);
            $table->timestamp('resolved_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('construction_insights');
    }
};
