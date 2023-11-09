<?php

namespace App\Models;

use App\Services\RadarQuery;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class Topic extends Model
{
    use HasFactory, HasUuids;

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function potentialReplacement(): BelongsTo
    {
        return $this->belongsTo(Topic::class, 'potential_replacement');
    }

    public function potentialReplacementOf(): BelongsTo
    {
        return $this->belongsTo(Topic::class, 'potential_replacement_of');
    }

    public function skill(): BelongsTo
    {
        return $this->belongsTo(Skill::class);
    }

    public function previousTopic(): BelongsTo
    {
        return $this->belongsTo(Topic::class, 'previous_topic_id');
    }

    public function fields(): HasMany
    {
        return $this->hasMany(TopicField::class);
    }

    public function years(): HasMany
    {
        return $this->hasMany(TopicYear::class);
    }

    public function skills(): HasMany
    {
        return $this->hasMany(TopicSkill::class);
    }

    public function learningMaterials(): HasMany
    {
        return $this->hasMany(LearningMaterial::class);
    }

    public function checkpoints(): HasMany
    {
        return $this->hasMany(Checkpoint::class);
    }
    public function volatileCheckpoints()
    {
        return $this->checkpoints()->where('is_public', false);
    }

    public function publicCheckpoints()
    {
        return $this->checkpoints()->where(
            RadarQuery::publicOrAuthor(Auth::id())
        );
    }

    public function volatileLearningMaterials()
    {
        return $this->learningMaterials()->where('is_public', false);
    }

    public function publicLearningMaterials()
    {
        return $this->learningMaterials()->where(
            function ($query) {
                $query->where('is_public', true)
                    ->orWhere('user_id', Auth::id());
            }
        );
    }
}
