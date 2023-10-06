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


    public function fields($filter = [])
    {
        $fields = Field::query();
        $filterConsidered = false;
        if (count($filter) > 0) {
            if (isset($filter['year'])) {
                $filterConsidered = true;
                $fields->whereHas('years', function (Builder $query) use ($filter) {
                    $query->where('year', $filter['year']);
                });
            }
            if (isset($filter['ids'])) {
                $filterConsidered = true;
                $fields->whereIn('id', $filter['ids']);
            }
        }
        if ($filterConsidered) {
            $fields = $fields->get();
        } else {
            $fields = Field::all();
        }
        return $fields;
    }

    public function subjects()
    {
        return Subject::all();
    }

    public function skills($filter = [])
    {
        $skills = Skill::query();
        $filterConsidered = false;
        if (count($filter) > 0) {
            if (isset($filter['year'])) {
                $filterConsidered = true;
                $skills->whereHas('years', function (Builder $query) use ($filter) {
                    $query->where('year', $filter['year']);
                });
            }
            if (isset($filter['group'])) {
                $filterConsidered = true;
                $skills->where('group_id', $filter['group']);
            }
            if (isset($filter['field'])) {
                $filterConsidered = true;
                $skills->whereHas('fields', function (Builder $query) use ($filter) {
                    $query->where('field_id', $filter['field']);
                });
            }
        }
        if ($filterConsidered) {
            $skills = $skills->get();
        } else {
            $skills = Skill::all();
        }
        return $skills;
    }

    public function years()
    {
        return $this->ent->asOptions('App\Enums\Year');
    }
}
