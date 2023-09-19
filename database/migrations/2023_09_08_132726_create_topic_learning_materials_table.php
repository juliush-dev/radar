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
        Schema::create('topic_learning_materials', function (Blueprint $table) {
            $table->foreignUuid('topic_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('learning_material_id')->constrained()->cascadeOnDelete();
            $table->primary(['topic_id', 'learning_material_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('topic_learning_materials');
    }
};
