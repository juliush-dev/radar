<?php

namespace App\Http\Controllers;

use App\Enums\TopicField;
use App\Enums\TopicGroup;
use App\Enums\ModificationRequestState;
use App\Enums\ModificationType;
use App\Enums\Source;
use App\Enums\YearLevel;
use App\Http\Requests\StoreSkillRequest;
use App\Http\Requests\UpdateSkillRequest;
use App\Models\ModificationRequest;
use App\Models\Skill;
use App\Tables\Contribution\Skills;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use ProtoneMedia\Splade\Facades\Toast;

class SkillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return view('skill.index', [
            // 'publicSkills' => $publicSkills,
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
        //
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
