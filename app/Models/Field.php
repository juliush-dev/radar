<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Field extends Model
{
    use HasFactory, HasUuids;

    public function skills(): HasMany
    {
        return $this->hasMany(SkillField::class);
    }
    public function topics(): HasMany
    {
        return $this->hasMany(TopicField::class);
    }

    public function years(): HasMany
    {
        return $this->hasMany(FieldYear::class);
    }
}
