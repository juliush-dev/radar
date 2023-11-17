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
}
