<?php

namespace App\Http\Controllers;

use App\Enums\ModificationRequestState;
use App\Enums\ModificationType;
use App\Enums\Visibility;
use App\Http\Requests\StoreTopicSubjectRequest;
use App\Http\Requests\UpdateTopicSubjectRequest;
use App\Models\Subject;
use App\Models\TopicSubject;
use App\Models\Topic;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use ProtoneMedia\Splade\Facades\Toast;

class TopicSubjectController extends Controller
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
    public function create(Topic $topic)
    {
        $publicCondition =
            function ($query) use ($topic) {
                $query->where('visibility', Visibility::Public->value)
                    ->whereHas(
                        'modificationRequests',
                        function (Builder $query) use ($topic) {
                            $query->latest('created_at')->whereIn(
                                'modification_type',
                                [
                                    ModificationType::Update->value,
                                    ModificationType::Create->value,
                                ]
                            )
                                ->where(
                                    function ($query) use ($topic) {
                                        $query->where(
                                            'modification_request_state',
                                            ModificationRequestState::Approved->value
                                        );
                                        if (Auth::check()) {
                                            $query->orWhere(
                                                function ($query) use ($topic) {
                                                    $query->where('visibility', Visibility::Public->value)
                                                        ->where(
                                                            'modification_request_state',
                                                            ModificationRequestState::Pending->value
                                                        )->where('contributor_id', Auth::user()->id);
                                                }
                                            );
                                        }
                                    }
                                );
                        }
                    );
            };

        $publicSubjects = Subject::where(function ($query) use ($topic) {
            foreach (explode(",", $topic->years_teached_at) as $y) {
                $query->orWhereRaw('FIND_IN_SET(?, year_levels_covered_by_it)', [$y]);
            }
        })
            ->whereHas(
                'contribution',
                $publicCondition,
            )->get();
        return view('topic-subject.create', [
            'topic' => $topic,
            'subjectsOptions' => $publicSubjects,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTopicSubjectRequest $request, Topic $topic)
    {
        DB::transaction(
            function () use ($request, $topic) {
                $topicSubject = new  TopicSubject;
                $topicSubject->topic_id = $topic->id;
                $topicSubject->subject_id = $request->subject;
                $topicSubject->save();
            }
        );
        Toast::title('Subject successfuly added to ' . $topic->contribution->title)->autoDismiss(15);
        return redirect()->route('contribution.topic.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(TopicSubject $subjectCoveringTopic)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TopicSubject $subjectCoveringTopic)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTopicSubjectRequest $request, TopicSubject $subjectCoveringTopic)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TopicSubject $subjectCoveringTopic)
    {
        //
    }
}
