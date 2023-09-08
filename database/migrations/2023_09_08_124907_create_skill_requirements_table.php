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
        Schema::create('skill_requirements', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('skill_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('topic_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skill_requiremnts');
    }
};
