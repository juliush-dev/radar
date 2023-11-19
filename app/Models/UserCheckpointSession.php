<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserCheckpointSession extends Model
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

    public function userResults(): HasMany
    {
        return $this->hasMany(UserCheckpointSessionResult::class, 'session_id');
    }

    public function untouchedKnowledge($justCount = false)
    {
        $untouched = CheckpointKnowledge::where('checkpoint_id', $this->checkpoint->id)
            ->whereNotIn('id', $this->userResults->pluck('knowledge_id')->all());
        if ($justCount) {
            return $untouched->count();
        }
        $untouched = $untouched->get();
        $modifiedCollection = $untouched->map(function ($item) {
            $item['bridge_crossed'] = null;
            return $item;
        });
        return $modifiedCollection;
    }

    public function correctResults($justCount = false)
    {
        $results = CheckpointKnowledge::whereIn(
            'id',
            $this->userResults()->where(
                'bridge_crossed',
                true
            )->pluck('knowledge_id')->all()
        );
        if ($justCount) {
            return $results->count();
        }
        $results = $results->get();
        $modifiedCollection = $results->map(function ($item) {
            $item['bridge_crossed'] = true;
            return $item;
        });
        return $modifiedCollection;
    }

    public function wrongResults($justCount = false)
    {
        $result = CheckpointKnowledge::whereIn(
            'id',
            $this->userResults()->where(
                'bridge_crossed',
                false
            )->pluck('knowledge_id')->all()
        );
        if ($justCount) {
            return $result->count();
        }
        $result = $result->get();
        $modifiedCollection = $result->map(function ($item) {
            $item['bridge_crossed'] = false;
            return $item;
        });
        return $modifiedCollection;
    }

    public function potentialReplacement(): BelongsTo
    {
        return $this->belongsTo(UserCheckpointSession::class, 'potential_replacement');
    }

    public function potentialReplacementOf(): BelongsTo
    {
        return $this->belongsTo(UserCheckpointSession::class, 'potential_replacement_of');
    }

    public function copyToCheckpoint($checkpoint)
    {
        $sessionCopy = $this->replicate();
        $sessionCopy->checkpoint_id = $checkpoint->id;
        $sessionCopy->potential_replacement_of = $this->id;
        $sessionCopy->is_update = true;
        $sessionCopy->save();

        $this->potential_replacement = $sessionCopy->id;
        $this->save();
        return $sessionCopy;
    }

    public function applyUpdate()
    {
        $oldSession = $this->potentialReplacementOf;
        if ($oldSession->potentialReplacementOf) {
            $this->potential_replacement_of = $oldSession->potentialReplacementOf->id;
            $oldSession->potentialReplacementOf->potential_replacement = $this->id;
            $oldSession->potentialReplacementOf->save();
        } else {
            $this->is_update = 0;
        }
        $this->copyNewUserResultsFromOldSession();
        $this->userResults()->where('is_update', true)->get()->each(function (UserCheckpointSessionResult $result) {
            $result->applyUpdate();
        });
        $oldSession->delete();
        $this->save();
    }

    public function copyNewUserResultsFromOldSession()
    {
        // Retrieve results in the old session that do not have a potential replacement in the current session
        $resultsWithoutReplacement = $this->potentialReplacementOf->userResults()
            ->whereNotIn(
                'id',
                $this->userResults()->whereNotNull('potential_replacement_of')
                    ->pluck('potential_replacement_of')
                    ->all()
            )->get();
        $resultsWithoutReplacement->each(function ($oldResult) {
            // Replicate and save the new knowledge in the current cube
            $oldResult->copyToSession($this);
        });
        return $resultsWithoutReplacement->count();
    }
}
