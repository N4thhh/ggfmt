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
        Schema::create('assignments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('mt_id')->constrained('management_trainees', 'id')->onDelete('cascade');
            $table->string('title');
            $table->enum('phase', ['Phase 1', 'Phase 2', 'Phase 3']);
            $table->string('file_path')->nullable();
            $table->timestamp('uploaded_at')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assignments');
    }
};
