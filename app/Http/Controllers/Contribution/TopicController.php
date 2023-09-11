<?php

namespace App\Http\Controllers\Contribution;

use App\Enums\ModificationRequestState;
use App\Enums\ModificationType;
use App\Enums\TopicField;
use App\Enums\Visibility;
use App\Enums\YearLevel;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTopicRequest;
use App\Http\Requests\UpdateTopicRequest;
use App\Models\Topic;
use App\Tables\Contribution\Topics;
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
        $contributedTopics = new Topics;
        return view('contribution.topic.index', ['contributedTopics' => $contributedTopics]);
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


        return view(
            'contribution.topic.create',
            [
                'yearsLevelsOptions' => $yearsLevelsOptions,
                'topicFieldsOptions' => $topicFieldsOptions,
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTopicRequest $request)
    {
        DB::transaction(
            function () use ($request) {
                $topic = Topic::create([
                    'years_teached_at' => implode(",", $request->input('years_teached_at')),
                    'topic_field' =>  $request->input('topic_field'),
                ]);

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
            }
        );
        Toast::title('New Topic successfuly submitted for contribution!')->autoDismiss(15);
        return redirect()->route('contribution.topic.index');
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
