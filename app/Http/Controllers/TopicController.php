<?php

namespace App\Http\Controllers;

use App\Enums\ApprovalStatus;
use App\Models\Field;
use App\Models\FieldYear;
use App\Models\Group;
use App\Models\LearningMaterial;
use App\Models\Skill;
use App\Models\SkillField;
use App\Models\SkillYear;
use App\Models\Subject;
use App\Models\SubjectYear;
use App\Models\Topic;
use App\Models\TopicField;
use App\Models\TopicSkill;
use App\Models\TopicYear;
use App\Services\EnumTransformer;
use App\Services\QueryResultTransformer;
use App\Services\RadarQuery;
use App\Tables\Topics;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use ProtoneMedia\Splade\Facades\Toast;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class TopicController extends Controller
{
    public function __construct(private RadarQuery $cq)
    {
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $topics = new Topics($this->cq);
        return view('topic.index', [
            'topics' => $topics->for(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(EnumTransformer $ent, QueryResultTransformer $qrt)
    {
        return view('topic.create', [
            'ent' => $ent,
            'qrt' => $qrt
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        DB::transaction(function () use ($request) {

            $title = $request->input('title');
            $years = $request->input('years');
            $subject = $request->input('subject');
            $fields = $request->input('fields');
            $skills = $request->input('skills');

            $newSubject = $request->input('newSubject');
            $newFields = $request->input('newFields');
            $newSkills = $request->input('newSkills');

            if ($title) {
                $topic = new Topic;
                $topic->title = $title;
                $topic->save();

                if (is_array($years) && count($years) > 0) {
                    foreach ($years as $year) {
                        $topicYear = new TopicYear;
                        $topicYear->topic_id = $topic->id;
                        $topicYear->year = $year;
                        $topicYear->save();
                    }
                }

                if ($subject) {
                    $topic->subject_id = $subject;
                    $topic->save();
                } elseif ($newSubject) {
                    $subject = new Subject;
                    $subject->title = $newSubject['title'];
                    $subject->abbreviation = $newSubject['abbreviation'];
                    $subject->save();
                    if (is_array($subject['years']) && count($subject['years']) > 0) {
                        foreach ($subject['years'] as $year) {
                            $subjectYear = new SubjectYear;
                            $subjectYear->subject_id = $subject->id;
                            $subjectYear->year = $year;
                            $subjectYear->save();
                        }
                    }
                    $topic->subject_id = $subject->id;
                    $topic->save();
                }

                if (is_array($fields) && count($fields) > 0) {
                    foreach ($fields as $field) {
                        $topicField = new TopicField;
                        $topicField->topic_id = $topic->id;
                        $topicField->field_id = $field;
                        $topicField->save();
                    }
                }

                if (is_array($newFields) && count($newFields) > 0) {
                    foreach ($newFields as $newField) {
                        $field = new Field;
                        $field->title = $newField['title'];
                        $field->save();
                        array_push($fields, $field->id);
                        $years = $newField['years'];
                        if (is_array($years) && count($years) > 0) {
                            foreach ($years as $year) {
                                $fieldYear = new FieldYear;
                                $fieldYear->field_id = $field->id;
                                $fieldYear->year = $year;
                                $fieldYear->save();
                            }
                        }
                        $topicField = new TopicField;
                        $topicField->topic_id = $topic->id;
                        $topicField->field_id = $field->id;
                        $topicField->save();
                    }
                }

                if (is_array($skills) && count($skills) > 0) {
                    foreach ($skills as $skill) {
                        $topicSkill = new TopicSkill;
                        $topicSkill->topic_id = $topic->id;
                        $topicSkill->skill_id = $skill;
                        $topicSkill->save();
                    }
                }

                if (is_array($newSkills) && count($newSkills) > 0) {
                    foreach ($newSkills as $newSkill) {
                        $skill = new Skill;
                        $skill->title = $newSkill['title'];
                        if ($newSkill['group']) {
                            $skill->group_id = $newSkill['group'];
                        } elseif ($newSkill['newGroup']) {
                            $group = new Group;
                            $group->title = $newSkill['newGroup'];
                            $group->save();
                            $skill->group_id = $group->id;
                        }
                        $skill->save();
                        $skillFields = $newSkill['fields'];
                        if (is_array($skillFields) && count($skillFields) > 0) {
                            array_push($fields, ...$skillFields);
                        }
                        if (is_array($fields) && count($fields) > 0) {
                            foreach ($fields as $field) {
                                $skillField = new SkillField;
                                $skillField->skill_id = $skill->id;
                                $skillField->field_id = $field;
                                $skillField->save();
                            }
                        }
                        if (is_array($newSkill['years']) && count($newSkill['years']) > 0) {
                            foreach ($newSkill['years'] as $year) {
                                $skillYear = new SkillYear;
                                $skillYear->skill_id = $skill->id;
                                $skillYear->year = $year;
                                $skillYear->save();
                            }
                        }
                    }
                }
                $lms = $request->file('documents');
                if (is_array($lms) && count($lms) > 0) {
                    foreach ($lms as $lm) {
                        $this->uploadLm($lm, $topic);
                    }
                } elseif ($lms != null) {
                    $this->uploadLm($lms, $topic);
                }
            }
        });
        Toast::title('Skill sucessfuly saved!');
        return redirect()->route('topics.index');
    }

    private function uploadLm($lm, $topic)
    {
        $learningMaterial = new LearningMaterial;
        $learningMaterial->topic_id = $topic->id;
        $learningMaterial->title = $lm->getClientOriginalName();
        $learningMaterial->mime_type = $lm->extension();
        $learningMaterial->alternative = $lm->hashName();
        $learningMaterial->approval_status = ApprovalStatus::Pending->value;
        $learningMaterial->path = $lm->store('public');
        $learningMaterial->save();
    }

    /**
     * Display the specified resource.
     */
    public function show(Skill $skill)
    {
        return view(
            'skill.show',
            [
                'skill' => $skill,
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Skill $skill)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Skill $skill)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Skill $skill)
    {
        //
    }
}
