<?php

use App\Enums\ModificationRequestState;
use App\Enums\ModificationType;
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
        Schema::create('modification_requests', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string("reason")->nullable();
            $table->enum(
                'modification_request_state',
                array_column(ModificationRequestState::cases(), 'value'),
            );
            $table->enum(
                'modification_type',
                array_column(ModificationType::cases(), 'value'),
            );
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modification_requests');
    }
};
