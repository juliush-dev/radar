<?php

namespace App\Services;

use App\Models\Field;
use App\Models\Group;
use App\Models\Skill;
use App\Models\Subject;
use App\Models\Topic;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RadarQuery
{

    public function __construct(private EnumTransformer $ent)
    {
    }

    public function topics($filter = [])
    {
        $topics = Topic::query();
        $filterConsidered = false;
        if (count($filter) > 0) {
            if (isset($filter['year'])) {
                $filterConsidered = true;
                $topics->whereHas('years', function (Builder $query) use ($filter) {
                    $query->where('year', $filter['year']);
                });
            }
            if (isset($filter['subject'])) {
                $filterConsidered = true;
                $topics->where('subject_id', $filter['subject']);
            }
            if (isset($filter['skill'])) {
                $filterConsidered = true;
                $topics->whereHas('skills', function (Builder $query) use ($filter) {
                    $query->where('skill_id', $filter['skill']);
                });
            }
        }
        if ($filterConsidered) {
            $topics = $topics->get();
        } else {
            $topics = Topic::all();
        }
        return $topics;
    }

    public function groups()
    {
        return Group::all();
    }


    public function fields()
    {
        return Field::all();
    }

    public function subjects()
    {
        return Subject::all();
    }

    public function skills()
    {
        return Skill::all();
    }

    public function years()
    {
        return $this->ent->asOptions('App\Enums\Year');
    }
}
