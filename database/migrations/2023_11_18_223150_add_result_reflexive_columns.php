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
        Schema::table('user_checkpoint_session_results', function (Blueprint $table) {
            $table->foreignUuid('potential_replacement_of')->nullable()->constrained('user_checkpoint_session_results')->nullOnDelete();
            $table->foreignUuid('potential_replacement')->nullable()->constrained('user_checkpoint_session_results')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_checkpoint_session_results', function (Blueprint $table) {
            //
        });
    }
};
