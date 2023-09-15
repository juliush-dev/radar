<?php

namespace App\Http\Controllers\Contribution;

use App\Enums\ModificationRequestState;
use App\Enums\ModificationType;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLearningMaterialRequest;
use App\Http\Requests\UpdateLearningMaterialRequest;
use App\Models\Contribution;
use App\Models\LearningMaterial;
use App\Models\Topic;
use App\Tables\LearningMaterials;
use Illuminate\Support\Facades\Auth;

class LearningMaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contributedLearningMaterials = new LearningMaterials;
        return view('contribution.learning-material.index', ['contributedLearningMaterials' => $contributedLearningMaterials]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // get public topic
        // $topicsOptions = Topic::whereHas('contribution', function ($query) {
        //     $query->whereHas('modificationRequest', function ($query) {
        //         $query->whereIn('modification_type', [ModificationType::Update->value, ModificationType::Create->value])
        //             ->where(function ($query) {
        //                 $query->where('modification_request_state', ModificationRequestState::Approved->value);
        //                 if (Auth::check()) {
        //                     $query->orWhere('contributor_id', Auth::user()->id);
        //                 }
        //             });
        //     });
        // });

        // return view(
        //     'contribution.skill.create',
        //     [
        //         'topicsOptions' => $topicsOptions,
        //     ]
        // );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLearningMaterialRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(LearningMaterial $learningMaterial)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LearningMaterial $learningMaterial)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLearningMaterialRequest $request, LearningMaterial $learningMaterial)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LearningMaterial $learningMaterial)
    {
        //
    }
}
