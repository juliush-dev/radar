<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CheckpointKnowledge;
use App\Models\UserCheckpointSession;
use App\Models\UserCheckpointSessionResult;
use App\Services\RadarQuery;
use Illuminate\Support\Facades\DB;
use ProtoneMedia\Splade\Facades\Toast;

class UserCheckpointSessionController extends Controller
{

    public function __construct(private RadarQuery $rq)
    {
    }

    public function start(UserCheckpointSession $session)
    {
        if ($session->ended) {
            Toast::message('You already completed this session. Here is a brief review of it');
            return redirect(route('sessions.review', $session));
        }
        return view('checkpoint-session.record', [
            'session' => $session
        ]);
    }
    public function stop(Request $request, UserCheckpointSession $session)
    {
        if ($session->ended) {
            Toast::message('You already completed this session. Here is a brief review of it');
            return redirect(route('sessions.review', $session));
        }
        DB::transaction(function () use ($request, $session) {
            $session->ended = true;
            $session->end_countdown = $request->input('countdown', 60);
            $session->save();
        });
        return redirect(route('sessions.review', $session));
    }

    public function review(UserCheckpointSession $session)
    {
        return view('checkpoint-session.review', [
            'session' => $session,
            'rq' => $this->rq
        ]);
    }

    public function cross(UserCheckpointSession $session, CheckpointKnowledge $bridge)
    {
        DB::transaction(function () use ($session, $bridge) {
            $result = UserCheckpointSessionResult::where('session_id', $session->id)->where('knowledge_id', $bridge->id)->firstOr(function () use ($session, $bridge) {
                $result = new UserCheckpointSessionResult;
                $result->session_id = $session->id;
                $result->knowledge_id = $bridge->id;
                $result->progression = 1;
                return $result;
            });
            $result->bridge_crossed = true;
            $result->save();
        });
    }

    public function miss(UserCheckpointSession $session, CheckpointKnowledge $bridge)
    {
        DB::transaction(function () use ($session, $bridge) {
            $result = UserCheckpointSessionResult::where('session_id', $session->id)->where('knowledge_id', $bridge->id)->firstOr(function () use ($session, $bridge) {
                $result = new UserCheckpointSessionResult;
                $result->session_id = $session->id;
                $result->knowledge_id = $bridge->id;
                $result->progression = 1;
                return $result;
            });
            $result->bridge_crossed = false;
            $result->save();
        });
    }

    public function destroy(UserCheckpointSession $session)
    {
        $this->authorize('delete-checkpoint-session', [$session]);
        $checkpoint = null;
        DB::transaction(
            function () use (&$checkpoint, $session) {
                $checkpoint = $session->checkpoint;
                $session->delete();
            }
        );
        Toast::title('Session deleted')->autoDismiss(5);
        $redirectRoute = route('checkpoints.preview', $checkpoint);
        return redirect($redirectRoute);
    }
}
