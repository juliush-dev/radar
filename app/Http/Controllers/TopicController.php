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
use App\Models\UserTopicAssessment;
use App\Services\EnumTransformer;
use App\Services\QueryResultTransformer;
use App\Services\RadarQuery;
use App\Tables\Topics;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use ProtoneMedia\Splade\Facades\Toast;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class TopicController extends Controller
{
    public function __construct(private RadarQuery $rq)
    {
    }
    public function show(Topic $topic)
    {
        return view('topic.show', ['topic' => $topic]);
    }

    public function index(Request $request)
    {
        $yearFilerValue = $request->query('year');
        $subjectFilerValue = $request->query('subject');
        $skillFilerValue = $request->query('skill');
        $filterIsSet = array_reduce([$yearFilerValue, $subjectFilerValue, $subjectFilerValue], function ($acc, $value) {
            $acc |= isset($value);
            return $acc;
        }, false);
        return view('topic.index', [
            'topics' => $this->rq->topics(
                [
                    'year' => $yearFilerValue,
                    'subject' => $subjectFilerValue,
                    'skill' => $skillFilerValue,
                ]
            ),
            'rq' => $this->rq,
            'filterIsSet' => $filterIsSet
        ]);
    }
    public function downloadLearningMaterial(Request $r, LearningMaterial $learningMaterial)
    {
        return Storage::download($learningMaterial->path, $learningMaterial->title);
    }

    public function removeLearningMaterial(Request $request, LearningMaterial $learningMaterial)
    {
        $topic = $learningMaterial->topic;
        $learningMaterial->delete();
        Toast::title('Learning material sucessfuly removed!')->autoDismiss(8);
        if ($request->query('stay')) {
            return redirect()->route('topics.show', $topic);
        } else {
            return redirect()->route('topics.index');
        }
    }

    public function uploadLearningMaterial(Request $request, Topic $topic)
    {
        $lms = $request->file('newLearningMaterials');
        if (is_array($lms) && count($lms) > 0) {
            foreach ($lms as $lm) {
                $this->uploadLm($lm, $topic);
            }
        } elseif ($lms != null) {
            $this->uploadLm($lms, $topic);
        }
        Toast::title('New learning materials sucessfuly uploaded!')->autoDismiss(8);
        if ($request->query('stay')) {
            return redirect()->route('topics.show', $topic);
        } else {
            return redirect()->route('topics.index');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('topic.create', [
            'rq' => $this->rq
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        DB::transaction(function () use ($request) {

            $title = $request->input('title');
            $years = $request->input('years', []);
            $subject = $request->input('subject');
            $fields = $request->input('fields', []);
            $skills = $request->input('skills', []);

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
                        if (!is_array($fields)) {
                            $fields = [];
                        }
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

                if (is_array($newSkills) && count($newSkills) > 0) {
                    foreach ($newSkills as $newSkill) {
                        $skill = new Skill;
                        $skill->title = $newSkill['title'];
                        if (isset($newSkill['group'])) {
                            $skill->group_id = $newSkill['group'];
                        } elseif (isset($newSkill['newGroup'])) {
                            $group = new Group;
                            $group->title = $newSkill['newGroup'];
                            $group->save();
                            $skill->group_id = $group->id;
                        }
                        $skill->save();
                        if (!is_array($skills)) {
                            $skills = [];
                        } else {
                            array_push($skills, $skill->id);
                        }
                        $skillFields = $newSkill['fields'] ?? [];
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

                if (is_array($skills) && count($skills) > 0) {
                    foreach ($skills as $skill) {
                        $topicSkill = new TopicSkill;
                        $topicSkill->topic_id = $topic->id;
                        $topicSkill->skill_id = $skill;
                        $topicSkill->save();
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
        Toast::title('Skill sucessfuly saved!')->autoDismiss(8);
        return redirect()->route('topics.index');
    }

    private function uploadLm($lm, $topic)
    {
        if (empty($lm) || $lm == "") {
            Toast::danger('A problem occured during file upload');
            return;
        }
        $learningMaterial = new LearningMaterial;
        $learningMaterial->topic_id = $topic->id;
        $learningMaterial->title = $lm->getClientOriginalName();
        $learningMaterial->mime_type = $lm->extension();
        $learningMaterial->alternative = $lm->hashName();
        $learningMaterial->approval_status = ApprovalStatus::Pending->value;
        $learningMaterial->path = $lm->store('public');
        $learningMaterial->save();
    }
    public function assess(Request $request, Topic $topic)
    {
        DB::transaction(function () use ($request, $topic) {
            $assessment = new UserTopicAssessment;
            $assessment->user_id = auth()->user()->id;
            $assessment->topic_id = $topic->id;
            $actualAssessment = UserTopicAssessment::where('user_id', $assessment->user_id)->where('topic_id', $assessment->topic_id)->first();
            if ($actualAssessment) {
                UserTopicAssessment::where('user_id', $assessment->user_id)
                    ->where('topic_id', $assessment->topic_id)
                    ->update(['assessment' => $request->input('assessment')]);
            } else {
                $assessment->assessment = $request->input('assessment');
                $assessment->save();
            }
        });
        Toast::title('New assessment saved')->autoDismiss(8);
        if ($request->query('stay')) {
            return redirect()->route('topics.show', $topic);
        } else {
            return redirect()->route('topics.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Topic $topic)
    {
        return view(
            'topic.edit',
            [
                'topic' => $topic,
                'rq' => $this->rq
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Topic $topic)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Topic $topic)
    {
        $topic->delete();
        Toast::title('Topic deleted')->autoDismiss(8);
        return redirect()->route('topics.index');
    }
}
