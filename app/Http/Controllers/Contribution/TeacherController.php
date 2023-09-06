<?php

namespace App\Http\Controllers\Contribution;

use App\Enums\ModificationRequestState;
use App\Enums\ModificationType;
use App\Enums\Salutation;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTeacherRequest;
use App\Http\Requests\UpdateTeacherRequest;
use App\Models\ModificationRequest;
use App\Models\Teacher;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use ProtoneMedia\Splade\Facades\Toast;

class TeacherController extends Controller
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

        $salutations = Salutation::cases();
        $salutationsOptions = array_column($salutations, 'value');
        $salutationsOptions = array_reduce($salutationsOptions, $getKeyValuePair, []);

        $modificationsTypes = [ModificationType::CreateAndMakePrivate, ModificationType::CreateAndMakePublic];
        $modificationsTypesOptions = array_column($modificationsTypes, 'value');
        $modificationsTypesOptions = array_reduce($modificationsTypesOptions, $getKeyValuePair, []);

        return view('teacher.create', [
            'salutationsOptions' => $salutationsOptions,
            'modificationsTypesOptions' => $modificationsTypesOptions,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTeacherRequest $request)
    {

        DB::transaction(function () use ($request) {
            $modificationRequest = ModificationRequest::create(
                [
                    'reason' => null,
                    'modification_request_state' => ModificationRequestState::Pending->value,
                    'modification_type' => $request->enum("modification_type", ModificationType::class)?->value,
                ]
            );
            $teacher = Teacher::create([
                'name' => $request->input('name'),
                'salutation' =>  $request->input('salutation'),
                'email' => $request->input('email'),
            ]);
            $teacher->contribution()->create(
                [
                    'contributor_id' => Auth::user()->id,
                    'modification_request_id' => $modificationRequest->id,
                    "title" => $teacher->name,
                ]
            );
        });
        Toast::title('New Teacher successfuly added to contributions!')->autoDismiss(10);
        return redirect()->route('contribution.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Teacher $teacher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Teacher $teacher)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTeacherRequest $request, Teacher $teacher)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Teacher $teacher)
    {
        //
    }
}
