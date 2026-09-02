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
        Schema::create('management_trainees', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->unique()->constrained('users', 'id')->onDelete('cascade');
            $table->foreignUuid('mt_program_id')->constrained('mt_programs', 'id')->onDelete('cascade');
            $table->string('index_number')->unique();
            $table->enum('status',['active', 'withdraw', 'failed', 'graduate']);//make sure sync with status logs
            $table->string('placement');
            $table->string('major');
            $table->string('university');
            $table->enum('education_degree',['S1', 'S2', 'S3', 'D3', 'D4', 'D1', 'D2']);
            $table->enum('mbti',['ISTJ', 'ISTP', 'ISFJ', 'ISFP', 'INFJ', 'INFP', 'INTJ', 'INTP', 'ESTP', 'ESTJ', 'ESFP', 'ESFJ', 'ENFP', 'ENFJ', 'ENTP', 'ENTJ']);
            $table->string('assignment_leader');
            $table->string('program_leader');
            $table->string('batch');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('management_trainees');
    }
};
