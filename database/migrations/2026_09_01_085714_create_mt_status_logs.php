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
        Schema::create('mt_status_logs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('mt_id')->constrained('management_trainees', 'id')->onDelete('cascade');
            $table->enum('status', ['active', 'withdraw', 'failed', 'graduate']);
            $table->foreignUuid('changed_by')->nullable()->constrained('users', 'id')->nullOnDelete();
            $table->timestamp('changed_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mt_status_logs');
    }
};
