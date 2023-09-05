<?php

use App\Enums\KnowledgeField;
use App\Enums\YearLevel;
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
        Schema::create('knowledge', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('covered_by_subject_id');
            $table->foreignUuid('required_by_skill_id');
            $table->set(
                'year_teached_at',
                array_column(YearLevel::cases(), 'value'),
            );
            $table->set(
                'knowledge_field',
                array_column(KnowledgeField::cases(), 'value'),
            );
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('knowledge');
    }
};