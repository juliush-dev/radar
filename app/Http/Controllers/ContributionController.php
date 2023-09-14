<?php

namespace App\Http\Controllers;

use App\Enums\ModificationRequestState;
use App\Enums\ModificationType;
use App\Enums\Visibility;
use App\Http\Requests\StoreContributionRequest;
use App\Http\Requests\UpdateContributionRequest;
use App\Models\Contribution;
use App\Models\Skill;
use App\Models\LearningMaterial;
use App\Models\Topic;
use App\Models\Subject;
use App\Models\Teacher;
use App\Tables\Contributions;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ContributionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user_id = Auth::user()->id;
        $publicCondition =
            function ($query) use ($user_id) {
                $query->where('contributor_id', $user_id)
                    ->where('visibility', Visibility::Public->value)
                    ->whereHas(
                        'modificationRequests',
                        function (Builder $query) {
                            $query->latest('created_at')->whereIn(
                                'modification_type',
                                [
                                    ModificationType::Update->value,
                                    ModificationType::Create->value,
                                ]
                            )->where(
                                'modification_request_state',
                                ModificationRequestState::Approved->value
                            );
                        }
                    );
            };


        $approvedCondition =  function ($query) use ($user_id) {
            $query->where('contributor_id', $user_id)
                ->whereHas(
                    'modificationRequests',
                    function (Builder $query) {
                        $query->latest('created_at')->where(
                            'modification_request_state',
                            ModificationRequestState::Approved->value,
                        );
                    }
                );
        };

        $pendingCondition =  function ($query) use ($user_id) {
            $query->where('contributor_id', $user_id)
                ->whereHas(
                    'modificationRequests',
                    function (Builder $query) {
                        $query->latest('created_at')->where(
                            'modification_request_state',
                            ModificationRequestState::Pending->value,
                        );
                    }
                );
        };

        $contributedSkills = Skill::whereRelation(
            'contribution',
            'contributor_id',
            $user_id
        )->count();
        $contributedSkillsPublished = Skill::whereHas(
            'contribution',
            $publicCondition,
        )->count();
        $contributedSkillsApproved = Skill::whereHas(
            'contribution',
            $approvedCondition,
        )->count();
        $contributedSkillsPending = Skill::whereHas(
            'contribution',
            $pendingCondition,
        )->count();

        $contributedSubjects = Subject::whereRelation(
            'contribution',
            'contributor_id',
            $user_id
        )->count();
        $contributedSubjectsPublished = Subject::whereHas(
            'contribution',
            $publicCondition,
        )->count();
        $contributedSubjectsApproved = Subject::whereHas(
            'contribution',
            $approvedCondition,
        )->count();

        $contributedSubjectsPending = Subject::whereHas(
            'contribution',
            $pendingCondition,
        )->count();

        // topic
        $contributedTopics = Topic::whereRelation(
            'contribution',
            'contributor_id',
            $user_id
        )->count();
        $contributedTopicsPublished = Topic::whereHas(
            'contribution',
            $publicCondition,
        )->count();
        $contributedTopicsApproved = Topic::whereHas(
            'contribution',
            $approvedCondition,
        )->count();

        $contributedTopicsPending = Topic::whereHas(
            'contribution',
            $pendingCondition,
        )->count();

        // learning materials
        $contributedLearningMaterials = LearningMaterial::whereRelation(
            'contribution',
            'contributor_id',
            $user_id
        )->count();
        $contributedLearningMaterialsPublished = LearningMaterial::whereHas(
            'contribution',
            $publicCondition,
        )->count();
        $contributedLearningMaterialsApproved = LearningMaterial::whereHas(
            'contribution',
            $approvedCondition,
        )->count();

        $contributedLearningMaterialsPending = LearningMaterial::whereHas(
            'contribution',
            $pendingCondition,
        )->count();
        $contributions = Contributions::class;
        return view(
            'contribution.index',
            [
                'contributions' => $contributions,
                'contributedSkills' => $contributedSkills,
                'contributedSkillsPublished' => $contributedSkillsPublished,
                'contributedSkillsApproved' => $contributedSkillsApproved,
                'contributedSkillsPending' => $contributedSkillsPending,

                // subjects
                'contributedSubjects' => $contributedSubjects,
                'contributedSubjectsPublished' => $contributedSubjectsPublished,
                'contributedSubjectsApproved' => $contributedSubjectsApproved,
                'contributedSubjectsPending' => $contributedSubjectsPending,

                // topic
                'contributedTopics' => $contributedTopics,
                'contributedTopicsPublished' => $contributedTopicsPublished,
                'contributedTopicsApproved' => $contributedTopicsApproved,
                'contributedTopicsPending' => $contributedTopicsPending,

                // learning materials
                'contributedLearningMaterials' => $contributedLearningMaterials,
                'contributedLearningMaterialsPublished' => $contributedLearningMaterialsPublished,
                'contributedLearningMaterialsApproved' => $contributedLearningMaterialsApproved,
                'contributedLearningMaterialsPending' => $contributedLearningMaterialsPending,
            ],
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContributionRequest $request)
    {
    }

    /**
     * Display the specified resource.
     */
    public function show(Contribution $contribution)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contribution $contribution)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContributionRequest $request, Contribution $contribution)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contribution $contribution)
    {
        //
    }
}
