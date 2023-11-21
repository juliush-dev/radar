<?php

namespace App\Models;

use App\Services\RadarQuery;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class Subject extends Model
{
    use HasFactory, HasUuids;

    public function topics(): HasMany
    {
        return $this->hasMany(Topic::class);
    }

    public function years(): HasMany
    {
        return $this->hasMany(SubjectYear::class);
    }

    public function mySubjects(): HasMany
    {
        return $this->hasMany(MySubject::class);
    }

    public function publicTopics()
    {
        return Topic::published()->where('subject_id', $this->id);
    }
}
