<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSkillRequest;
use App\Http\Requests\UpdateSkillRequest;
use App\Models\Skill;
use App\Tables\Skills;
use ProtoneMedia\Splade\SpladeTable;

class SkillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $skillsIndex = new Skills;
        return view('skill.index', [
            'publicSkills' => $skillsIndex->for()
        ]);
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
    public function store(StoreSkillRequest $request)
    {
    }

    /**
     * Display the specified resource.
     */
    public function show(Skill $skill)
    {
        $skillsIndex = new Skills;
        return view(
            'skill.show',
            [
                'skill' => $skill,
                'publicSkills' => $skillsIndex->for(),
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Skill $skill)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSkillRequest $request, Skill $skill)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Skill $skill)
    {
        //
    }
}
