<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Subject extends Model
{
    use HasFactory, HasUuids;

    public function topics(): HasMany
    {
        return $this->hasMany(Topic::class);
    }

    public function years(): HasMany
    {
        return $this->hasMany(SubjectYear::class);
    }
}
