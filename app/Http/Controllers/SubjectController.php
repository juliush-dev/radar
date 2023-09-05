<?php

namespace App\Http\Controllers;

use App\Enums\ModificationRequestState;
use App\Enums\ModificationType;
use App\Enums\Visibility;
use App\Enums\YearLevel;
use App\Http\Requests\StoreSubjectRequest;
use App\Http\Requests\UpdateSubjectRequest;
use App\Models\ModificationRequest;
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
    public function create()
    {
        $getKeyValuePair = function ($acc, $value) {
            $acc[$value] = $value;
            return $acc;
        };

        $yearsLevels = YearLevel::cases();
        $yearsLevelsOptions = array_column($yearsLevels, 'value');
        $yearsLevelsOptions = array_reduce($yearsLevelsOptions, $getKeyValuePair, []);

        $modificationsTypes = [ModificationType::CreateAndMakePrivate, ModificationType::CreateAndMakePublic];
        $modificationsTypesOptions = array_column($modificationsTypes, 'value');
        $modificationsTypesOptions = array_reduce($modificationsTypesOptions, $getKeyValuePair, []);

        $teachers = Teacher::whereHas('contribution', function ($query) {
            $query->where('contributor_id', Auth::user()->id)->orWhere(function ($query) {
                $query->where('visibility', Visibility::Public->value)
                    ->whereHas('modificationRequest', function ($query) {
                        $query->where('modification_request_state', ModificationRequestState::Approved->value);
                    });
            });
        })->get();
        return view('subject.create', [
            'yearsLevelsOptions' => $yearsLevelsOptions,
            'teachers' => $teachers,
            'modificationsTypesOptions' => $modificationsTypesOptions,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSubjectRequest $request)
    {
        DB::transaction(function () use ($request) {
            $modificationRequest = ModificationRequest::create(
                [
                    'reason' => null,
                    'modification_request_state' => ModificationRequestState::Pending->value,
                    'modification_type' => $request->enum("modification_type", ModificationType::class)?->value,
                ]
            );
            $subject = Subject::create([
                'teacher_id' => $request->input('teacher_id'),
                'description' =>  $request->input('description'),
                'year_levels_covered_by_it' => implode(",", $request->input('year_levels_covered_by_it')),
            ]);
            $subject->contribution()->create(
                [
                    'contributor_id' => Auth::user()->id,
                    'title' => $request->input('title'),
                    'modification_request_id' => $modificationRequest->id
                ]
            );
        });
        Toast::title('New Subject successfuly added to contributions!')->autoDismiss(10);
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
