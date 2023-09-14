<?php

namespace App\Models;

use App\Enums\ModificationRequestState;
use App\Enums\ModificationType;
use App\Enums\Visibility;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Facades\Auth;

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

    public function skillTopics(): HasMany
    {
        return $this->hasMany(SkillTopic::class);
    }
    public function topicsYearsOptions()
    {
        $getKeyValuePair = function ($acc, $value) {
            $acc[$value] = $value;
            return $acc;
        };

        $yearsLevelsOptions = explode(",", $this->years_levels_covering_it);
        $yearsLevelsOptionsPair = array_reduce($yearsLevelsOptions, $getKeyValuePair, []);
        return $yearsLevelsOptionsPair;
    }

    public function topicsFieldsOptions()
    {
        $getKeyValuePair = function ($acc, $value) {
            $acc[$value] = $value;
            return $acc;
        };

        $fieldsOptions = explode(",", $this->fields_covered_by_it);
        $fieldsOptionsPair = array_reduce($fieldsOptions, $getKeyValuePair, []);
        return $fieldsOptionsPair;
    }

    public function topicsSubjectsOptions()
    {
        $subjects = Subject::where(function ($query) {
            $query->where(function ($query) {
                foreach (explode(",", $this->years_levels_covering_it) as $y) {
                    $query->orWhereRaw('FIND_IN_SET(?, year_levels_covered_by_it)', [$y]);
                }
            })
                ->whereHas(
                    'contribution',
                    function ($query) {
                        $query->where('contributor_id', Auth::user()->id)
                            ->whereNot('visibility', Visibility::Disabled->value)
                            ->whereHas('modificationRequests', function ($query) {
                                $query->latest('created_at')
                                    ->whereIn('modification_type', [
                                        ModificationType::Create->value,
                                        ModificationType::Update->value,
                                    ])->whereIn(
                                        'modification_request_state',
                                        [
                                            ModificationRequestState::Pending->value,
                                            ModificationRequestState::Approved->value,
                                        ]
                                    );
                            })->orWhere(function ($query) {
                                $query->whereNot('contributor_id', Auth::user()->id)
                                    ->where('visibility', Visibility::Public->value)
                                    ->whereHas('modificationRequests', function ($query) {
                                        $query->latest('created_at')
                                            ->whereIn('modification_type', [
                                                ModificationType::Create->value,
                                                ModificationType::Update->value,
                                            ])->where(
                                                'modification_request_state',
                                                ModificationRequestState::Approved->value
                                            );
                                    });
                            });
                    }
                );
        })->get();
        $subjectsOptionsPair = $subjects->reduce(function ($acc, $subject) {
            array_push($acc, [
                'id' => $subject->id,
                'title' => $subject->contribution->title
            ]);
            return $acc;
        }, []);
        return $subjectsOptionsPair;
    }

    public function topicsOptions()
    {
        $topicsOptions = Topic::whereIn('year_teached_at', explode(",", $this->years_levels_covering_it))
            ->whereNotIn('id', $this->skillTopics->pluck('topic_id'))
            ->whereHas(
                'contribution',
                function ($query) {
                    $query->where('contributor_id', Auth::user()->id)
                        ->whereNot('visibility', Visibility::Disabled->value)
                        ->whereHas('modificationRequests', function ($query) {
                            $query->latest('created_at')
                                ->whereIn('modification_type', [
                                    ModificationType::Create->value,
                                    ModificationType::Update->value,
                                ])->whereIn(
                                    'modification_request_state',
                                    [
                                        ModificationRequestState::Pending->value,
                                        ModificationRequestState::Approved->value,
                                    ]
                                );
                        })->orWhere(function ($query) {
                            $query->whereNot('contributor_id', Auth::user()->id)
                                ->where('visibility', Visibility::Public->value)
                                ->whereHas('modificationRequests', function ($query) {
                                    $query->latest('created_at')
                                        ->whereIn('modification_type', [
                                            ModificationType::Create->value,
                                            ModificationType::Update->value,
                                        ])->where(
                                            'modification_request_state',
                                            ModificationRequestState::Approved->value
                                        );
                                });
                        });
                }
            )->get();
        $topicsOptionsPair = $topicsOptions->reduce(function ($acc, $topic) {
            array_push($acc, [
                'id' => $topic->id,
                'title' => $topic->contribution->title
            ]);
            return $acc;
        }, []);
        return $topicsOptionsPair;
    }
}
