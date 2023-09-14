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
use App\Models\Contribution;
use App\Models\Subject;
use App\Models\Topic;
use App\Models\TopicSubject;
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

        $publicSubjects = Contribution::where('contribution_type', Subject::class)
            ->where('contributor_id', Auth::user()->id)
            ->where('visibility', Visibility::Public->value)
            ->orWhere(function ($query) {
                $query->where('visibility', Visibility::Public->value)
                    ->whereHas('modificationRequests', function ($query) {
                        $query->where('modification_request_state', ModificationRequestState::Approved->value);
                    });
            })
            ->get()->pluck('title', 'contribution_id');
        dd($publicSubjects);
        return view(
            'contribution.topic.create',
            [
                'yearsLevelsOptions' => $yearsLevelsOptions,
                'topicFieldsOptions' => $topicFieldsOptions,
                'publicSubjects' => $publicSubjects,
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
                    'year_teached_at' => $request->input('years_teached_at'),
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

                $topicSubject = new TopicSubject;
                $topicSubject->topic_id = $topic->id;
                $topicSubject->subject_id = $request->subject_id;
                $topicSubject->save();
            }
        );
        Toast::title('New Topic successfuly submitted for contribution!')->autoDismiss(15);
        return redirect()->route('contribution.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Topic $topic)
    {
        //
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
