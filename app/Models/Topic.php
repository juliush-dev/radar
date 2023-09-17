<?php

namespace App\Models;

use App\Enums\ModificationRequestState;
use App\Enums\ModificationType;
use App\Enums\Visibility;
use App\View\Components\Assessment;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Facades\Auth;

class Topic extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'topic_field',
        'years_teached_at',
    ];

    public function contribution(): MorphOne
    {
        return $this->morphOne(Contribution::class, 'contribution');
    }
    public function subjectCoveringIt(): HasOne
    {
        return $this->hasOne(TopicSubject::class);
    }

    public function assessments(): HasMany
    {
        return $this->hasMany(Assessment::class);
    }

    public function skillsRequiringIt(): HasMany
    {
        return $this->hasMany(SkillTopic::class);
    }

    public function learningMaterials(): HasMany
    {
        return $this->hasMany(TopicLearningMaterial::class);
    }

    public function subjectsOptions()
    {

        $subjectsOptions = Subject::whereRaw('FIND_IN_SET(?, year_levels_covered_by_it)', [$this->year_teached_at]);
        // if ($this->id != null) {
        //     $subjectsOptions->whereNotIn('id', $this->skillTopics->pluck('topic_id'));
        // }
        $subjectsOptions = $subjectsOptions->whereHas(
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
        $subjectsOptionsPair = $subjectsOptions;
        $subjectsOptionsPair = $subjectsOptionsPair->reduce(function ($acc, $subject) {
            array_push($acc, [
                'id' => $subject->id,
                'title' => $subject->contribution->title
            ]);
            return $acc;
        }, []);
        return $subjectsOptionsPair;
    }
}
