<?php

use App\Enums\Assessment;
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
        Schema::create('topic_proficiencies', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->enum(
                'assessment',
                array_column(Assessment::cases(), 'value'),
            );
            $table->foreignUuid('author_id');
            $table->foreignUuid('assessing_topic');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('topic_proficiencies');
    }
};
