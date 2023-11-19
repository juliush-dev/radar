<?php

namespace App\Models;

use App\Models\Checkpoint\Checkpoint;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CheckpointKnowledge extends Model
{
    use HasFactory, HasUuids;

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function knowledgeCube(): BelongsTo
    {
        return $this->belongsTo(KnowledgeCube::class);
    }

    public function potentialReplacement(): BelongsTo
    {
        return $this->belongsTo(CheckpointKnowledge::class, 'potential_replacement');
    }

    public function potentialReplacementOf(): BelongsTo
    {
        return $this->belongsTo(CheckpointKnowledge::class, 'potential_replacement_of');
    }

    public function sessionResults(): HasMany
    {
        return $this->hasMany(UserCheckpointSessionResult::class);
    }

    public function copyToCube($cube)
    {
        $knowledgeCopy = $this->replicate();
        $knowledgeCopy->knowledge_cube_id = $cube->id;
        $knowledgeCopy->potential_replacement_of = $this->id;
        $knowledgeCopy->checkpoint_id = $cube->checkpoint->id;
        $knowledgeCopy->is_update = true;
        $knowledgeCopy->save();

        $this->potential_replacement = $knowledgeCopy->id;
        $this->save();
        return $knowledgeCopy;
    }

    public function applyUpdate()
    {
        $oldKnowledge = $this->potentialReplacementOf;
        if ($oldKnowledge->potentialReplacementOf) {
            $this->potential_replacement_of = $oldKnowledge->potentialReplacementOf->id;
            $oldKnowledge->potentialReplacementOf->potential_replacement = $this->id;
            $oldKnowledge->potentialReplacementOf->save();
        } else {
            $this->is_update = 0;
        }
        $oldKnowledge->delete();
        $this->is_public = true;
        $this->save();
    }
}
