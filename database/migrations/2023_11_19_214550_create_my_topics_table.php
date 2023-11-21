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
        Schema::create('my_topics', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('my_subject_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('topic_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('my_topics');
    }
};
