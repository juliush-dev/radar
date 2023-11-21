<?php

namespace App\Models;

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
    public function copyToTopic($topic)
    {

        $checkpointCopy = $this->replicate();
        $checkpointCopy->topic_id = $topic->id;
        $checkpointCopy->potential_replacement_of = $this->id;
        $checkpointCopy->is_update = true;
        $checkpointCopy->save();

        $this->potential_replacement = $checkpointCopy->id;
        $this->save();
        return $checkpointCopy;
    }

    public function applyUpdate()
    {
        $oldCheckpoint = $this->potentialReplacementOf;
        if ($oldCheckpoint->potentialReplacementOf) {
            $this->potential_replacement_of = $oldCheckpoint->potentialReplacementOf->id;
            $oldCheckpoint->potentialReplacementOf->potential_replacement = $this->id;
            $oldCheckpoint->potentialReplacementOf->save();
        } else {
            $this->is_update = 0;
        }
        $this->copyNewSessionsFromOldCheckpoint();
        $this->userSessions()->where('is_update', true)->get()->each(function (UserCheckpointSession $session) {
            $session->applyUpdate();
        });
        $oldCheckpoint->delete();
        $this->is_public = true;
        $this->save();
    }

    public function copyNewSessionsFromOldCheckpoint()
    {
        // Retrieve sessions in the old checkpoint that do not have a potential replacement in the current checkpoint
        $sessionsWithoutReplacement = $this->potentialReplacementOf->userSessions()
            ->whereNotIn(
                'id',
                $this->userSessions()->whereNotNull('potential_replacement_of')
                    ->pluck('potential_replacement_of')
                    ->all()
            )->get();
        $sessionsWithoutReplacement->each(function ($oldSession) {
            $oldSession->copyToCheckpoint($this);
        });
    }
    public function myCheckpoints(): HasMany
    {
        return $this->hasMany(MyCheckpoint::class);
    }
}
