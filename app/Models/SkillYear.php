<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SkillYear extends Model
{
    use HasFactory;

    public function skill(): BelongsTo
    {
        return $this->belongsTo(Skill::class);
    }
}
