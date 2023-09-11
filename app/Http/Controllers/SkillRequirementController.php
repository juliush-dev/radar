<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSkillRequirementRequest;
use App\Http\Requests\UpdateSkillRequirementRequest;
use App\Models\Skill;
use App\Models\SkillRequirement;
use App\Models\Topic;
use Illuminate\Support\Facades\DB;

class SkillRequirementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Skill $skill)
    {

        $requirements = $skill->requiredTopics;
        $requiredTopics = $requirements->map(fn ($requirement) => Topic::find($requirement->topic_id));
        $ids = $requirements->map(fn ($requirement) => $requirement->topic_id)->all();
        $topicsOptions = Topic::whereNotIn('id', $ids)->get();
        return view('skill-requirement.index', [
            'skill' => $skill,
            'requiredTopics' => $requiredTopics,
            'topicsOptions' => $topicsOptions,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSkillRequirementRequest $request, SKill $skill)
    {
        DB::transaction(
            function () use ($request, $skill) {
                $skillRequiremnt = new  SkillRequirement;
                $skillRequiremnt->skill_id = $skill->id;
                $skillRequiremnt->topic_id = $request->input('topics')[0];
                $skillRequiremnt->save();
            }
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(SkillRequirement $skillRequiremnt)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SkillRequirement $skillRequiremnt)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSkillRequirementRequest $request, SkillRequirement $skillRequiremnt)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SkillRequirement $skillRequiremnt)
    {
        //
    }
}
