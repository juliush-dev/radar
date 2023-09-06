<?php

namespace App\Http\Controllers\Contribution;

use App\Enums\KnowledgeField;
use App\Enums\KnowledgeGroup;
use App\Enums\ModificationRequestState;
use App\Enums\ModificationType;
use App\Enums\Source;
use App\Enums\YearLevel;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSkillRequest;
use App\Http\Requests\UpdateSkillRequest;
use App\Models\Skill;
use App\Tables\Contribution\Skills;
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
        $contributedSkills = Skills::class;
        return view('contribution.skill.index', ['contributedSkills' => $contributedSkills]);
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
            'contribution.skill.create',
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
                $skill = Skill::create([
                    'fields_covered_by_it' => implode(",", $request->input('fields_covered_by_it')),
                    'years_levels_covering_it' => implode(",", $request->input('years_levels_covering_it')),
                    'knowledge_group_covering_it' => implode("", [$request->enum('knowledge_group_covering_it', KnowledgeGroup::class)?->value]),
                ]);

                $contribution = $skill->contribution()->create(
                    [
                        'contributor_id' => Auth::user()->id,
                        "title" => $request->input('title'),
                        "source" => $request->input('source'),
                        "link" => $request->enum('source', Source::class) == Source::InternetPage ? $request->input('link') : null,
                    ]
                );

                $contribution->modificationRequests()->create(
                    [
                        'reason' => null,
                        'modification_request_state' => ModificationRequestState::Pending->value,
                        'modification_type' => $request->enum("modification_type", ModificationType::class)?->value,
                    ]
                );
            }
        );
        Toast::title('New Skill successfuly added to contributions!')->autoDismiss(15);
        return redirect()->route('contribution.skill.index');
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
