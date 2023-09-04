<?php

namespace App\Http\Controllers;

use App\Enums\KnowledgeField;
use App\Enums\KnowledgeGroup;
use App\Enums\ModificationRequestState;
use App\Enums\ModificationType;
use App\Enums\Source;
use App\Enums\Visibility;
use App\Enums\YearLevel;
use App\Http\Requests\StoreContributionRequest;
use App\Http\Requests\UpdateContributionRequest;
use App\Models\Contribution;
use App\Models\KnowHow;
use App\Models\LearningMaterial;
use App\Models\ModificationRequest;
use App\Models\PriorKnowledge;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ContributionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contributions = Auth::user()->contributions;
        $contributionsReferences = $contributions->map(function (Contribution $contribution) {
            return $contribution->reference();
        });
        $contributedKnowHow = $contributionsReferences->filter(
            function ($reference) {
                return $reference instanceof KnowHow;
            }
        );
        dd($contributedKnowHow);
        $contributedPriorKnowledge = $contributionsReferences->filter(
            function ($reference) {
                return $reference instanceof PriorKnowledge;
            }
        );

        $publicApprovedKnowHowAvailable =
            KnowHow::whereHas('contribution', function ($query) {
                $query->where(
                    'visibility',
                    Visibility::Public->value,
                )->whereHas(
                    'modificationRequest',
                    function ($query) {
                        $query->where(
                            'modification_request_state',
                            ModificationRequestState::Approved->value,
                        );
                    }
                );
            })->exists();


        $publicApprovedPriorKnowledgeAvailable =
            PriorKnowledge::whereHas('contribution', function ($query) {
                $query->where(
                    'visibility',
                    Visibility::Public->value,
                )->whereHas(
                    'modificationRequest',
                    function ($query) {
                        $query->where(
                            'modification_request_state',
                            ModificationRequestState::Approved->value,
                        );
                    }
                );
            })->exists();


        $publicApprovedSubjectsPublicAvailable =
            Subject::whereHas('contribution', function ($query) {
                $query->where(
                    'visibility',
                    Visibility::Public->value,
                )->whereHas(
                    'modificationRequest',
                    function ($query) {
                        $query->where(
                            'modification_request_state',
                            ModificationRequestState::Approved->value,
                        );
                    }
                );
            })->exists();

        $publicApprovedLearningMaterialsAvailable =
            LearningMaterial::whereHas('contribution', function ($query) {
                $query->where(
                    'visibility',
                    Visibility::Public->value,
                )->whereHas(
                    'modificationRequest',
                    function ($query) {
                        $query->where(
                            'modification_request_state',
                            ModificationRequestState::Approved->value,
                        );
                    }
                );
            })->exists();

        return view(
            'contribution.index',
            [
                'contributedKnowHow' => $contributedKnowHow,
                'contributedPriorKnowledge' => $contributedPriorKnowledge,
                'publicApprovedKnowHowAvailable' => $publicApprovedKnowHowAvailable,
                'publicApprovedPriorKnowledgeAvailable' => $publicApprovedPriorKnowledgeAvailable,
                'publicApprovedSubjectsPublicAvailable' => $publicApprovedSubjectsPublicAvailable,
                'publicApprovedLearningMaterialsAvailable' => $publicApprovedLearningMaterialsAvailable,
            ],
        );
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
            'contribution.create',
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
    public function store(StoreContributionRequest $request)
    {
        $modificationRequest = ModificationRequest::create(
            [
                'reason' => null,
                'modification_request_state' => ModificationRequestState::Pending->value,
                'modification_type' => $request->enum("modification_type", ModificationType::class)?->value,
            ]
        );
        // dd($request->input('fields_covered_by_it'));
        $knowHow = KnowHow::create([
            'fields_covered_by_it' => implode(",", $request->input('fields_covered_by_it')),
            'years_levels_covering_it' => implode(",", $request->input('years_levels_covering_it')),
            'knowledge_group_covering_it' => implode("", [$request->enum('knowledge_group_covering_it', KnowledgeGroup::class)?->value]),
        ]);



        $knowHow->contribution()->create(
            [
                'contributor_id' => Auth::user()->id,
                'modification_request_id' => $modificationRequest->id,
                "title" => $request->input('title'),
                "source" => $request->input('source'),
                "link" => $request->enum('source', Source::class) == Source::InternetPage ? $request->input('link') : null,
            ]
        );
        return redirect()->route('contribution.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Contribution $contribution)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contribution $contribution)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContributionRequest $request, Contribution $contribution)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contribution $contribution)
    {
        //
    }
}
