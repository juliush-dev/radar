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
        Schema::table('topics', function (Blueprint $table) {
            $table->foreignUuid('potential_replacement')->nullable()->constrained('topics')->nullOnDelete();
            $table->foreignUuid('potential_replacement_of')->nullable()->constrained('topics')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('learning-materials', function (Blueprint $table) {
            //
        });
    }
};