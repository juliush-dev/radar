<?php

namespace App\Services;

use App\Models\Field;
use App\Models\Group;
use App\Models\LearningMaterial;
use App\Models\Skill;
use App\Models\Skill\Type;
use App\Models\Subject;
use App\Models\Topic;
use App\Models\User;
use App\Tables\Groups;
use App\Tables\LearningMaterials;
use App\Tables\Subjects;
use App\Tables\Topics;
use App\Tables\Users;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

/**
 * Use this class when in the context you are
 * in, you want to retrieve some data from a source
 * but it is not the responsability
 * of that context, to be aware of the query
 * constructed to get the required data.
 */
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

    public function subjectsTable()
    {
        return Subjects::class;
    }

    public function groupsTable()
    {
        return Groups::class;
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
    public function totalSubjects()
    {
        return Subject::count();
    }

    public function totalGroups()
    {
        return Group::count();
    }

    public function totalLearningMaterials()
    {
        return LearningMaterial::count();
    }

    public function topics($filter = [])
    {
        $topics = Topic::query();
        if (!empty($filter['author'])) {
            $topics->where(function ($query) use ($filter) {
                $query->where(function ($query) use ($filter) {
                    $query->where('is_public', true);
                    $query->where('is_update', false);
                    $query->where(function ($query) use ($filter) {
                        $query->whereNot('user_id', $filter['author'])
                            ->orWhere('user_id', null);
                    });
                });
                $query->orWhere(function ($query) use ($filter) {
                    $query->where('user_id', $filter['author']);
                    $query->where('potential_replacement', null);
                    $query->where(function ($query) {
                        $query->where('is_update', true)->orWhere('is_update', false);
                    });
                });
            });
        } else {
            $topics->where('is_public', true)->where('is_update', false);
        }
        if (!empty($filter['year'])) {
            $topics->whereHas('years', function (Builder $query) use ($filter) {
                $query->where('year', $filter['year']);
            });
        }
        if (!empty($filter['field'])) {
            $topics->whereHas('fields', function (Builder $query) use ($filter) {
                $query->where('id', $filter['field']);
            });
        }
        if (!empty($filter['skill'])) {
            $topics->whereHas('skills', function (Builder $query) use ($filter) {
                $query->where('id', $filter['skill']);
            });
        }
        if (!empty($filter['subject'])) {
            $topics->where('subject_id', $filter['subject']);
        }
        return $topics->get();
    }

    public function groups()
    {
        return Group::all();
    }

    public function types()
    {
        return Type::all();
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

    public function subjects($all = false)
    {
        if ($all) {
            return Subject::all();
        }
        return Subject::whereHas('topics', function ($query) {
            $query->where('is_public', true);
        })->get();
    }

    public function skills($filter = [], $all = false)
    {
        if ($all) {
            return Skill::all();
        }
        $skills = Skill::query();
        if (count($filter) > 0) {
            if (isset($filter['type'])) {
                $skills->where('type_id', $filter['type']);
            }
            if (isset($filter['group'])) {
                $skills->where('group_id', $filter['group']);
            }
            if (isset($filter['year'])) {
                $skills->whereHas('years', function (Builder $query) use ($filter) {
                    $query->where('year', $filter['year']);
                });
            }
            if (isset($filter['group'])) {
                $skills->where('group_id', $filter['group']);
            }
            if (isset($filter['field'])) {
                $skills->whereHas('fields', function (Builder $query) use ($filter) {
                    $query->where('field_id', $filter['field']);
                });
            }
            if (!empty($filter['assessment'])) {
                $skills->whereHas('assessments', function (Builder $query) use ($filter) {
                    $query->where('assessment', $filter['assessment'])->where('user_id', Request::user()->id);
                });
            }
        }
        $skills = $skills->paginate(8);
        return $skills;
    }

    public function years()
    {
        return $this->ent->asOptions('App\Enums\Year');
    }


    public function assessments()
    {
        return [1 => 'Beginner', 2 => 'Intermediate', 3 => 'Advanced', 4 => 'Expert', 5 => 'Guru'];
    }

    public function userSkillAssessment($skill)
    {
        $skillAssessment = $skill
            ->assessments()
            ->where('user_id', auth()->user()?->id)
            ->where('skill_id', $skill->id)
            ->first();
        return $skillAssessment?->assessment ?? 0;
    }

    public function usersByMonth()
    {
        return User::select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();
    }

    public function users()
    {
        return User::all();
    }
}
