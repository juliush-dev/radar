<?php

namespace App\Http\Controllers\Contribution;

use App\Enums\ModificationRequestState;
use App\Enums\ModificationType;
use App\Enums\TopicGroup;
use App\Enums\Visibility;
use App\Enums\YearLevel;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSubjectRequest;
use App\Http\Requests\UpdateSubjectRequest;
use App\Models\ModificationRequest;
use App\Models\Subject;
use App\Models\Teacher;
use App\Tables\Contribution\Subjects;
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
        $contributedSubjects = new Subjects;
        return view('contribution.subject.index', ['contributedSubjects' => $contributedSubjects]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $getKeyValuePair = function ($acc, $value) {
            $acc[$value] = $value;
            return $acc;
        };


        $yearsLevels = YearLevel::cases();
        $yearsLevelsOptions = array_column($yearsLevels, 'value');
        $yearsLevelsOptions = array_reduce($yearsLevelsOptions, $getKeyValuePair, []);

        return view(
            'contribution.subject.create',
            [
                'yearsLevelsOptions' => $yearsLevelsOptions,
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSubjectRequest $request)
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
                        "visibility" => Visibility::Public->value,
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
        Toast::title('New Subject successfuly submitted for contribution!')->autoDismiss(15);
        return redirect()->route('contribution.index');
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
