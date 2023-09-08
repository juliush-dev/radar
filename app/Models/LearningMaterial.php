<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class LearningMaterial extends Model
{
    use HasFactory, HasUuids;
    public function contribution(): MorphOne
    {
        return $this->morphOne(Contribution::class, 'contribution');
    }

    public function topic(): HasOne
    {
        return $this->hasOne(TopicLearningMaterial::class);
    }
}
