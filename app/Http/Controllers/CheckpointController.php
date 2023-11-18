<?php

namespace App\Http\Controllers;

use App\Models\Checkpoint;
use App\Models\CheckpointKnowledge;
use App\Models\KnowledgeCube;
use App\Models\Topic;
use App\Models\UserCheckpointSession;
use App\Services\RadarQuery;
use Exception;
use Facades\Spatie\Referer\Referer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use ProtoneMedia\Splade\Facades\Toast;

class CheckpointController extends Controller
{
    public function __construct(private RadarQuery $rq)
    {
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Topic $topic)
    {
        return view('checkpoint.create', [
            'rq' => $this->rq,
            'topic' => $topic,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, ?Topic $topic, ?Checkpoint $checkpoint)
    {
        $newCheckpoint = null;
        DB::transaction(function () use ($request, &$newCheckpoint, $topic, $checkpoint) {
            $title = trim($request->input('title', ''));
            $summary = trim($request->input('summary', ''));
            $knowledgeCubes = $request->input('knowledgeCubes', []);

            if (!empty($title)) {
                $newCheckpoint = new Checkpoint;
                $newCheckpoint->title = $title;
                $newCheckpoint->user_id = $request->user()->id;
                $newCheckpoint->topic_id =  $topic->id;
                $newCheckpoint->summary =  $summary;
                $newCheckpoint->save();

                if ($checkpoint->exists) {
                    $newCheckpoint->is_update = true;
                    $newCheckpoint->potential_replacement_of = $checkpoint->id;
                    $newCheckpoint->save();

                    $checkpoint->potential_replacement = $newCheckpoint->id;
                    $checkpoint->save();
                }
            } else {
                throw new Exception("Error Processing Request", 1);
            }
            collect($knowledgeCubes)->each(function ($cube) use ($request, $newCheckpoint) {
                $subject = trim($cube['subject'] ?? '');
                if (empty($subject)) {
                    throw new Exception("Error Processing Request", 1);
                }
                $knowledge = $cube['knowledge'];

                $newCube = new KnowledgeCube;
                $newCube->checkpoint_id = $newCheckpoint->id;
                $newCube->subject = $subject;
                $newCube->save();

                if ($newCheckpoint->is_update && !empty($cube['id'])) {
                    $foundCube =  $newCheckpoint->potentialReplacementOf->knowledgeCubes()->find($cube['id']);
                    $newCube->is_update = true;
                    $newCube->potential_replacement_of = $foundCube->id;
                    $newCube->save();

                    $foundCube->potential_replacement = $newCube->id;
                    $foundCube->save();
                }

                collect($knowledge)->each(function ($content) use ($request, $newCube) {
                    $newContent = new CheckpointKnowledge;

                    $newContent->checkpoint_id = $newCube->checkpoint_id;
                    $newContent->user_id = $request->user()->id;
                    $newContent->knowledge_cube_id = $newCube->id;

                    $newContent->assisted = $content['assisted'] ?? false;
                    $newContent->information = $content['information'];
                    $newContent->implications = $content['implications'];
                    $newContent->external_reference = $content['external_reference'];

                    $newContent->save();

                    if ($newCube->is_update && !empty($content['id'])) {
                        $foundContent =  $newCube->potentialReplacementOf->knowledge()->find($content['id']);
                        $newContent->is_update = true;
                        $newContent->potential_replacement_of = $foundContent->id;
                        $newContent->save();

                        $foundContent->potential_replacement = $newContent->id;
                        $foundContent->save();
                    }
                });
            });
        });
        if (!$checkpoint->exists) {
            Toast::title('Checkpoint sucessfuly created!')->autoDismiss(5);
        } else {
            return $newCheckpoint;
        }
        return redirect()->route('checkpoints.preview', $newCheckpoint);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Checkpoint $checkpoint)
    {
        return view('checkpoint.edit', [
            'rq' => $this->rq,
            'checkpoint' => $checkpoint,
            'title' => $checkpoint->title,
            'summary' => $checkpoint->summary,
            'knowledgeCubes' => $checkpoint->knowledgeCubes->reduce(
                function ($acc, $cube) {
                    $cube = [
                        'id' => $cube->id,
                        'subject' => $cube->subject,
                        'knowledge' =>  $cube->knowledge
                    ];
                    array_push($acc, $cube);
                    return $acc;
                },
                []
            ),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Checkpoint $checkpoint)
    {
        $this->authorize('update-checkpoint', [$checkpoint]);
        if ($checkpoint->potentialReplacement != null) {
            Toast::danger("Checkpoint can't be updated. Pending update detected")->autoDismiss(5);
            return back();
        }
        $newCheckpoint = $this->store($request, $checkpoint->topic, $checkpoint);
        Toast::title('Checkpoint sucessfuly updated!')->autoDismiss(5);
        return redirect()->route('checkpoints.preview', $newCheckpoint);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Checkpoint $checkpoint)
    {
        $this->authorize('delete-checkpoint', [$checkpoint]);
        if ($checkpoint->potentialReplacement != null) {
            Toast::danger("Checkpoint can't be delete. Pending update detected")->autoDismiss(5);
            return back();
        }
        $topic = null;
        DB::transaction(
            function () use (&$topic, $checkpoint) {
                $topic = $checkpoint->topic;
                $checkpoint->delete();
            }
        );
        Toast::title('Checkpoint deleted')->autoDismiss(5);

        $redirectRoute = route('topics.show', $topic);
        if (Referer::get() == $currentRoute = route('dashboard.index', ['tab' => 'checkpoints'])) {
            $redirectRoute = $currentRoute;
        }
        return redirect($redirectRoute);
    }

    public function preview(Checkpoint $checkpoint)
    {
        $this->authorize('preview-checkpoint', [$checkpoint]);
        return view('checkpoint-session.preview', [
            'checkpoint' => $checkpoint,
            'rq' => $this->rq
        ]);
    }

    public function initiate(?Request $request, Checkpoint $checkpoint)
    {
        $this->authorize('record-checkpoint', [$checkpoint]);
        $session = null;
        DB::transaction(function () use ($request, &$session, $checkpoint) {
            $session = new UserCheckpointSession;
            $session->user_id = $request->user()->id;
            $session->checkpoint_id = $checkpoint->id;
            $session->countdown = $request->input('countdown', 60);
            $session->started = true;
            $session->save();
        });
        return redirect(route('sessions.start', $session));
    }

    public function unpublish(Checkpoint $checkpoint)
    {
        $this->authorize('use-dashboard');
        $checkpoint->is_public = 0;
        $checkpoint->save();
        return redirect(Referer::get());
    }

    public function publish(Checkpoint $checkpoint)
    {
        $this->authorize('use-dashboard');
        $checkpoint->is_public = 1;
        $checkpoint->save();
        return redirect(Referer::get());
    }

    public function applyUpdate(Checkpoint $checkpoint)
    {
        $this->authorize('use-dashboard');
        DB::transaction(
            function () use ($checkpoint) {
                $oldCheckpoint = $checkpoint->potentialReplacementOf;
                if ($oldCheckpoint->potentialReplacementOf) {
                    $checkpoint->potential_replacement_of = $oldCheckpoint->potentialReplacementOf->id;
                    $oldCheckpoint->potentialReplacementOf->potential_replacement = $checkpoint->id;
                    $oldCheckpoint->potentialReplacementOf->save();
                } else {
                    $checkpoint->is_update = 0;
                }

                $oldCheckpoint->userSessions->each(function ($session) use ($checkpoint) {
                    $session->checkpoint_id = $checkpoint->id;
                    $session->save();
                    $session->userResults->each(function ($result) use ($checkpoint) {
                        $QA = $checkpoint->knowledgeAnswerSets()->where('potential_replacement_of', $result->knowledge_id)->first();
                        if ($QA != null) {
                            $result->knowledge_id = $QA->id;
                            $result->save();
                        } else {
                            $result->delete();
                        }
                    });
                    if ($session->userResults->count() == 0) {
                        $session->delete();
                    }
                });

                $oldCheckpoint->delete();
                $checkpoint->is_public = true;
                $checkpoint->save();
            }
        );
        Toast::title('Update applied')->autoDismiss(8);
        return redirect(Referer::get());
    }
}
