<?php

namespace App\Models;

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
    public function contribution(): MorphOne
    {
        return $this->morphOne(Contribution::class, 'contribution');
    }
    public function subjectCoveringIt(): HasOne
    {
        return $this->hasOne(Subject::class, 'covered_by_subject_id');
    }

    public function studentsAssessments(): HasMany
    {
        return $this->hasMany(TopicProficiency::class);
    }

    public function SkillRequiringIt(): BelongsTo
    {
        return $this->belongsTo(Skill::class, 'required_by_skill_id');
    }

    public function learningMaterials(): HasMany
    {
        return $this->hasMany(LearningMaterial::class);
    }
}
