<?php

namespace App\Http\Controllers;

use App\Enums\ModificationRequestState;
use App\Enums\ModificationType;
use App\Enums\Visibility;
use App\Http\Requests\StoreSkillTopicRequest;
use App\Http\Requests\UpdateSkillTopicRequest;
use App\Models\Skill;
use App\Models\SkillTopic;
use App\Models\Topic;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use ProtoneMedia\Splade\Facades\Toast;

class SkillTopicController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Skill $skill)
    {

        $requirements = $skill->skillTopics;
        $skillTopics = Topic::whereIn('id', $requirements->map(fn ($r) => $r->topic_id)->toArray())->get();
        return view('skill-topic.index', [
            'skill' => $skill,
            'skillTopics' => $skillTopics,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Skill $skill)
    {
        $publicCondition =
            function ($query) use ($skill) {
                $query->where('visibility', Visibility::Public->value)
                    ->whereHas(
                        'modificationRequests',
                        function (Builder $query) use ($skill) {
                            $query->latest('created_at')->whereIn(
                                'modification_type',
                                [
                                    ModificationType::Update->value,
                                    ModificationType::Create->value,
                                ]
                            )
                                ->where(
                                    function ($query) use ($skill) {
                                        $query->where(
                                            'modification_request_state',
                                            ModificationRequestState::Approved->value
                                        );
                                        if (Auth::check()) {
                                            $query->orWhere(
                                                function ($query) use ($skill) {
                                                    $query->where('visibility', Visibility::Public->value)
                                                        ->where(
                                                            'modification_request_state',
                                                            ModificationRequestState::Pending->value
                                                        )->where('contributor_id', Auth::user()->id)
                                                        ->whereNotIn('id', Topic::whereIn('id', $skill->skillTopics->pluck('topic_id'))->get()->pluck('id'));
                                                }
                                            );
                                        }
                                    }
                                );
                        }
                    );
            };

        $publicTopics = Topic::whereNotIn('id', Topic::whereIn('id', $skill->skillTopics->pluck('topic_id'))->get()->pluck('id')->toArray())
            ->where(function ($query) use ($skill) {
                foreach (explode(",", $skill->years_levels_covering_it) as $y) {
                    $query->orWhereRaw('FIND_IN_SET(?, years_teached_at)', [$y]);
                }
            })->where(function ($query) use ($skill) {
                foreach (explode(",", $skill->fields_covered_by_it) as $f) {
                    $query->orWhereRaw('FIND_IN_SET(?, topic_field)', [$f]);
                }
            })
            ->whereHas(
                'contribution',
                $publicCondition,
            )->get();
        return view('skill-topic.create', [
            'skill' => $skill,
            'topicsOptions' => $publicTopics,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSkillTopicRequest $request, SKill $skill)
    {
        DB::transaction(
            function () use ($request, $skill) {
                foreach ($request->input('topics') as $topicId) {
                    $skillRequiremnt = new  SkillTopic;
                    $skillRequiremnt->skill_id = $skill->id;
                    $skillRequiremnt->topic_id = $topicId;
                    $skillRequiremnt->save();
                }
            }
        );
        Toast::title(collect($request->input('topics'))->count() . ' Topic(s) successfuly added to' . $skill->contribution->title)->autoDismiss(15);
        return redirect()->route('contribution.skill.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(SkillTopic $skillRequiremnt)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SkillTopic $skillRequiremnt)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSkillTopicRequest $request, SkillTopic $skillRequiremnt)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SkillTopic $skillRequiremnt)
    {
        //
    }
}
