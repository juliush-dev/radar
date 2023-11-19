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
        Schema::create('user_checkpoint_sessions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained()->nullOnDelete();
            $table->foreignUuid('checkpoint_id')->constrained()->cascadeOnDelete();
            $table->boolean('started')->default(true);
            $table->integer('countdown')->default(60);
            $table->integer('end_countdown')->default(60);
            $table->boolean('ended')->default(false);
            $table->boolean('is_update')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_checkpoint_sessions');
    }
};
