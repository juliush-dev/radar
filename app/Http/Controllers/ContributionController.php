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
use Illuminate\Support\Facades\Auth;
use ProtoneMedia\Splade\Facades\Toast;

class ContributionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contributedSkills = new \App\Tables\Contribution\Skills();
        $contributedTeachers = new \App\Tables\Contribution\Teachers();
        $contributedSubjects = new \App\Tables\Contribution\Subjects();
        $contributedKnowledge = new \App\Tables\Contribution\Knowledge();
        $contributedLearningMaterials = new \App\Tables\Contribution\LearningMaterials();
        $publicApprovedSkillAvailable =
            Skill::whereHas('contribution', function ($query) {
                $query->where(
                    'visibility',
                    Visibility::Public->value,
                )->whereHas(
                    'modificationRequest',
                    function ($query) {
                        $query->where(
                            'modification_request_state',
                            ModificationRequestState::Approved->value,
                        );
                    }
                );
            })->exists();

        $publicApprovedTeacherPublicAvailable =
            Teacher::whereHas('contribution', function ($query) {
                $query->where(
                    'visibility',
                    Visibility::Public->value,
                )->whereHas(
                    'modificationRequest',
                    function ($query) {
                        $query->where(
                            'modification_request_state',
                            ModificationRequestState::Approved->value,
                        );
                    }
                );
            })->exists();

        $publicApprovedSubjectsPublicAvailable =
            Subject::whereHas('contribution', function ($query) {
                $query->where(
                    'visibility',
                    Visibility::Public->value,
                )->whereHas(
                    'modificationRequest',
                    function ($query) {
                        $query->where(
                            'modification_request_state',
                            ModificationRequestState::Approved->value,
                        );
                    }
                );
            })->exists();

        $publicApprovedKnowledgeAvailable =
            Knowledge::whereHas('contribution', function ($query) {
                $query->where(
                    'visibility',
                    Visibility::Public->value,
                )->whereHas(
                    'modificationRequest',
                    function ($query) {
                        $query->where(
                            'modification_request_state',
                            ModificationRequestState::Approved->value,
                        );
                    }
                );
            })->exists();

        $publicApprovedLearningMaterialsAvailable =
            LearningMaterial::whereHas('contribution', function ($query) {
                $query->where(
                    'visibility',
                    Visibility::Public->value,
                )->whereHas(
                    'modificationRequest',
                    function ($query) {
                        $query->where(
                            'modification_request_state',
                            ModificationRequestState::Approved->value,
                        );
                    }
                );
            })->exists();

        return view(
            'contribution.index',
            [
                'contributedSkills' => $contributedSkills,
                'contributedTeachers' => $contributedTeachers,
                'contributedSubjects' => $contributedSubjects,
                'contributedKnowledge' => $contributedKnowledge,
                'contributedLearningMaterials' => $contributedLearningMaterials,
                'publicApprovedSkillAvailable' => $publicApprovedSkillAvailable,
                'publicApprovedTeacherPublicAvailable' => $publicApprovedTeacherPublicAvailable,
                'publicApprovedSubjectsPublicAvailable' => $publicApprovedSubjectsPublicAvailable,
                'publicApprovedKnowledgeAvailable' => $publicApprovedKnowledgeAvailable,
                'publicApprovedLearningMaterialsAvailable' => $publicApprovedLearningMaterialsAvailable,
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
