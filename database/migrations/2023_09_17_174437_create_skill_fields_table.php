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
        Schema::create('skill_fields', function (Blueprint $table) {
            $table->foreignUuid('skill_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('field_id')->constrained()->cascadeOnDelete();
            $table->primary(['skill_id', 'field_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skill_fields');
    }
};
