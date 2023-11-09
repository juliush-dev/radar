<?php

namespace App\Http\Controllers;

use App\Models\Checkpoint;
use App\Models\CheckpointQuestionAnswerSet;
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

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(?Checkpoint $previous, ?Topic $topic)
    {
        return view('checkpoint.create', [
            'rq' => $this->rq,
            'topic' => $topic,
            'previous' => $previous
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, ?Topic $topic)
    {
        $checkpoint = null;
        DB::transaction(function () use ($request, &$checkpoint, $topic) {

            $title = $request->input('title');
            $clozes = $request->input('clozes', []);
            $flashCards = $request->input('flashCards');

            if (trim($title)) {
                $checkpoint = new Checkpoint;
                $checkpoint->title = $title;
                $checkpoint->user_id = $request->user()->id;
                $checkpoint->topic_id =  $topic->id;
                $checkpoint->save();
            } else {
                throw new Exception("Error Processing Request", 1);
            }

            collect($clozes)->each(function ($cloze) use ($request, $checkpoint) {
                $checkpointQASet = new CheckpointQuestionAnswerSet;
                $checkpointQASet->user_id = $request->user()->id;
                $checkpointQASet->is_cloze = true;
                $checkpointQASet->is_assisted_cloze = $cloze['is_assisted_cloze'] ?? false;
                $checkpointQASet->checkpoint_id = $checkpoint->id;
                $checkpointQASet->title = $cloze['title'];
                $checkpointQASet->question = $cloze['question'];
                $checkpointQASet->answer = $cloze['answer'];
                $checkpointQASet->save();
            });

            collect($flashCards)->each(function ($flashCard) use ($request, $checkpoint) {
                $checkpointQASet = new CheckpointQuestionAnswerSet;
                $checkpointQASet->user_id = $request->user()->id;
                $checkpointQASet->is_flash_card = true;
                $checkpointQASet->checkpoint_id = $checkpoint->id;
                $checkpointQASet->title = $flashCard['title'];
                $checkpointQASet->question = $flashCard['question'];
                $checkpointQASet->answer = $flashCard['answer'];
                $checkpointQASet->answer_in_place_explanation = $flashCard['answer_in_place_explanation'];
                $checkpointQASet->answer_explanation_redirect = $flashCard['answer_explanation_redirect'];
                $checkpointQASet->save();
            });
        });
        Toast::title('Checkpoint sucessfuly created!')->autoDismiss(5);
        return redirect()->route('topics.show', $topic);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Checkpoint $checkpoint)
    {
        return view('checkpoint.edit', [
            'rq' => $this->rq,
            'clozes' => $checkpoint->questionAnswerSets()->where('is_cloze', true)->get(),
            'flashCards' => $checkpoint->questionAnswerSets()->where('is_flash_card', true)->get(),
            'checkpoint' => $checkpoint,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Checkpoint $checkpoint)
    {
        $newCheckpoint = null;
        DB::transaction(function () use ($request, &$newCheckpoint, $checkpoint) {
            $title = $request->input('title');
            $clozes = $request->input('clozes', []);
            $flashCards = $request->input('flashCards');

            if (empty(trim($title))) {
                throw new Exception("Error Processing Request", 1);
            }
            $newCheckpoint = new Checkpoint;
            $newCheckpoint->is_update = true;
            $newCheckpoint->potential_replacement_of = $checkpoint->id;
            $newCheckpoint->title = $title;
            $newCheckpoint->user_id = $request->user()->id;
            $newCheckpoint->topic_id = $checkpoint->topic->id;
            $newCheckpoint->save();
            $checkpoint->potential_replacement = $newCheckpoint->id;
            $checkpoint->save();

            collect($clozes)->each(function ($cloze) use ($request, $newCheckpoint) {
                $newCheckpointQASet = new CheckpointQuestionAnswerSet;
                $newCheckpointQASet->user_id = $request->user()->id;
                $newCheckpointQASet->is_cloze = true;
                $newCheckpointQASet->is_assisted_cloze = $cloze['is_assisted_cloze'] ?? false;
                $newCheckpointQASet->checkpoint_id = $newCheckpoint->id;
                $newCheckpointQASet->title = $cloze['title'];
                $newCheckpointQASet->question = $cloze['question'];
                $newCheckpointQASet->answer = $cloze['answer'];
                $newCheckpointQASet->save();
                if (!empty($cloze['id'])) {
                    $newCheckpointQASet->potential_replacement_of = $cloze['id'];
                    $newCheckpointQASet->save();
                    $oldQASet = CheckpointQuestionAnswerSet::find($cloze['id']);
                    $oldQASet->potential_replacement = $newCheckpointQASet->id;
                    $oldQASet->save();
                }
            });

            collect($flashCards)->each(function ($flashCard) use ($request, $newCheckpoint) {
                $newCheckpointQASet = new CheckpointQuestionAnswerSet;
                $newCheckpointQASet->user_id = $request->user()->id;
                $newCheckpointQASet->is_flash_card = true;
                $newCheckpointQASet->checkpoint_id = $newCheckpoint->id;
                $newCheckpointQASet->title = $flashCard['title'];
                $newCheckpointQASet->question = $flashCard['question'];
                $newCheckpointQASet->answer = $flashCard['answer'];
                $newCheckpointQASet->answer_in_place_explanation = $flashCard['answer_in_place_explanation'];
                $newCheckpointQASet->answer_explanation_redirect = $flashCard['answer_explanation_redirect'];
                $newCheckpointQASet->save();
                if (!empty($flashCard['id'])) {
                    $newCheckpointQASet->potential_replacement_of = $flashCard['id'];
                    $newCheckpointQASet->save();
                    $oldQASet = CheckpointQuestionAnswerSet::find($flashCard['id']);
                    $oldQASet->potential_replacement = $newCheckpointQASet->id;
                    $oldQASet->save();
                }
            });
        });
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
            Toast::danger("Checkpoint can't be delete. Pending update detected")->autoDismiss(15);
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
        return view('checkpoint-session.preview', [
            'checkpoint' => $checkpoint,
            'rq' => $this->rq
        ]);
    }

    public function initiate(?Request $request, Checkpoint $checkpoint)
    {
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
                        $QA = $checkpoint->questionAnswerSets()->where('potential_replacement_of', $result->QA_set_id)->first();
                        if ($QA != null) {
                            $result->QA_set_id = $QA->id;
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
