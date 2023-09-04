<?php

use App\Enums\Source;
use App\Enums\Visibility;
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
        Schema::create('contributions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('contributor_id');
            $table->foreignUuid('modification_request_id');
            $table->uuid('contribution_id');
            $table->string('contribution_type');
            $table->enum(
                'visibility',
                array_column(Visibility::cases(), 'value'),
            );
            $table->string("title");
            $table->enum(
                'source',
                array_column(Source::cases(), 'value'),
            );
            $table->string("link")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contributions');
    }
};
