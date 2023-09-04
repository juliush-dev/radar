<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ModificationRequest extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'reason',
        'modification_request_state',
        'modification_type',
    ];
    public function contribution(): HasOne
    {
        return $this->hasOne(Contribution::class);
    }
}
