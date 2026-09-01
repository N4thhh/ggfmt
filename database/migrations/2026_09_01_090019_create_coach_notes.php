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
        Schema::create('coach_notes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('coach_id')->constrained('coaches', 'id')->onDelete('cascade');
            $table->foreignUuid('mt_id')->constrained('management_trainees', 'id')->onDelete('cascade');
            $table->text('summary_of_issues');
            $table->text('specific_actions');
            $table->text('progress');
            $table->text('notes');
            $table->text('comments');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coach_notes');
    }
};
