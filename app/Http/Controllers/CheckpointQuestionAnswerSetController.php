<?php

namespace App\Http\Controllers;

use App\Models\CheckpointQuestionAnswerSet;
use App\Services\RadarQuery;
use Illuminate\Http\Request;

class CheckpointQuestionAnswerSetController extends Controller
{
    public function __construct(private RadarQuery $rq)
    {
    }

    public function show(Request $request, CheckpointQuestionAnswerSet $qas)
    {
        return view('question-answer-set.show', [
            'qas' => $qas,
            'context' => $request->input('context')
        ]);
    }
}
