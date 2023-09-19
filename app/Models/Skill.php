<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Skill extends Model
{
    use HasFactory, HasUuids;

    public function fields(): HasMany
    {
        return $this->hasMany(SkillField::class);
    }


    public function years(): HasMany
    {
        return $this->hasMany(SkillYear::class);
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    public function topics(): HasMany
    {
        return $this->hasMany(Topic::class);
    }
}
