<?php

namespace App\Http\Controllers;

use App\Models\Field;
use App\Models\FieldYear;
use App\Models\Group;
use App\Models\Skill;
use App\Models\Skill\Type;
use App\Models\SkillField;
use App\Models\SkillYear;
use App\Models\UserSkillAssessment;
use App\Services\RadarQuery;
use Facades\Spatie\Referer\Referer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use ProtoneMedia\Splade\Facades\Toast;

class SkillController extends Controller
{
    public function __construct(private RadarQuery $rq)
    {
    }
    public function show(Skill $skill)
    {
        return view('skill.show', [
            'skill' => $skill,
            'userAssessment' => $this->rq->userSkillAssessment($skill)
        ]);
    }

    public function index(Request $request)
    {
        if ($request->boolean('reset')) {
            return redirect(route('skills.index'));
        }
        $typeFilterValue = $request->query('type');
        $groupFilterValue = $request->query('group');
        $yearFilterValue = $request->query('year');
        $fieldFilterValue = $request->query('field');
        $assessmentFilterValue = $request->query('assessment');
        $filterIsSet = array_reduce([$typeFilterValue, $groupFilterValue, $yearFilterValue, $fieldFilterValue, $assessmentFilterValue], function ($acc, $value) {
            $acc |= isset($value);
            return $acc;
        }, false);
        return view('skill.index', [
            'skills' => $this->rq->skills(
                [
                    'type' => $typeFilterValue,
                    'group' => $groupFilterValue,
                    'year' => $yearFilterValue,
                    'field' => $fieldFilterValue,
                    'assessment' => $assessmentFilterValue,
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
        $this->authorize('create-skill');
        return view('skill.create', [
            'rq' => $this->rq
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create-field');
        $skill = null;
        DB::transaction(function () use ($request, &$skill) {
            $title = $request->input('title');
            $group = $request->input('group');
            $type = $request->input('type');
            $newGroup = $request->input('newGroup');
            $newType = $request->input('newType');
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

            if (isset($type)) {
                $skill->type_id = $type;
            } elseif (isset($newType)) {
                $type = new Type;
                $type->title = $newType;
                $type->save();
                $skill->type_id = $type->id;
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
        $this->authorize('update-field');
        return view(
            'skill.edit',
            [
                'skill' => $skill,
                'rq' => $this->rq,
            ]
        );
    }

    public function editGroup(Group $group)
    {
        $this->authorize('update-group');
        return view(
            'skill.group-edit',
            [
                'group' => $group,
            ]
        );
    }
    public function updateGroup(Request $request, Group $group)
    {
        $this->authorize('update-group');
        $title = $request->input('title');
        if ($title != $group->title) {
            $group->title = $title;
            $group->save();
        }
        Toast::title('Group sucessfuly updated!')->autoDismiss(5);
        return redirect(Referer::get());
    }

    public function editType(Type $type)
    {
        $this->authorize('update-type');
        return view(
            'skill.type-edit',
            [
                'type' => $type,
            ]
        );
    }
    public function updateType(Request $request, Type $type)
    {
        $this->authorize('update-type');
        $title = $request->input('title');
        if ($title != $type->title) {
            $type->title = $title;
            $type->save();
        }
        Toast::title('Type sucessfuly updated!')->autoDismiss(5);
        return redirect(Referer::get());
    }



    public function update(Request $request, Skill $skill)
    {
        $this->authorize('update-field');
        DB::transaction(function () use ($request, $skill) {
            $title = $request->input('title');
            $group = $request->input('group');
            $newGroup = $request->input('newGroup');
            $type = $request->input('type');
            $newType = $request->input('newType');
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

                if ($type) {
                    if ($type != $skill->type) {
                        $skill->type_id = $type;
                        $skill->save();
                    }
                } elseif ($newType) {
                    $type = new Type;
                    $type->title = $newType;
                    $type->save();
                    $skill->type_id = $type->id;
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
        $this->authorize('delete-field');
        $skill->delete();
        Toast::title('skill deleted')->autoDismiss(5);
        return redirect()->route('skills.index');
    }

    public function assess(Request $request, Skill $skill)
    {
        if (!Gate::allows('assess-skill', $skill)) {
            Toast::warning('Action Denied')->autoDismiss(5);
            return redirect(Referer::get());
        }
        DB::transaction(function () use ($request, $skill) {
            $newAssessment = new UserSkillAssessment;
            $newAssessment->user_id = auth()->user()->id;
            $newAssessment->skill_id = $skill->id;
            $userPreviousAssessmentQuery = UserSkillAssessment::where('user_id', $newAssessment->user_id)->where('skill_id', $newAssessment->skill_id);
            $exists = $userPreviousAssessmentQuery->first() != null;
            $newValue = $request->input('assessment');
            $newValueValid = $newValue > 0 && $newValue <= 5;
            if ($exists && $newValueValid) {
                $userPreviousAssessmentQuery->update(['assessment' => $newValue]);
            } elseif (!$exists && $newValueValid) {
                $newAssessment->assessment = $newValue;
                $newAssessment->save();
            } else {
                $userPreviousAssessmentQuery->delete();
            }
        });
        Toast::title('assessment updated')->autoDismiss(5);
        return redirect(Referer::get());
    }
}
