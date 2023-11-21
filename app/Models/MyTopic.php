<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MyTopic extends Model
{
    use HasFactory, HasUuids;

    public function subject(): BelongsTo
    {
        return $this->belongsTo(MySubject::class, 'my_subject_id');
    }

    public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class);
    }

    public function checkpoints(): HasMany
    {
        return $this->hasMany(MyCheckpoint::class);
    }
}
