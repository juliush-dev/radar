<?php

namespace App\Http\Controllers;

use App\Models\Field;
use App\Models\FieldYear;
use App\Models\Group;
use App\Models\Skill;
use App\Models\SkillField;
use App\Models\SkillYear;
use App\Services\RadarQuery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use ProtoneMedia\Splade\Facades\Toast;

class SkillController extends Controller
{
    public function __construct(private RadarQuery $rq)
    {
    }
    public function show(Skill $skill)
    {
        return view('skill.show', ['skill' => $skill]);
    }

    public function index(Request $request)
    {
        $yearFilterValue = $request->query('year');
        $fieldFilterValue = $request->query('field');
        $filterIsSet = array_reduce([$yearFilterValue, $fieldFilterValue], function ($acc, $value) {
            $acc |= isset($value);
            return $acc;
        }, false);
        return view('skill.index', [
            'skills' => $this->rq->skills(
                [
                    'year' => $yearFilterValue,
                    'field' => $fieldFilterValue,
                ]
            ),
            'rq' => $this->rq,
            'filterIsSet' => $filterIsSet
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('skill.create', [
            'rq' => $this->rq
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $skill = null;
        DB::transaction(function () use ($request, &$skill) {
            $title = $request->input('title');
            $group = $request->input('group');
            $newGroup = $request->input('newGroup');
            $years = $request->input('years');
            $fields = $request->input('fields');
            $skill = new Skill;
            $skill->title = $title;
            if (isset($group)) {
                $skill->group_id = $group;
            } elseif (isset($newGroup)) {
                $group = new Group;
                $group->title = $newGroup;
                $group->save();
                $skill->group_id = $group->id;
            }
            $skill->save();

            if (is_array($fields) && count($fields) > 0) {
                collect($fields)->each(function ($field) use ($skill) {
                    if (SkillField::where('skill_id', $skill->id)->where('field_id', $field)->doesntExist()) {
                        $skillField = new SkillField;
                        $skillField->skill_id = $skill->id;
                        $skillField->field_id = $field;
                        $skillField->save();
                    }
                });
            }

            if (is_array($years) && count($years) > 0) {
                collect($years)->each(function ($year) use ($skill) {
                    $skillYear = new SkillYear;
                    $skillYear->skill_id = $skill->id;
                    $skillYear->year = $year;
                    $skillYear->save();
                });
            }
        });
        Toast::title('skill sucessfuly created!')->autoDismiss(5);
        return redirect()->route('skills.show', $skill);
    }


    public function edit(Skill $skill)
    {
        return view(
            'skill.edit',
            [
                'skill' => $skill,
                'rq' => $this->rq,
            ]
        );
    }

    public function update(Request $request, Skill $skill)
    {
        DB::transaction(function () use ($request, $skill) {
            $title = $request->input('title');
            $group = $request->input('group');
            $newGroup = $request->input('newGroup');
            $years = $request->input('years', []);
            $fields = $request->input('fields', []);

            if ($title) {
                if ($skill->title != $title) {
                    $skill->title = $title;
                    $skill->save();
                }

                if (is_array($years) && count($years) > 0) {
                    $skillYearsDeleted = $skill->years()->pluck('year')->diff($years);
                    $skillYearsDeleted->each(function ($year) use ($skill) {
                        SkillYear::where('skill_id', $skill->id)->where('year', $year)->delete();
                    });
                    $yearsAdded = collect($years)->diff($skill->years()->pluck('year'));
                    $yearsAdded->each(function ($year) use ($skill) {
                        $skillYear = new SkillYear;
                        $skillYear->skill_id = $skill->id;
                        $skillYear->year = $year;
                        $skillYear->save();
                    });
                }
                if ($group) {
                    if ($group != $skill->group) {
                        $skill->group_id = $group;
                        $skill->save();
                    }
                } elseif ($newGroup) {
                    $group = new group;
                    $group->title = $newGroup;
                    $group->save();
                    $skill->group_id = $group->id;
                    $skill->save();
                }

                if (is_array($fields) && count($fields) > 0) {
                    $skillFieldsDeleted = $skill->fields()->pluck('field_id')->diff($fields);
                    $skillFieldsDeleted->each(function ($field_id) use ($skill) {
                        SkillField::where('skill_id', $skill->id)->where('field_id', $field_id)->delete();
                    });
                    $fieldsAdded = collect($fields)->diff($skill->fields()->pluck('field_id'));
                    $fieldsAdded->each(function ($field) use ($skill) {
                        if (SkillField::where('skill_id', $skill->id)->where('field_id', $field)->doesntExist()) {
                            $skillField = new SkillField;
                            $skillField->skill_id = $skill->id;
                            $skillField->field_id = $field;
                            $skillField->save();
                        }
                    });
                } else {
                    SkillField::where('skill_id', $skill->id)->delete();
                }
            }
        });
        Toast::title('skill sucessfuly updated!')->autoDismiss(5);
        return redirect()->route('skills.show', $skill);
    }

    public function destroy(Skill $skill)
    {
        $skill->delete();
        Toast::title('skill deleted')->autoDismiss(5);
        return redirect()->route('skills.index');
    }
}
