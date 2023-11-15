<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QuestionsCube extends Model
{
    use HasFactory, HasUuids;

    public  function questions(): HasMany
    {
        return $this->hasMany(CheckpointQuestionAnswerSet::class);
    }
    public function potentialReplacement(): BelongsTo
    {
        return $this->belongsTo(QuestionsCube::class, 'potential_replacement');
    }

    public function potentialReplacementOf(): BelongsTo
    {
        return $this->belongsTo(QuestionsCube::class, 'potential_replacement_of');
    }

    public function faces(?Collection $reviewQuestions = null)
    {
        $cubeFacesCount = 6;
        $questionsCount = $reviewQuestions?->count() ?? $this->questions()->count();
        if ($questionsCount % $cubeFacesCount == 0) {
            return $reviewQuestions ?? $this->questions;
        } else {
            $remainingFaces = [];
            $remainingFacesCount = ($cubeFacesCount - $questionsCount % $cubeFacesCount) % $cubeFacesCount;
            for ($i = 0; $i < $remainingFacesCount; $i++) {
                array_push($remainingFaces, ['question' => '', 'answer' => '', 'is_cloze' => false]);
            }
            $newCollection = collect($reviewQuestions?->toArray() ?? $this->questions->toArray())->concat(
                collect($remainingFaces)
            );
            return $newCollection;
        }
    }

    public function filledFacesCount(?Collection $reviewQuestions = null)
    {
        return $reviewQuestions?->count() ?? $this->questions()->count();
    }
}
