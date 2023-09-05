<?php

namespace App\Http\Controllers;

use App\Enums\KnowledgeField;
use App\Enums\KnowledgeGroup;
use App\Enums\ModificationRequestState;
use App\Enums\ModificationType;
use App\Enums\Source;
use App\Enums\YearLevel;
use App\Http\Requests\StoreSkillRequest;
use App\Http\Requests\UpdateSkillRequest;
use App\Models\ModificationRequest;
use App\Models\Skill;
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
        $skills = Skill::whereHas('contribution', function ($query) {
            $query->where('contribution_type', Skill::class)
                ->whereHas('modificationRequest', function ($query) {
                    $query->where('modification_request_state', ModificationRequestState::Approved->value)
                        ->where(function ($query) {
                            $query->where('modification_type', ModificationType::MakePublic->value)
                                ->orWhere('modification_type', ModificationType::CreateAndMakePublic->value);
                        });
                });
        })->get();
        return view('skill.index', ['skills' => $skills]);
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

        $sources = Source::cases();
        $sourcesOptions = array_column($sources, 'value');
        $sourcesOptions = array_reduce($sourcesOptions, $getKeyValuePair, []);

        $yearsLevels = YearLevel::cases();
        $yearsLevelsOptions = array_column($yearsLevels, 'value');
        $yearsLevelsOptions = array_reduce($yearsLevelsOptions, $getKeyValuePair, []);


        $knowledgeFields = KnowledgeField::cases();
        $knowledgeFieldsOptions = array_column($knowledgeFields, 'value');
        $knowledgeFieldsOptions = array_reduce($knowledgeFieldsOptions, $getKeyValuePair, []);


        $knowledgeGroups = KnowledgeGroup::cases();
        $knowledgeGroupsOptions = array_column($knowledgeGroups, 'value');
        $knowledgeGroupsOptions = array_reduce($knowledgeGroupsOptions, $getKeyValuePair, []);

        $modificationsTypes = [ModificationType::CreateAndMakePrivate, ModificationType::CreateAndMakePublic];
        $modificationsTypesOptions = array_column($modificationsTypes, 'value');
        $modificationsTypesOptions = array_reduce($modificationsTypesOptions, $getKeyValuePair, []);

        return view(
            'skill.create',
            [
                'sourcesOptions' => $sourcesOptions,
                'yearsLevelsOptions' => $yearsLevelsOptions,
                'knowledgeFieldsOptions' => $knowledgeFieldsOptions,
                'knowledgeGroupsOptions' => $knowledgeGroupsOptions,
                'modificationsTypesOptions' => $modificationsTypesOptions,
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSkillRequest $request)
    {
        DB::transaction(
            function () use ($request) {
                $modificationRequest = ModificationRequest::create(
                    [
                        'reason' => null,
                        'modification_request_state' => ModificationRequestState::Pending->value,
                        'modification_type' => $request->enum("modification_type", ModificationType::class)?->value,
                    ]
                );
                // dd($request->input('fields_covered_by_it'));
                $skill = Skill::create([
                    'fields_covered_by_it' => implode(",", $request->input('fields_covered_by_it')),
                    'years_levels_covering_it' => implode(",", $request->input('years_levels_covering_it')),
                    'knowledge_group_covering_it' => implode("", [$request->enum('knowledge_group_covering_it', KnowledgeGroup::class)?->value]),
                ]);



                $skill->contribution()->create(
                    [
                        'contributor_id' => Auth::user()->id,
                        'modification_request_id' => $modificationRequest->id,
                        "title" => $request->input('title'),
                        "source" => $request->input('source'),
                        "link" => $request->enum('source', Source::class) == Source::InternetPage ? $request->input('link') : null,
                    ]
                );
            }
        );
        Toast::title('New Skill successfuly added to contributions!')->autoDismiss(10);
        return redirect()->route('contribution.index');
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
