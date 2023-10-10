<?php

namespace App\Models\Skill;

use App\Models\Skill;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Type extends Model
{
    use HasFactory, HasUuids;

    public function skills(): HasMany
    {
        return $this->hasMany(Skill::class);
    }
}
