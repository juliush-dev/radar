<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserCheckpointSessionResult extends Model
{
    use HasFactory, HasUuids;

    public function userCheckpointSession(): BelongsTo
    {
        return $this->belongsTo(UserCheckpointSession::class);
    }
}
