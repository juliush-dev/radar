<?php

namespace App\Services;

use App\Models\Field;
use App\Models\Group;
use App\Models\Skill;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class RadarQuery
{

    public function groups()
    {
        return Group::all();
    }


    public function fields()
    {
        return Field::all();
    }

    public function subjects()
    {
        return Subject::all();
    }
}