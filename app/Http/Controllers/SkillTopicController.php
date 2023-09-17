<?php

namespace App\Http\Controllers;

use App\Enums\ModificationRequestState;
use App\Enums\ModificationType;
use App\Enums\Visibility;
use App\Http\Requests\StoreSkillTopicRequest;
use App\Http\Requests\UpdateSkillTopicRequest;
use App\Models\Skill;
use App\Models\SkillTopic;
use App\Models\Topic;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use ProtoneMedia\Splade\Facades\Toast;

class SkillTopicController extends Controller
{

    public function show(SkillTopic $skillTopic)
    {
        return view('skill-topic.show', [
            'skill' => $skillTopic->skill,
            'topic' => $skillTopic->topic,
        ]);
    }
}
