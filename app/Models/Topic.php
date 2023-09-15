<?php

namespace App\Models;

use App\View\Components\Assessment;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Topic extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'topic_field',
        'years_teached_at',
    ];

    public function contribution(): MorphOne
    {
        return $this->morphOne(Contribution::class, 'contribution');
    }
    public function subjectCoveringIt(): HasOne
    {
        return $this->hasOne(TopicSubject::class);
    }

    public function assessments(): HasMany
    {
        return $this->hasMany(Assessment::class);
    }

    public function skillsRequiringIt(): HasMany
    {
        return $this->hasMany(SkillTopic::class);
    }

    public function learningMaterials(): HasMany
    {
        return $this->hasMany(TopicLearningMaterial::class);
    }
}
