<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SkillRequirement extends Model
{
    use HasFactory;

    public function skills(): BelongsTo
    {
        return $this->BelongsTo(Skill::class);
    }

    public function topics(): BelongsTo
    {
        return $this->BelongsTo(Topic::class);
    }
}
