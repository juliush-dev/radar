<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Subject extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'teacher_id',
        'description',
        'year_levels_covered_by_it',
    ];

    public function contribution(): MorphOne
    {
        return $this->morphOne(Contribution::class, 'contribution');
    }

    public function topicCoveredByIt(): HasOne
    {
        return $this->hasOne(TopicSubject::class);
    }
}
