<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MyNote extends Model
{
    use HasFactory, HasUuids;

    public function topic(): BelongsTo
    {
        return $this->belongsTo(MyTopic::class, 'my_topic_id');
    }
}
