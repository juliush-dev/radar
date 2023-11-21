<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MySubject extends Model
{
    use HasFactory, HasUuids;

    public function office(): BelongsTo
    {
        return $this->belongsTo(MyOffice::class, 'my_office_id');
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }
    public function topics(): HasMany
    {
        return $this->hasMany(MyTopic::class);
    }
}
