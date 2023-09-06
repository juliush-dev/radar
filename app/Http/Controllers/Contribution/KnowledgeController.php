<?php

namespace App\Http\Controllers\Contribution;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreKnowledgeRequest;
use App\Http\Requests\UpdateKnowledgeRequest;
use App\Models\Knowledge;

class KnowledgeController extends Controller
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


        // $knowledgeFields = KnowledgeField::cases();
        // $knowledgeFieldsOptions = array_column($knowledgeFields, 'value');
        // $knowledgeFieldsOptions = array_reduce($knowledgeFieldsOptions, $getKeyValuePair, []);


        // $knowledgeGroups = KnowledgeGroup::cases();
        // $knowledgeGroupsOptions = array_column($knowledgeGroups, 'value');
        // $knowledgeGroupsOptions = array_reduce($knowledgeGroupsOptions, $getKeyValuePair, []);

        // $modificationsTypes = [ModificationType::CreateAndMakePrivate, ModificationType::CreateAndMakePublic];
        // $modificationsTypesOptions = array_column($modificationsTypes, 'value');
        // $modificationsTypesOptions = array_reduce($modificationsTypesOptions, $getKeyValuePair, []);

        // return view(
        //     'knowledge.create',
        //     [
        //         'sourcesOptions' => $sourcesOptions,
        //         'yearsLevelsOptions' => $yearsLevelsOptions,
        //         'knowledgeFieldsOptions' => $knowledgeFieldsOptions,
        //         'knowledgeGroupsOptions' => $knowledgeGroupsOptions,
        //         'modificationsTypesOptions' => $modificationsTypesOptions,
        //     ]
        // );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreKnowledgeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Knowledge $priorKnowledge)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Knowledge $priorKnowledge)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateKnowledgeRequest $request, Knowledge $priorKnowledge)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Knowledge $priorKnowledge)
    {
        //
    }
}
