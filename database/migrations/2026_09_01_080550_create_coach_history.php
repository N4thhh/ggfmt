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
        Schema::create('coach_histories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('mt_id')->constrained('management_trainees', 'id')->onDelete('cascade');
            $table->foreignUuid('coach_id')->constrained('coaches', 'id')->onDelete('cascade');
            $table->foreignUuid('assigned_by')->nullable()->constrained('users', 'id')->nullOnDelete();
            $table->timestamp('started_at')->useCurrent();
            $table->timestamp('ended_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coach_histories');
    }
};
