<?php

namespace App\Http\Controllers;

use App\Enums\ModificationRequestState;
use App\Enums\ModificationType;
use App\Enums\Visibility;
use App\Http\Requests\StoreTopicRequest;
use App\Http\Requests\UpdateTopicRequest;
use App\Models\Skill;
use App\Models\Subject;
use App\Models\Topic;

class TopicController extends Controller
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

        $yearsLevelsOptions = explode(",", $skill->years_levels_covering_it);
        $yearsLevelsOptionsPair = array_reduce($yearsLevelsOptions, $getKeyValuePair, []);

        $fieldsOptions = explode(",", $skill->fields_covered_by_it);
        $fieldsOptionsPair = array_reduce($fieldsOptions, $getKeyValuePair, []);
        $subjects = Subject::whereHas(
            'contribution',
            function ($query) {
                $query->where('visibility', Visibility::Public->value)
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
            }
        )->get();
        $subjectsOptionsPair = $subjects->reduce(function ($acc, $subjcet) {
            $acc['id'] = $subjcet->id;
            $acc['title'] = $subjcet->contribution->title;
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
    public function store(StoreTopicRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Topic $priorTopic)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Topic $priorTopic)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTopicRequest $request, Topic $priorTopic)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Topic $priorTopic)
    {
        //
    }
}
