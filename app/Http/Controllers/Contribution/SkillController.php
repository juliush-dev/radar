<?php

namespace App\Http\Controllers\Contribution;

use App\Enums\TopicField;
use App\Enums\TopicGroup;
use App\Enums\ModificationRequestState;
use App\Enums\ModificationType;
use App\Enums\Source;
use App\Enums\Visibility;
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
        $contributedSkills = new Skills;
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

        $yearsLevels = YearLevel::cases();
        $yearsLevelsOptions = array_column($yearsLevels, 'value');
        $yearsLevelsOptions = array_reduce($yearsLevelsOptions, $getKeyValuePair, []);


        $topicFields = TopicField::cases();
        $topicFieldsOptions = array_column($topicFields, 'value');
        $topicFieldsOptions = array_reduce($topicFieldsOptions, $getKeyValuePair, []);


        $topicGroups = TopicGroup::cases();
        $topicGroupsOptions = array_column($topicGroups, 'value');
        $topicGroupsOptions = array_reduce($topicGroupsOptions, $getKeyValuePair, []);

        return view(
            'contribution.skill.create',
            [
                'yearsLevelsOptions' => $yearsLevelsOptions,
                'topicFieldsOptions' => $topicFieldsOptions,
                'topicGroupsOptions' => $topicGroupsOptions,
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
                    'topic_group_covering_it' => implode("", [$request->enum('topic_group_covering_it', TopicGroup::class)?->value]),
                ]);

                $contribution = $skill->contribution()->create(
                    [
                        'contributor_id' => Auth::user()->id,
                        "title" => $request->input('title'),
                        "visibility" => $request->input('visibility'),
                    ]
                );

                $contribution->modificationRequests()->create(
                    [
                        'modification_request_state' => ModificationRequestState::Pending->value,
                        'modification_type' => ModificationType::Create->value,
                    ]
                );
            }
        );
        Toast::title('New Skill successfuly submitted for contribution!')->autoDismiss(15);
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
