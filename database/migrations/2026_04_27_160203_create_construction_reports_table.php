<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('construction_reports', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->foreignId('engineer_id')->constrained()->onDelete('cascade');

            $table->enum('phase', [
                'excavation',    // الحفريات
                'foundation',    // الأساسات
                'structural',    // الهيكل الخرساني
                'finishing',     // الإكساء
                'electrical',    // الكهرباء
                'plumbing'       // السباكة
            ]);

            $table->integer('completion_percentage')->unsigned();
            $table->integer('daily_progress')->unsigned();
            $table->enum('status', ['on_track', 'delayed', 'blocked'])->default('on_track');
            $table->integer('manpower_count')->unsigned()->default(0);
            $table->integer('issues_count')->unsigned()->default(0);
            $table->text('description')->nullable();
            $table->date('report_date');

            $table->index(['project_id', 'report_date']);
            $table->index('phase');
            $table->index('status');

            $table->timestamp('engineer_created_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('construction_reports');
    }
};
