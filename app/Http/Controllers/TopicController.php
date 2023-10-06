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
use App\Services\RadarQuery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use ProtoneMedia\Splade\Facades\Toast;

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
        $yearFilterValue = $request->query('year');
        $subjectFilterValue = $request->query('subject');
        $filterIsSet = array_reduce([$yearFilterValue, $subjectFilterValue], function ($acc, $value) {
            $acc |= isset($value);
            return $acc;
        }, false);
        return view('topic.index', [
            'topics' => $this->rq->topics(
                [
                    'year' => $yearFilterValue,
                    'subject' => $subjectFilterValue,
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
        Storage::delete($learningMaterial->path);
        $learningMaterial->delete();
        Toast::title('Learning material sucessfuly removed!')->autoDismiss(5);
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
        Toast::title('New learning materials sucessfuly uploaded!')->autoDismiss(5);
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
        $topic = null;
        DB::transaction(function () use ($request) {

            $title = $request->input('title');
            $years = $request->input('years', []);
            $subject = $request->input('subject');
            $fields = $request->input('fields', []);
            $skills = $request->input('skills', []);

            $newSubject = $request->input('newSubject');
            if ($title) {
                $topic = new Topic;
                $topic->title = $title;
                $topic->save();

                if (is_array($years) && count($years) > 0) {
                    collect($years)->each(function ($year) use ($topic) {
                        $topicYear = new TopicYear;
                        $topicYear->topic_id = $topic->id;
                        $topicYear->year = $year;
                        $topicYear->save();
                    });
                }

                if ($subject) {
                    $topic->subject_id = $subject;
                    $topic->save();
                } elseif ($newSubject) {
                    $subject = new Subject;
                    $subject->title = $newSubject['title'];
                    $subject->abbreviation = $newSubject['abbreviation'];
                    $subject->save();
                    if (is_array($newSubject['years']) && count($newSubject['years']) > 0) {
                        collect($newSubject['years'])->each(function ($year) use ($subject) {
                            $subjectYear = new SubjectYear;
                            $subjectYear->subject_id = $subject->id;
                            $subjectYear->year = $year;
                            $subjectYear->save();
                        });
                    }
                    $topic->subject_id = $subject->id;
                    $topic->save();
                }
                if (is_array($fields) && count($fields) > 0) {
                    $fieldsAdded = collect($fields);
                    $fieldsAdded->each(function ($field) use ($topic) {
                        $topicField = new TopicField;
                        $topicField->topic_id = $topic->id;
                        $topicField->field_id = $field;
                        $topicField->save();
                    });
                }
                if (is_array($skills) && count($skills) > 0) {
                    $skillsAdded = collect($skills);
                    $skillsAdded->each(function ($skill) use ($topic) {
                        $topicSkill = new TopicSkill;
                        $topicSkill->topic_id = $topic->id;
                        $topicSkill->skill_id = $skill;
                        $topicSkill->save();
                    });
                }
                $lms = $request->file('documents');
                if (is_array($lms) && count($lms) > 0) {
                    collect($lms)->each(function ($lm) use ($topic) {
                        $this->uploadLm($lm, $topic);
                    });
                } elseif ($lms != null) {
                    $this->uploadLm($lms, $topic);
                }
            }
        });
        Toast::title('Topic sucessfuly created!')->autoDismiss(5);
        return redirect()->route('topics.show', $topic);
    }

    private function updateLm($lm, $topic)
    {
        if (!empty($lm) || $lm != "") {
            if (LearningMaterial::where('alternative', $lm->getClientOriginalName())->doesntExist()) {
                $this->uploadLm($lm, $topic);
            }
        }
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
        Toast::title('New assessment saved')->autoDismiss(5);
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
                'rq' => $this->rq,
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Topic $topic)
    {
        DB::transaction(function () use ($request, $topic) {
            $title = $request->input('title');
            $years = $request->input('years', []);
            $subject = $request->input('subject');
            $fields = $request->input('fields', []);
            $skills = $request->input('skills', []);
            $newSubject = $request->input('newSubject');

            if ($title) {
                if ($topic->title != $title) {
                    $topic->title = $title;
                    $topic->save();
                }

                if (is_array($years) && count($years) > 0) {
                    $topicYearsDeleted = $topic->years()->pluck('year')->diff($years);
                    $topicYearsDeleted->each(function ($year) use ($topic) {
                        TopicYear::where('topic_id', $topic->id)->where('year', $year)->delete();
                    });
                    $yearsAdded = collect($years)->diff($topic->years()->pluck('year'));
                    $yearsAdded->each(function ($year) use ($topic) {
                        $topicYear = new TopicYear;
                        $topicYear->topic_id = $topic->id;
                        $topicYear->year = $year;
                        $topicYear->save();
                    });
                }
                if ($subject) {
                    if ($subject != $topic->subject) {
                        $topic->subject_id = $subject;
                        $topic->save();
                    }
                } elseif ($newSubject) {
                    $subject = new Subject;
                    $subject->title = $newSubject['title'];
                    $subject->abbreviation = $newSubject['abbreviation'];
                    $subject->save();
                    if (is_array($subject['years']) && count($subject['years']) > 0) {
                        collect($subject['years'])->each(function ($year) use ($subject) {
                            $subjectYear = new SubjectYear;
                            $subjectYear->subject_id = $subject->id;
                            $subjectYear->year = $year;
                            $subjectYear->save();
                        });
                    }
                    $topic->subject_id = $subject->id;
                    $topic->save();
                }

                if (is_array($fields) && count($fields) > 0) {
                    $topicFieldsDeleted = $topic->fields()->pluck('field_id')->diff($fields);
                    $topicFieldsDeleted->each(function ($field_id) use ($topic) {
                        TopicField::where('topic_id', $topic->id)->where('field_id', $field_id)->delete();
                    });
                    $fieldsAdded = collect($fields)->diff($topic->fields()->pluck('field_id'));
                    $fieldsAdded->each(function ($field) use ($topic) {
                        if (TopicField::where('topic_id', $topic->id)->where('field_id', $field)->doesntExist()) {
                            $topicField = new TopicField;
                            $topicField->topic_id = $topic->id;
                            $topicField->field_id = $field;
                            $topicField->save();
                        }
                    });
                } else {
                    TopicField::where('topic_id', $topic->id)->delete();
                }


                if (is_array($skills) && count($skills) > 0) {
                    $topicSkillsDeleted = $topic->skills()->pluck('skill_id')->diff($skills);
                    $topicSkillsDeleted->each(function ($skill_id) use ($topic) {
                        TopicSkill::where('topic_id', $topic->id)->where('skill_id', $skill_id)->delete();
                    });
                    $skillsAdded = collect($skills)->diff($topic->skills()->pluck('skill_id'));
                    $skillsAdded->each(function ($skill) use ($topic) {
                        if (TopicSkill::where('topic_id', $topic->id)->where('skill_id', $skill)->doesntExist()) {
                            $topicSkill = new TopicSkill;
                            $topicSkill->topic_id = $topic->id;
                            $topicSkill->skill_id = $skill;
                            $topicSkill->save();
                        }
                    });
                } else {
                    TopicSkill::where('topic_id', $topic->id)->delete();
                }

                $lms = $request->file('documents');
                if (is_array($lms) && count($lms) > 0) {
                    foreach ($lms as $lm) {
                        $this->updateLm($lm, $topic);
                    }
                } elseif ($lms != null) {
                    $this->updateLm($lms, $topic);
                }
            }
        });
        Toast::title('Topic sucessfuly updated!')->autoDismiss(5);
        return redirect()->route('topics.show', $topic);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Topic $topic)
    {
        $topic->learningMaterials->each(function ($lm) {
            Storage::delete($lm->path);
        });
        $topic->delete();
        Toast::title('Topic deleted')->autoDismiss(5);
        return redirect()->route('topics.index');
    }
}
