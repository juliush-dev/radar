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
}
