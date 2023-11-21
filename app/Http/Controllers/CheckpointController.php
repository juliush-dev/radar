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
use Illuminate\Support\Facades\Gate;
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
            $source = trim($request->input('source', ''));

            if (!empty($title)) {
                $newCheckpoint = new Checkpoint;
                $newCheckpoint->title = $title;
                $newCheckpoint->user_id = $request->user()->id;
                $newCheckpoint->topic_id =  $topic->id;
                $newCheckpoint->source =  $source;
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
            'source' => $checkpoint->source,
            'topic' => $checkpoint->topic,
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
        if (!Gate::allows('preview-checkpoint', $checkpoint)) {
            Toast::warning('Access Denied')->autoDismiss(5);
            return redirect(Referer::get());
        }
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
                $checkpoint->applyUpdate();
            }
        );
        Toast::title('Update applied')->autoDismiss(8);
        return redirect(Referer::get());
    }
}
