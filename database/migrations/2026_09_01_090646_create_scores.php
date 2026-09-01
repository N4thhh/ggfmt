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
        Schema::create('scores', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('panelist_id')->constrained('panelists', 'id')->onDelete('cascade');
            $table->foreignUuid('assignment_id')->constrained('assignments', 'id')->onDelete('cascade');
            $table->float('score')->nullable();
            $table->text('comments')->nullable();
            $table->timestamp('submitted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scores');
    }
};
