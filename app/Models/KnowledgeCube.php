<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KnowledgeCube extends Model
{
    use HasFactory, HasUuids;

    public  function knowledge(): HasMany
    {
        return $this->hasMany(CheckpointKnowledge::class);
    }

    public  function checkpoint(): BelongsTo
    {
        return $this->belongsTo(Checkpoint::class);
    }

    public function potentialReplacement(): BelongsTo
    {
        return $this->belongsTo(KnowledgeCube::class, 'potential_replacement');
    }

    public function potentialReplacementOf(): BelongsTo
    {
        return $this->belongsTo(KnowledgeCube::class, 'potential_replacement_of');
    }

    public function faces(?Collection $reviewKnowledge = null)
    {
        $cubeFacesCount = 6;
        $knowledgeCount = $reviewKnowledge?->count() ?? $this->knowledge()->count();
        if ($knowledgeCount % $cubeFacesCount == 0) {
            return $reviewKnowledge ?? $this->knowledge;
        } else {
            $remainingFaces = [];
            $remainingFacesCount = ($cubeFacesCount - $knowledgeCount % $cubeFacesCount) % $cubeFacesCount;
            for ($i = 0; $i < $remainingFacesCount; $i++) {
                array_push($remainingFaces, ['information' => '', 'bridge' => '']);
            }
            $newCollection = collect($reviewKnowledge?->toArray() ?? $this->knowledge->toArray())->concat(
                collect($remainingFaces)
            );
            return $newCollection;
        }
    }

    public function filledFacesCount(?Collection $reviewKnowledge = null)
    {
        return $reviewKnowledge?->count() ?? $this->knowledge()->count();
    }

    public function copyToCheckpoint($checkpoint)
    {
        $cubeCopy = $this->replicate();
        $cubeCopy->checkpoint_id = $checkpoint->id;
        $cubeCopy->potential_replacement_of = $this->id;
        $cubeCopy->is_update = true;
        $cubeCopy->save();

        $this->potential_replacement = $cubeCopy->id;
        $this->save();
        return $cubeCopy;
    }

    public function applyUpdate()
    {
        $oldCube = $this->potentialReplacementOf;
        if ($oldCube->potentialReplacementOf) {
            $this->potential_replacement_of = $oldCube->potentialReplacementOf->id;
            $oldCube->potentialReplacementOf->potential_replacement = $this->id;
            $oldCube->potentialReplacementOf->save();
        } else {
            $this->is_update = 0;
        }
        $this->copyNewKnowledgeFromOldCube();
        $this->knowledge()->where('is_update', true)->get()->each(function (CheckpointKnowledge $knowledge) {
            $knowledge->applyUpdate();
        });
        $oldCube->delete();
        $this->is_public = true;
        $this->save();
    }

    public function copyNewKnowledgeFromOldCube()
    {
        // Retrieve cubes in the old checkpoint that do not have a potential replacement in the current checkpoint
        $knowledgeWithoutReplacement = $this->potentialReplacementOf->knowledge()
            ->whereNotIn(
                'id',
                $this->knowledge()->whereNotNull('potential_replacement_of')
                    ->pluck('potential_replacement_of')
                    ->all()
            )->get();

        $knowledgeWithoutReplacement->each(function ($oldKnowledge) {
            // Replicate and save the new knowledge in the current cube
            $oldKnowledge->copyToCheckpoint($this);
        });
    }
}
