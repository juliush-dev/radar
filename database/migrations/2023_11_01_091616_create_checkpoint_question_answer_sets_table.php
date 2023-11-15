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
        Schema::create('checkpoint_question_answer_sets', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('questions_cube_id')->nullable()->constrained('questions_cubes')->nullOnDelete();
            $table->foreignUuid('user_id')->nullable()->constrained()->nullOnDelete();
            $table->boolean('is_cloze')->default(false);
            $table->boolean('is_assisted_cloze')->default(false);
            $table->boolean('is_flash_card')->default(false);
            $table->tinyText('subject')->nullable();
            $table->longText('question');
            $table->longText('answer');
            $table->longText('answer_in_place_explanation')->nullable();
            $table->string('answer_explanation_redirect')->nullable();
            $table->boolean('is_public')->default(false);
            $table->boolean('is_update')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checkpoint_question_answer_sets');
    }
};
