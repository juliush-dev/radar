<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TopicLearningMaterial extends Model
{
    use HasFactory, HasUuids;

    public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class);
    }

    public function LearningMaterial(): BelongsTo
    {
        return $this->belongsTo(LearningMaterial::class);
    }
}
