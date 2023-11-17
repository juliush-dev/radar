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
        Schema::table('knowledge_cubes', function (Blueprint $table) {
            $table->foreignUuid('potential_replacement_of')->nullable()->constrained('knowledge_cubes')->nullOnDelete();
            $table->foreignUuid('potential_replacement')->nullable()->constrained('knowledge_cubes')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('knowledge_cubes', function (Blueprint $table) {
            //
        });
    }
};
