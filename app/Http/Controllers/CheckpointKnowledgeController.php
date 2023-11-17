<?php

namespace App\Http\Controllers;

use App\Models\CheckpointKnowledge;
use App\Services\RadarQuery;
use Illuminate\Http\Request;

class CheckpointKnowledgeController extends Controller
{
    public function __construct(private RadarQuery $rq)
    {
    }

    public function show(Request $request, CheckpointKnowledge $knowledge)
    {
        return view('knowledge.show', [
            'knowledge' => $knowledge,
            'context' => $request->input('context')
        ]);
    }
}
