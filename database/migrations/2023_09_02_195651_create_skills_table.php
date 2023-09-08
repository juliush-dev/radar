<?php

use App\Enums\TopicField;
use App\Enums\TopicGroup;
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
        Schema::create('skills', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->set(
                'fields_covered_by_it',
                array_column(TopicField::cases(), 'value',)
            )->nullable();
            $table->set(
                'years_levels_covering_it',
                array_column(YearLevel::cases(), 'value'),
            )->nullable();
            $table->enum(
                'topic_group_covering_it',
                array_column(TopicGroup::cases(), 'value'),
            )->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skills');
    }
};
