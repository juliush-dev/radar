<?php

namespace App\Services;

use App\Models\Field;
use App\Models\Group;
use App\Models\LearningMaterial;
use App\Models\Skill;
use App\Models\Subject;
use App\Models\Topic;
use App\Models\User;
use App\Tables\LearningMaterials;
use App\Tables\Topics;
use App\Tables\Users;
use Illuminate\Database\Eloquent\Builder;

class RadarQuery
{

    public function __construct(private EnumTransformer $ent)
    {
    }

    public function usersTable()
    {
        return Users::class;
    }

    public function topicsTable()
    {
        return Topics::class;
    }

    public function learningMaterialsTable()
    {
        return LearningMaterials::class;
    }

    public function totalUsers()
    {
        return User::count();
    }
    public function totalSkills()
    {
        return Skill::count();
    }
    public function totalTopics()
    {
        return Topic::count();
    }
    public function totalLearningMaterials()
    {
        return LearningMaterial::count();
    }

    public function topics($filter = [])
    {
        $topics = Topic::where('is_public', 1)->where('is_update', false);
        if (isset($filter['author'])) {
            $topics->whereNot('user_id', $filter['author']);
            $topics->orWhere(function ($query) use ($filter) {
                $query->where('user_id', $filter['author'])->where('updating_topic_id', null);
                $query->where(function ($query) {
                    $query->where('is_update', true)->orWhere('is_update', false);
                });
            });
            $topics->where('user_id', $filter['author'])->where('updating_topic_id', null);
        }
        if (isset($filter['year'])) {
            $topics->whereHas('years', function (Builder $query) use ($filter) {
                $query->where('year', $filter['year']);
            });
        }
        if (isset($filter['subject'])) {
            $topics->where('subject_id', $filter['subject']);
        }
        return $topics->get();
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
