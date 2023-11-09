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
            $table->foreignUuid('potential_replacement_of')->nullable()->constrained('checkpoint_question_answer_sets')->nullOnDelete();
            $table->foreignUuid('potential_replacement')->nullable()->constrained('checkpoint_question_answer_sets')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('checkpoint_question_answer_sets', function (Blueprint $table) {
            $table->dropColumn('potential_replacement_of');
            $table->dropColumn('potential_replacement');
        });
    }
};
