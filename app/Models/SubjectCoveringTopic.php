<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubjectCoveringTopic extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'subject_covering_topic';
    public function subject(): BelongsTo
    {
        return $this->BelongsTo(Subject::class);
    }

    public function topic(): BelongsTo
    {
        return $this->BelongsTo(Topic::class);
    }
}
