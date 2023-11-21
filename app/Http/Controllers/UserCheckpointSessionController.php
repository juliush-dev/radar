<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserCheckpointSession;
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
        return redirect(route('checkpoints.preview', $session->checkpoint));
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
