<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Contribution extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'contributor_id',
        'modification_request_id',
        "title",
        "source",
        "link",
    ];

    public function reference(): MorphTo
    {
        return $this->morphTo();
    }

    public function modificationRequests(): HasMany
    {
        return $this->HasMany(ModificationRequest::class);
    }

    public function contributor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'contributor_id');
    }
}
