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
        Schema::create('note_category', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('relation')->nullable();
            $table->foreignUuid('note_id')->nullable()->constrained('notes')->nullOnDelete();
            $table->foreignUuid('category_id')->nullable()->constrained('notes')->nullOnDelete();
            $table->foreignUuid('user_id')->nullable()->constrained()->nullOnDelete();
            $table->boolean('is_public')->default(false);
            $table->boolean('is_update')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('note_category');
    }
};
