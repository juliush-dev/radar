<?php

namespace App\Http\Controllers;

use App\Enums\ApprovalStatus;
use App\Models\Field;
use App\Models\FieldYear;
use App\Models\Group;
use App\Models\LearningMaterial;
use App\Models\Skill;
use App\Models\SkillField;
use App\Models\SkillGroup;
use App\Models\SkillYear;
use App\Models\Subject;
use App\Models\SubjectYear;
use App\Models\Topic;
use App\Models\TopicField;
use App\Models\TopicYear;
use App\Services\EnumTransformer;
use App\Services\QueryResultTransformer;
use App\Services\RadarQuery;
use App\Tables\Skills;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use ProtoneMedia\Splade\Facades\Toast;

class SkillController extends Controller
{
    public function __construct(private RadarQuery $cq)
    {
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $skillsIndex = new Skills($this->cq);
        return view('skill.index', [
            'publicSkills' => $skillsIndex->for(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(EnumTransformer $ent, QueryResultTransformer $qrt)
    {
        return view('skill.create', [
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
            $group = $request->input('group');
            $newGroup = $request->input('newGroup');
            $years = $request->input('years');
            $fields = $request->input('fields');
            $newFields = $request->input('newFields');
            $newTopics = $request->input('newTopics');

            $skill = new Skill;
            $skill->title = $title;
            if ($group) {
                $skill->group_id = $group;
            } elseif ($newGroup) {
                $group = new Group;
                $group->title = $newGroup;
                $group->save();
                $skill->group_id = $group->id;
            }
            $skill->save();
            foreach ($years as $value) {
                $skillYear = new SkillYear;
                $skillYear->skill_id = $skill->id;
                $skillYear->year = $value;
                $skillYear->save();
            }

            foreach ($fields ?? [] as $field) {
                $skillField = new SkillField;
                $skillField->skill_id = $skill->id;
                $skillField->field_id = $field;
                $skillField->save();
            }

            foreach ($newFields ?? [] as $index => $newField) {
                $newFieldIndex = intval($index);
                $field = new Field;
                $field->title = $newField['title'];
                $field->save();
                $newFields[$newFieldIndex]['id'] = $field->id;
                $newFieldYears = $newField['years'];
                foreach ($newFieldYears as $year) {
                    $fieldYear = new FieldYear;
                    $fieldYear->field_id = $field->id;
                    $fieldYear->year = $years[intval($year)];
                    $fieldYear->save();
                }
                $skillField = new SkillField;
                $skillField->skill_id = $skill->id;
                $skillField->field_id = $field->id;
                $skillField->save();
            }

            foreach ($newTopics ?? [] as $index => $newTopic) {
                $topic = new Topic;
                $topic->title = $newTopic['title'];
                if (is_array($newTopic['subject'])) {
                    $newSubject = $newTopic['subject'][0];
                    $subject = new Subject;
                    $subject->title = $newSubject['title'];
                    $subject->abbreviation = $newSubject['abbreviation'];
                    $subject->save();
                    $newSubjectYears = $newSubject['years'];
                    foreach ($newSubjectYears as $year) {
                        $subjectYear = new SubjectYear;
                        $subjectYear->subject_id = $subject->id;
                        $subjectYear->year = $years[intval($year)];
                        $subjectYear->save();
                    }
                    $topic->subject_id = $subject->id;
                } else {
                    $topic->subject_id = $newTopic['subject'];
                }
                $topic->skill_id = $skill->id;
                $topic->save();

                foreach ($topic['years'] as $year) {
                    $topicYear = new TopicYear;
                    $topicYear->topic_id = $topic->id;
                    $topicYear->year = $years[intval($year)];
                    $topicYear->save();
                }

                foreach ($newTopic['fields'] ?? [] as $index) {
                    if (is_numeric($index)) {
                        $topicField = new TopicField;
                        $topicField->topic_id = $topic->id;
                        $topicField->field_id = $newFields[intval($index)]['id'];
                        $topicField->save();
                    } else {
                        $topicField = new TopicField;
                        $topicField->topic_id = $topic->id;
                        $topicField->field_id = $index;
                        $topicField->save();
                    }
                }

                $newTopicDocuments = $request->file("documents_topic_{$index}");
                foreach ($newTopicDocuments ?? [] as $index => $document) {
                    $newLearningMaterial = new LearningMaterial;
                    $newLearningMaterial->topic_id = $topic->id;
                    $newLearningMaterial->approval_status = ApprovalStatus::Pending->value;
                    $newLearningMaterial->path = $document->store('public');
                    $newLearningMaterial->title = $document->getClientOriginalName();
                    $newLearningMaterial->mime_type = $document->extension();
                    $newLearningMaterial->alternative = $document->hashName();
                    $newLearningMaterial->save();
                }
            }
        });
        Toast::title('Skill sucessfuly saved!');
        return redirect()->route('skills.index');
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
