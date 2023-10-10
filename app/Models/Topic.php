<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

    public function topicUpdating(): BelongsTo
    {
        return $this->belongsTo(Topic::class, 'updating_topic_id');
    }

    public function topicToUpdate(): BelongsTo
    {
        return $this->belongsTo(Topic::class, 'update_topic_id');
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
}
