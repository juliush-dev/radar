<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TopicProficiency extends Model
{
    use HasFactory, HasUuids;

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function assessingTopic(): BelongsTo
    {
        return $this->belongsTo(Topic::class, 'assessing_topic_id');
    }
}
