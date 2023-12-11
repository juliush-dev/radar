<?php

namespace App\Services;

use App\Models\Field;
use App\Models\Group;
use App\Models\Note;
use App\Models\Skill;
use App\Models\Skill\Type;
use App\Models\Subject;
use App\Models\Topic;
use App\Models\User;
use App\Models\UserCheckpointSession;
use App\Tables\Groups;
use App\Tables\Notes;
use App\Tables\Subjects;
use App\Tables\Topics;
use App\Tables\Users;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
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

    public function notesTable()
    {
        return Notes::class;
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

    public function totalNotes()
    {
        return Note::count();
    }

    public function notes($filter = [])
    {
        $notes = Note::query();
        if (!empty($filter['categories'])) {
            $selectedCategories = $filter['categories'];
            $foundNotes = $notes->whereHas('categories', function (Builder $query) use ($selectedCategories) {
                $query->whereIn('category_id', $selectedCategories);
            })->orderBy('updated_at', 'desc')->get();
            $filteredNotes = $foundNotes->filter(function ($note) use ($selectedCategories) {
                return collect($selectedCategories)->reduce(function ($acc, $categoryId) use ($note) {
                    $acc &= $note->categories()->where('category_id', $categoryId)->exists();
                    return $acc;
                }, true);
            });
            return $filteredNotes;
        }
        return $notes->orderBy('updated_at', 'desc')->get();
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
        return Subject::where('is_public', true)->get();
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


    public function checkpointsSessions($filter = [])
    {
        $sessions = UserCheckpointSession::query();
        if (!empty($filter['author'])) {
            $sessions->where('user_id', $filter['author']);
        }
        if (!empty($filter['checkpoint'])) {
            $sessions->where('checkpoint_id', $filter['checkpoint']);
        }
        return $sessions->get();
    }


    static function publicOrAuthor($userId = null)
    {
        if ($userId == null) {
            $userId = Auth::user()?->id;
        }
        return function ($query) use ($userId) {
            $query->where(function ($query) use ($userId) {
                $query->where('is_public', true);
                $query->where('is_update', false);
                $query->where(function ($query) use ($userId) {
                    $query->whereNot('user_id', $userId)
                        ->orWhere('user_id', null);
                });
            });
            $query->orWhere(function ($query) use ($userId) {
                $query->where('user_id', $userId);
                // $query->where('potential_replacement', null);
                $query->where(function ($query) {
                    $query->where('is_update', true)
                        ->orWhere('is_update', false);
                });
            });
        };
    }
}
