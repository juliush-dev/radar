<?php

use App\Enums\TopicField;
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
        Schema::create('topics', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->enum(
                'year_teached_at',
                array_column(YearLevel::cases(), 'value'),
            );
            $table->enum(
                'topic_field',
                array_column(TopicField::cases(), 'value'),
            );
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('topics');
    }
};
