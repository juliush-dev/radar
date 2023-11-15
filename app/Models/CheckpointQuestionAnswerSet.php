<?php

namespace App\Models;

use App\Models\Checkpoint\Checkpoint;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CheckpointQuestionAnswerSet extends Model
{
    use HasFactory, HasUuids;

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function checkpoint(): BelongsTo
    {
        return $this->belongsTo(Checkpoint::class);
    }

    public function questionsCube(): BelongsTo
    {
        return $this->belongsTo(QuestionsCube::class);
    }

    public function potentialReplacement(): BelongsTo
    {
        return $this->belongsTo(CheckpointQuestionAnswerSet::class, 'potential_replacement');
    }

    public function potentialReplacementOf(): BelongsTo
    {
        return $this->belongsTo(CheckpointQuestionAnswerSet::class, 'potential_replacement_of');
    }
}
