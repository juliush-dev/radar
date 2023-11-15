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
        Schema::table('checkpoint_question_answer_sets', function (Blueprint $table) {
            $table->foreignUuid('questions_cube_id')->nullable()->constrained('questions_cubes')->nullOnDelete();
            $table->tinyText('subject')->nullable();
            // We will paginate 6 by 6 on retrievial
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('checkpoint_question_answer_sets', function (Blueprint $table) {
            //
        });
    }
};
