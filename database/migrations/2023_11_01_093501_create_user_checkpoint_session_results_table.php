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
        Schema::create('user_checkpoint_session_results', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('session_id')->constrained('user_checkpoint_sessions')->cascadeOnDelete();
            $table->foreignUuid('knowledge_id')->constrained('checkpoint_knowledge')->cascadeOnDelete();
            $table->boolean('bridge_crossed')->default(false);
            $table->integer('progression');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_checkpoint_session_results');
    }
};
