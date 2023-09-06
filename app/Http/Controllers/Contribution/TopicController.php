<?php

namespace App\Http\Controllers\Contribution;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTopicRequest;
use App\Http\Requests\UpdateTopicRequest;
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
    public function create()
    {
        // $getKeyValuePair = function ($acc, $value) {
        //     $acc[$value] = $value;
        //     return $acc;
        // };

        // $sources = Source::cases();
        // $sourcesOptions = array_column($sources, 'value');
        // $sourcesOptions = array_reduce($sourcesOptions, $getKeyValuePair, []);

        // $yearsLevels = YearLevel::cases();
        // $yearsLevelsOptions = array_column($yearsLevels, 'value');
        // $yearsLevelsOptions = array_reduce($yearsLevelsOptions, $getKeyValuePair, []);


        // $topicFields = TopicField::cases();
        // $topicFieldsOptions = array_column($topicFields, 'value');
        // $topicFieldsOptions = array_reduce($topicFieldsOptions, $getKeyValuePair, []);


        // $topicGroups = TopicGroup::cases();
        // $topicGroupsOptions = array_column($topicGroups, 'value');
        // $topicGroupsOptions = array_reduce($topicGroupsOptions, $getKeyValuePair, []);

        // $modificationsTypes = [ModificationType::CreateAndMakePrivate, ModificationType::CreateAndMakePublic];
        // $modificationsTypesOptions = array_column($modificationsTypes, 'value');
        // $modificationsTypesOptions = array_reduce($modificationsTypesOptions, $getKeyValuePair, []);

        // return view(
        //     'topic.create',
        //     [
        //         'sourcesOptions' => $sourcesOptions,
        //         'yearsLevelsOptions' => $yearsLevelsOptions,
        //         'topicFieldsOptions' => $topicFieldsOptions,
        //         'topicGroupsOptions' => $topicGroupsOptions,
        //         'modificationsTypesOptions' => $modificationsTypesOptions,
        //     ]
        // );
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
