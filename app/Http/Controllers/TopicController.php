<?php

namespace App\Http\Controllers;

use App\Enums\ModificationRequestState;
use App\Enums\ModificationType;
use App\Enums\TopicField;
use App\Enums\Visibility;
use App\Enums\YearLevel;
use App\Http\Requests\StoreTopicRequest;
use App\Http\Requests\UpdateTopicRequest;
use App\Models\Contribution;
use App\Models\Skill;
use App\Models\SkillTopic;
use App\Models\Subject;
use App\Models\TopicSubject;
use App\Models\Topic;
use App\Tables\Topics;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use ProtoneMedia\Splade\Facades\Toast;

class TopicController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
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

        $publicSubjects = Contribution::where('contribution_type', Subject::class)
            ->where(function ($query) {
                if (Auth::check()) {
                    $query->where('contributor_id', Auth::user()->id);
                }
            })
            ->where('visibility', Visibility::Public->value)
            ->orWhere(function ($query) {
                $query->where('visibility', Visibility::Public->value)
                    ->whereHas('modificationRequests', function ($query) {
                        $query->where('modification_request_state', ModificationRequestState::Approved->value);
                    });
            })
            ->get()->pluck('title', 'contribution_id');

        $topicsIndex = new Topics;
        return view('topic.index', [
            'publicTopics' => $topicsIndex->for(),
            'yearsLevelsOptions' => $yearsLevelsOptions,
            'topicFieldsOptions' => $topicFieldsOptions,
            'publicSubjects' => $publicSubjects,
        ]);
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

        $yearsLevelsOptions = explode(",", $skill->years_levels_covering_it);
        $yearsLevelsOptionsPair = array_reduce($yearsLevelsOptions, $getKeyValuePair, []);

        $fieldsOptions = explode(",", $skill->fields_covered_by_it);
        $fieldsOptionsPair = array_reduce($fieldsOptions, $getKeyValuePair, []);
        $subjects = Subject::where(function ($query) use ($skill) {
            $query->where(function ($query) use ($skill) {
                foreach (explode(",", $skill->years_levels_covering_it) as $y) {
                    $query->orWhereRaw('FIND_IN_SET(?, year_levels_covered_by_it)', [$y]);
                }
            })
                ->whereHas(
                    'contribution',
                    function ($query) {
                        $query->where('contributor_id', Auth::user()->id)
                            ->whereNot('visibility', Visibility::Disabled->value)
                            ->whereHas('modificationRequests', function ($query) {
                                $query->latest('created_at')
                                    ->whereIn('modification_type', [
                                        ModificationType::Create->value,
                                        ModificationType::Update->value,
                                    ])->whereIn(
                                        'modification_request_state',
                                        [
                                            ModificationRequestState::Pending->value,
                                            ModificationRequestState::Approved->value,
                                        ]
                                    );
                            })->orWhere(function ($query) {
                                $query->whereNot('contributor_id', Auth::user()->id)
                                    ->where('visibility', Visibility::Public->value)
                                    ->whereHas('modificationRequests', function ($query) {
                                        $query->latest('created_at')
                                            ->whereIn('modification_type', [
                                                ModificationType::Create->value,
                                                ModificationType::Update->value,
                                            ])->where(
                                                'modification_request_state',
                                                ModificationRequestState::Approved->value
                                            );
                                    });
                            });
                    }
                );
        })->get();
        $subjectsOptionsPair = $subjects->reduce(function ($acc, $subjcet) {
            $acc[] = [
                'id' => $subjcet->id,
                'title' => $subjcet->contribution->title
            ];
            return $acc;
        }, []);

        return view('topic.create', [
            'yearsLevelsOptionsPair' => $yearsLevelsOptionsPair,
            'fieldsOptionsPair' => $fieldsOptionsPair,
            'subjectsOptionsPair' => $subjectsOptionsPair,
            'skill' => $skill,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTopicRequest $request, Skill $skill)
    {
        DB::transaction(
            function () use ($request, $skill) {

                $topicId = null;
                if (!$request->has('topic')) {
                    $topic = Topic::create([
                        'year_teached_at' =>  $request->input('years_teached_at'),
                        'topic_field' =>  $request->input('topic_field'),
                    ]);
                    $topicId = $topic->id;
                    $contribution = $topic->contribution()->create(
                        [
                            'contributor_id' => Auth::user()->id,
                            "title" => $request->input('title'),
                            "visibility" => Visibility::Public->value,
                        ]
                    );
                    $contribution->modificationRequests()->create(
                        [
                            'modification_request_state' => ModificationRequestState::Pending->value,
                            'modification_type' => ModificationType::Create->value,
                        ]
                    );
                    $topicSubject = new TopicSubject;
                    $topicSubject->subject_id = $request->input('subject');
                    $topicSubject->topic_id = $topicId;
                    $topicSubject->save();
                } else {
                    $topicId = $request->input('topic');
                }
                $skillRequirement = new SkillTopic;
                $skillRequirement->skill_id = $skill->id;
                $skillRequirement->topic_id = $topicId;
                $skillRequirement->save();
            }
        );
        Toast::title('New Topic successfuly added!')->autoDismiss(15);
        return redirect()->route('skill.show', $skill);
    }

    /**
     * Display the specified resource.
     */
    public function show(Skill $skill, Topic $topic)
    {
        return view(
            'topic.show',
            [
                'skill' => $skill,
                'topic' => $topic,
                // 'publicSkills' => $skillsIndex->for(),
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Topic $topic)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTopicRequest $request, Topic $topic)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Topic $topic)
    {
        //
    }
}
