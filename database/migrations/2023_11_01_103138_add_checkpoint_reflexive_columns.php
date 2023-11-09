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
        Schema::table('checkpoints', function (Blueprint $table) {
            $table->foreignUuid('potential_replacement_of')->nullable()->constrained('checkpoints')->nullOnDelete();
            $table->foreignUuid('potential_replacement')->nullable()->constrained('checkpoints')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('checkpoints', function (Blueprint $table) {
            $table->dropColumn('potential_replacement_of');
            $table->dropColumn('potential_replacement');
        });
    }
};
