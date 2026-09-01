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
        Schema::create('panelist_access', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('panelist_id')->constrained('panelists', 'id')->onDelete('cascade');
            $table->foreignUuid('assignment_id')->constrained('assignments', 'id')->onDelete('cascade');
            $table->foreignUuid('assigned_by')->nullable()->constrained('users', 'id')->nullOnDelete();
            $table->timestamp('assigned_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('panelist_access');
    }
};
