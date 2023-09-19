<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SkillField extends Model
{
    use HasFactory;

    public function skill(): BelongsTo
    {
        return $this->belongsTo(Skill::class);
    }
    public function field(): BelongsTo
    {
        return $this->belongsTo(Field::class);
    }
}
