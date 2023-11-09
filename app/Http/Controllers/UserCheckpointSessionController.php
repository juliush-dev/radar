<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CheckpointQuestionAnswerSet;
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
        return view('checkpoint-session.start', [
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

    public function correct(UserCheckpointSession $session, CheckpointQuestionAnswerSet $answer)
    {
        DB::transaction(function () use ($session, $answer) {
            $result = UserCheckpointSessionResult::where('session_id', $session->id)->where('QA_set_id', $answer->id)->firstOr(function () use ($session, $answer) {
                $result = new UserCheckpointSessionResult;
                $result->session_id = $session->id;
                $result->QA_set_id = $answer->id;
                $result->progression = 1;
                return $result;
            });
            $result->answered_correctly = true;
            $result->save();
        });
    }

    public function wrong(UserCheckpointSession $session, CheckpointQuestionAnswerSet $answer)
    {
        DB::transaction(function () use ($session, $answer) {
            $result = UserCheckpointSessionResult::where('session_id', $session->id)->where('QA_set_id', $answer->id)->firstOr(function () use ($session, $answer) {
                $result = new UserCheckpointSessionResult;
                $result->session_id = $session->id;
                $result->QA_set_id = $answer->id;
                $result->progression = 1;
                return $result;
            });
            $result->answered_correctly = false;
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
