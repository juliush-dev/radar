<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Skill extends Model
{
    use HasFactory, HasUuids;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fields_covered_by_it',
        'years_levels_covering_it',
        'topic_group_covering_it',
    ];

    public function contribution(): MorphOne
    {
        return $this->morphOne(Contribution::class, 'contribution');
    }

    public function requiredTopic(): HasMany
    {
        return $this->hasMany(Topic::class);
    }
}
