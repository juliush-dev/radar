<?php

namespace App\Http\Controllers;

use App\Enums\ModificationRequestState;
use App\Enums\ModificationType;
use App\Enums\Visibility;
use App\Enums\YearLevel;
use App\Http\Requests\StoreSubjectRequest;
use App\Http\Requests\UpdateSubjectRequest;
use App\Models\ModificationRequest;
use App\Models\Skill;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use ProtoneMedia\Splade\Facades\Toast;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Skill $skill)
    {
        $getKeyValuePair = function ($acc, $value) {
            $acc[$value] = $value;
            return $acc;
        };

        // dd($skill);
        $yearsLevelsOptions = explode(",", $skill->years_levels_covering_it);
        $yearsLevelsOptions = array_reduce($yearsLevelsOptions, $getKeyValuePair, []);

        return view(
            'subject.create',
            [
                'yearsLevelsOptions' => $yearsLevelsOptions,
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSubjectRequest $request, Skill $skill)
    {
        DB::transaction(
            function () use ($request) {
                $subject = Subject::create([
                    "description" => $request->input('description'),
                    'year_levels_covered_by_it' => implode(",", $request->input('year_levels_covered_by_it')),
                    'topic_group_covering_it' => implode("", [$request->enum('topic_group_covering_it', TopicGroup::class)?->value]),
                ]);

                $contribution = $subject->contribution()->create(
                    [
                        'contributor_id' => Auth::user()->id,
                        "title" => $request->input('title'),
                        "visibility" => $request->input('visibility'),
                    ]
                );

                $contribution->modificationRequests()->create(
                    [
                        'reason' => null,
                        'modification_request_state' => ModificationRequestState::Pending->value,
                        'modification_type' => ModificationType::Create->value,
                    ]
                );
            }
        );
        Toast::title('New Subject successfuly submitted for contribution!')->autoDismiss(15)->centerBottom();
        return redirect()->route('contribution.subject.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Subject $subject)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subject $subject)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSubjectRequest $request, Subject $subject)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subject $subject)
    {
        //
    }
}
