<?php

namespace App\Http\Controllers;

use App\Enums\KnowledgeField;
use App\Enums\KnowledgeGroup;
use App\Enums\ModificationRequestState;
use App\Enums\ModificationType;
use App\Enums\Source;
use App\Enums\Visibility;
use App\Enums\YearLevel;
use App\Http\Requests\StoreContributionRequest;
use App\Http\Requests\UpdateContributionRequest;
use App\Models\Contribution;
use App\Models\Skill;
use App\Models\LearningMaterial;
use App\Models\ModificationRequest;
use App\Models\Knowledge;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use ProtoneMedia\Splade\Facades\Toast;

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
                    ->whereHas(
                        'modificationRequests',
                        function (Builder $query) {
                            $query->latest('created_at')->whereIn(
                                'modification_type',
                                [
                                    ModificationType::Update->value,
                                    ModificationType::CreateAndMakePublic->value,
                                    ModificationType::MakePublic->value,
                                ]
                            )->where(
                                'modification_request_state',
                                ModificationRequestState::Approved->value
                            );
                        }
                    );
            };

        $privateCondition =  function ($query) use ($user_id) {
            $query->where('contributor_id', $user_id)
                ->whereHas(
                    'modificationRequests',
                    function (Builder $query) {
                        $query->latest('created_at')->whereIn(
                            'modification_type',
                            [
                                ModificationType::Update->value,
                                ModificationType::CreateAndMakePrivate->value,
                                ModificationType::MakePrivate->value,
                            ]
                        )->whereIn(
                            'modification_request_state',
                            [
                                ModificationRequestState::Approved->value,
                                ModificationRequestState::Rejected->value,
                            ]
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
        $contributedSkillsPrivate = Skill::whereHas(
            'contribution',
            $privateCondition,
        )->count();
        $contributedSkillsApproved = Skill::whereHas(
            'contribution',
            $approvedCondition,
        )->count();
        $contributedSkillsPending = Skill::whereHas(
            'contribution',
            $pendingCondition,
        )->count();

        $contributedTeachers = Teacher::whereRelation(
            'contribution',
            'contributor_id',
            $user_id
        )->count();
        $contributedTeachersPublished = Teacher::whereHas(
            'contribution',
            $publicCondition,
        )->count();
        $contributedTeachersPrivate = Teacher::whereHas(
            'contribution',
            $privateCondition,
        )->count();
        $contributedTeachersApproved = Teacher::whereHas(
            'contribution',
            $approvedCondition,
        )->count();

        $contributedTeachersPending = Teacher::whereHas(
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
        $contributedSubjectsPrivate = Subject::whereHas(
            'contribution',
            $privateCondition,
        )->count();
        $contributedSubjectsApproved = Subject::whereHas(
            'contribution',
            $approvedCondition,
        )->count();

        $contributedSubjectsPending = Subject::whereHas(
            'contribution',
            $pendingCondition,
        )->count();

        // knowledge
        $contributedKnowledge = Knowledge::whereRelation(
            'contribution',
            'contributor_id',
            $user_id
        )->count();
        $contributedKnowledgePublished = Knowledge::whereHas(
            'contribution',
            $publicCondition,
        )->count();
        $contributedKnowledgePrivate = Knowledge::whereHas(
            'contribution',
            $privateCondition,
        )->count();
        $contributedKnowledgeApproved = Knowledge::whereHas(
            'contribution',
            $approvedCondition,
        )->count();

        $contributedKnowledgePending = Knowledge::whereHas(
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
        $contributedLearningMaterialsPrivate = LearningMaterial::whereHas(
            'contribution',
            $privateCondition,
        )->count();
        $contributedLearningMaterialsApproved = LearningMaterial::whereHas(
            'contribution',
            $approvedCondition,
        )->count();

        $contributedLearningMaterialsPending = LearningMaterial::whereHas(
            'contribution',
            $pendingCondition,
        )->count();

        return view(
            'contribution.index',
            [
                'contributedSkills' => $contributedSkills,
                'contributedSkillsPublished' => $contributedSkillsPublished,
                'contributedSkillsPrivate' => $contributedSkillsPrivate,
                'contributedSkillsApproved' => $contributedSkillsApproved,
                'contributedSkillsPending' => $contributedSkillsPending,

                // teachers
                'contributedTeachers' => $contributedTeachers,
                'contributedTeachersPublished' => $contributedTeachersPublished,
                'contributedTeachersPrivate' => $contributedTeachersPrivate,
                'contributedTeachersApproved' => $contributedTeachersApproved,
                'contributedTeachersPending' => $contributedTeachersPending,

                // subjects
                'contributedSubjects' => $contributedSubjects,
                'contributedSubjectsPublished' => $contributedSubjectsPublished,
                'contributedSubjectsPrivate' => $contributedSubjectsPrivate,
                'contributedSubjectsApproved' => $contributedSubjectsApproved,
                'contributedSubjectsPending' => $contributedSubjectsPending,

                // knowledge
                'contributedKnowledge' => $contributedKnowledge,
                'contributedKnowledgePublished' => $contributedKnowledgePublished,
                'contributedKnowledgePrivate' => $contributedKnowledgePrivate,
                'contributedKnowledgeApproved' => $contributedKnowledgeApproved,
                'contributedKnowledgePending' => $contributedKnowledgePending,

                // learning materials
                'contributedLearningMaterials' => $contributedLearningMaterials,
                'contributedLearningMaterialsPublished' => $contributedLearningMaterialsPublished,
                'contributedLearningMaterialsPrivate' => $contributedLearningMaterialsPrivate,
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
