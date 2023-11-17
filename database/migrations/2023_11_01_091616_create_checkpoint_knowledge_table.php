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
        Schema::create('checkpoint_knowledge', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('knowledge_cube_id')->nullable()->constrained('knowledge_cubes')->nullOnDelete();
            $table->foreignUuid('user_id')->nullable()->constrained()->nullOnDelete();
            $table->boolean('assisted')->default(false);
            $table->longText('information');
            $table->longText('bridge');
            $table->longText('implications')->nullable();
            $table->string('external_reference')->nullable();
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
        Schema::dropIfExists('checkpoint_knowledge');
    }
};
