<?php

namespace App\Http\Controllers;

use App\Models\LearningMaterial;
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
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use ProtoneMedia\Splade\Facades\Toast;
use ProtoneMedia\Splade\FileUploads\HandleSpladeFileUploads;
use ProtoneMedia\Splade\FileUploads\SpladeFile;
use Facades\Spatie\Referer\Referer;

class TopicController extends Controller
{
    public function __construct(private RadarQuery $rq)
    {
    }
    public function show(Topic $topic)
    {
        if (!Gate::allows('see-topic', $topic)) {
            Toast::warning('Access Denied')->autoDismiss(5);
            return redirect(Referer::get());
        }
        return view('topic.show', [
            'topic' => $topic,
            "rq" => $this->rq
        ]);
    }

    public function index(Request $request)
    {
        if ($request->boolean('reset')) {
            return redirect(route('topics.index'));
        }
        $yearFilterValue = $request->query('year');
        $subjectFilterValue = $request->query('subject');
        $skillFilterValue = $request->query('skill');
        $fieldFilterValue = $request->query('field');
        $filterIsSet = array_reduce([$yearFilterValue, $subjectFilterValue, $fieldFilterValue, $skillFilterValue], function ($acc, $value) {
            $acc |= isset($value);
            return $acc;
        }, false);
        return view('topic.index', [
            'topics' => $this->rq->topics(
                [
                    'year' => $yearFilterValue,
                    'subject' => $subjectFilterValue,
                    'field' => $fieldFilterValue,
                    'skill' => $skillFilterValue,
                    'author' => $request->user()?->id
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
        if (!Gate::allows('delete-learning-material', $learningMaterial)) {
            abort(403);
        }
        $topic = $learningMaterial->topic;
        Storage::delete($learningMaterial->path);
        $learningMaterial->delete();
        Toast::title('Learning material sucessfuly removed!')->autoDismiss(5);
        if ($request->query('stay')) {
            return redirect()->route('topics.show', $topic);
        } else {
            return redirect(Referer::get());
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
            'rq' => $this->rq,
            'routeOnSuccess' => 'show',
            'routeOnCancel' => route('topics.index'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $topic = null;
        DB::transaction(function () use ($request, &$topic) {

            $title = $request->input('title');
            $years = $request->input('years', []);
            $subject = $request->input('subject');
            $fields = $request->input('fields', []);
            $skills = $request->input('skills', []);

            $newSubject = $request->input('newSubject');
            $topic = new Topic;
            $topic->title = $title;
            $topic->user_id = $request->user()->id;
            $topic->save();

            collect($years)->each(function ($year) use ($topic) {
                $topicYear = new TopicYear;
                $topicYear->topic_id = $topic->id;
                $topicYear->year = $year;
                $topicYear->save();
            });

            if ($subject) {
                $topic->subject_id = $subject;
                $topic->save();
            } elseif ($newSubject) {
                $subject = new Subject;
                $subject->title = $newSubject['title'];
                $subject->abbreviation = $newSubject['abbreviation'];
                $subject->save();
                collect($newSubject['years'])->each(function ($year) use ($subject) {
                    $subjectYear = new SubjectYear;
                    $subjectYear->subject_id = $subject->id;
                    $subjectYear->year = $year;
                    $subjectYear->save();
                });
                $topic->subject_id = $subject->id;
                $topic->save();
            }
            collect($fields)->each(function ($field) use ($topic) {
                $topicField = new TopicField;
                $topicField->topic_id = $topic->id;
                $topicField->field_id = $field;
                $topicField->save();
            });
            collect($skills)->each(function ($skill) use ($topic) {
                $topicSkill = new TopicSkill;
                $topicSkill->topic_id = $topic->id;
                $topicSkill->skill_id = $skill;
                $topicSkill->save();
            });
            HandleSpladeFileUploads::forRequest($request, 'documents');
            $request->orderedSpladeFileUploads('documents')->each(function (SpladeFile $file) use ($topic, $request) {
                if ($file->doesntExist()) {
                    $this->uploadLm($file->upload, $topic);
                }
            });
        });
        Toast::title('Topic sucessfuly created!')->autoDismiss(5);
        return redirect()->route('topics.show', $topic);
    }

    private function uploadLm($lm, $topic)
    {
        if (empty($lm) || $lm == "") {
            Toast::danger('A problem occured during file upload');
            return;
        }
        $learningMaterial = new LearningMaterial;
        $learningMaterial->topic_id = $topic->id;
        $learningMaterial->user_id = request()->user()->id;
        $learningMaterial->title = $lm->getClientOriginalName();
        $learningMaterial->mime_type = $lm->extension();
        $learningMaterial->alternative = $lm->hashName();
        $learningMaterial->path = $lm->store('public');
        $learningMaterial->save();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Topic $topic)
    {
        $this->authorize('update-topic', [$topic]);
        $redirectRoute = route('topics.index');
        $referer = Referer::get();
        if ($referer == route('dashboard.index', ['tab' => 'topics'])) {
            $redirectRoute = $referer;
        }
        return view(
            'topic.edit',
            [
                'topic' => $topic,
                'rq' => $this->rq,
                'routeOnSuccess' => $redirectRoute,
                'routeOnCancel' => $redirectRoute,
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Topic $topic)
    {
        $this->authorize('update-topic', [$topic]);
        $newTopic = new Topic;
        DB::transaction(function () use ($request, &$newTopic, $topic) {
            $title = $request->input('title');
            $years = $request->input('years', []);
            $subject = $request->input('subject');
            $fields = $request->input('fields', []);
            $skills = $request->input('skills', []);
            $newSubject = $request->input('newSubject');

            $newTopic->title = $title;
            $newTopic->is_update = 1;
            $newTopic->update_topic_id = $topic->id;
            $newTopic->user_id = $request->user()->id;
            $newTopic->save();

            $topic->updating_topic_id = $newTopic->id;
            $topic->save();

            collect($years)->each(function ($year) use ($newTopic) {
                $topicYear = new TopicYear;
                $topicYear->topic_id = $newTopic->id;
                $topicYear->year = $year;
                $topicYear->save();
            });
            if ($subject) {
                $newTopic->subject_id = $subject;
                $newTopic->save();
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
                $newTopic->subject_id = $subject->id;
                $newTopic->save();
            }

            collect($fields)->each(function ($field) use ($newTopic) {
                if (TopicField::where('topic_id', $newTopic->id)->where('field_id', $field)->doesntExist()) {
                    $topicField = new TopicField;
                    $topicField->topic_id = $newTopic->id;
                    $topicField->field_id = $field;
                    $topicField->save();
                }
            });
            collect($skills)->each(function ($skill) use ($newTopic) {
                if (TopicSkill::where('topic_id', $newTopic->id)->where('skill_id', $skill)->doesntExist()) {
                    $topicSkill = new TopicSkill;
                    $topicSkill->topic_id = $newTopic->id;
                    $topicSkill->skill_id = $skill;
                    $topicSkill->save();
                }
            });
            $topic->learningMaterials->each(function ($learningMaterial) use ($newTopic) {
                $learningMaterialCopy = $learningMaterial->replicate();
                $learningMaterialCopy->topic_id = $newTopic->id;
                $learningMaterialCopy->save();
            });
        });
        Toast::title('Topic sucessfuly updated!')->autoDismiss(5);
        return redirect()->route('topics.show', $newTopic);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Topic $topic)
    {
        $this->authorize('delete-topic', [$topic]);
        if ($topic->topicUpdating != null) {
            Toast::danger("Topic can't be delete. Pending update detected")->autoDismiss(15);
            return back();
        }
        DB::transaction(
            function () use ($topic) {
                $topic->learningMaterials->each(function ($lm) {
                    if (LearningMaterial::where('alternative', $lm->alternative)->count() == 1) {
                        Storage::delete($lm->path);
                    }
                });
                $topic->delete();
            }
        );
        Toast::title('Topic deleted')->autoDismiss(5);

        $redirectRoute = route('topics.index');
        if (Referer::get() == $currentRoute = route('dashboard.index', ['tab' => 'topics'])) {
            $redirectRoute = $currentRoute;
        }
        return redirect($redirectRoute);
    }

    public function unpublishTopic(Topic $topic)
    {
        $this->authorize('use-dashboard');
        $topic->is_public = 0;
        $topic->save();
        return redirect(Referer::get());
    }

    public function publishTopic(Topic $topic)
    {
        $this->authorize('use-dashboard');
        $topic->is_public = 1;
        $topic->save();
        return redirect(Referer::get());
    }

    public function unpublishLearningMaterial(LearningMaterial $learningMaterial)
    {
        $this->authorize('use-dashboard');
        $learningMaterial->is_public = 0;
        $learningMaterial->save();
        return redirect(Referer::get());
    }

    public function publishLearningMaterial(LearningMaterial $learningMaterial)
    {
        $this->authorize('use-dashboard');
        $learningMaterial->is_public = 1;
        $learningMaterial->save();
        return redirect(Referer::get());
    }

    public function applyUpdate(Topic $topic)
    {
        $this->authorize('use-dashboard');
        DB::transaction(
            function () use ($topic) {
                $oldTopic = $topic->topicToUpdate;
                if ($oldTopic->topicToUpdate) {
                    $topic->update_topic_id = $oldTopic->topicToUpdate->id;
                    $oldTopic->topicToUpdate->updating_topic_id = $topic->id;
                    $oldTopic->topicToUpdate->save();
                } else {
                    $topic->is_update = 0;
                }
                $oldTopic->learningMaterials->each(function ($learningMaterial) use ($topic) {
                    if (LearningMaterial::where('alternative', $learningMaterial->alternative)->where('topic_id', $topic->id)->first() == null) {
                        $learningMaterialCopy = $learningMaterial->replicate();
                        $learningMaterialCopy->topic_id = $topic->id;
                        $learningMaterialCopy->save();
                        LearningMaterial::where('id', $learningMaterial->id)->where('topic_id', $learningMaterial->topic_id)->delete();
                    }
                });

                $oldTopic->delete();
                $topic->is_public = true;
                $topic->save();
            }
        );
        Toast::title('Update applied')->autoDismiss(8);
        return redirect(Referer::get());
    }

    public function editSubject(Subject $subject)
    {
        return view('topic.subject-edit', [
            'subject' => $subject,
            'years' => $this->rq->years()
        ]);
    }

    public function updateSubject(Request $request, Subject $subject)
    {
        $this->authorize('use-dashboard');
        DB::transaction(function () use ($request, $subject) {
            $title = $request->input('title');
            $abbreviation = $request->input('abbreviation');
            $years = $request->input('years');
            if ($title != $subject->title) {
                $subject->title = $title;
                $subject->save();
            }
            if ($abbreviation != $subject->abbreviation) {
                $subject->abbreviation = $abbreviation;
                $subject->save();
            }
            if (is_array($years) && count($years) > 0) {
                $subjectYearsDeleted = $subject->years()->pluck('year')->diff($years);
                $subjectYearsDeleted->each(function ($year) use ($subject) {
                    SubjectYear::where('subject_id', $subject->id)->where('year', $year)->delete();
                });
                $yearsAdded = collect($years)->diff($subject->years()->pluck('year'));
                $yearsAdded->each(function ($year) use ($subject) {
                    $subjectYear = new SubjectYear;
                    $subjectYear->subject_id = $subject->id;
                    $subjectYear->year = $year;
                    $subjectYear->save();
                });
            }
        });
        // collect($request->toArray())->toJson();
        Toast::title('Subject sucessfuly updated!')->autoDismiss(5);
        return redirect(Referer::get());
    }

    public function destroySubject(Subject $subject)
    {
        $this->authorize('use-dashboard');
        DB::transaction(function () use ($subject) {
            if ($subject->topics()->count() > 0) {
                Toast::warning("This Subject can't be delete. Some topics reference it.")->autoDismiss(5);
            } else {
                $subject->delete();
            }
        });
        return redirect(Referer::get());
    }
}
