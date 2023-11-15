<?php

namespace App\Models;

use App\Models\CheckpointQuestionAnswerSet;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Checkpoint extends Model
{
    use HasFactory, HasUuids;

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class, 'topic_id');
    }

    public function questionAnswerSets(): HasMany
    {
        return $this->hasMany(CheckpointQuestionAnswerSet::class);
    }

    public function userSessions(): HasMany
    {
        return $this->hasMany(UserCheckpointSession::class);
    }

    public function potentialReplacement(): BelongsTo
    {
        return $this->belongsTo(Checkpoint::class, 'potential_replacement');
    }

    public function potentialReplacementOf(): BelongsTo
    {
        return $this->belongsTo(Checkpoint::class, 'potential_replacement_of');
    }

    public function questionsCubes(): HasMany
    {
        return $this->hasMany(QuestionsCube::class);
    }
}
