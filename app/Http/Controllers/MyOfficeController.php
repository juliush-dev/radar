<?php

namespace App\Http\Controllers;

use App\Models\MyOffice;
use App\Models\MySubject;
use App\Models\MyTopic;
use App\Models\Subject;
use App\Models\Topic;
use Facades\Spatie\Referer\Referer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use ProtoneMedia\Splade\Facades\Toast;

class MyOfficeController extends Controller
{
    public function show(MyOffice $office)
    {
        if (!Gate::allows('see-office', $office)) {
            Toast::warning('Access Denied')->autoDismiss(5);
            return redirect(Referer::get());
        }
        return view('my-office.show', ['myOffice' => $office]);
    }

    public function store(Request $request)
    {
        if (!Gate::allows('create-office')) {
            Toast::warning('Access Denied')->autoDismiss(5);
            return redirect(Referer::get());
        }
        $myOffice = null;
        DB::transaction(function () use ($request, &$myOffice) {
            $myOffice = new MyOffice;
            $myOffice->user_id = $request->user()->id;
            $myOffice->save();
        });
        return redirect(route('my-office.show', $myOffice));
    }

    public function addSubject(MyOffice $office, Subject $subject)
    {
        if (!Gate::allows('see-office', $office)) {
            Toast::warning('Access Denied')->autoDismiss(5);
            return redirect(Referer::get());
        }
        DB::transaction(function () use ($office, $subject) {
            $mySubject = new MySubject;
            $mySubject->my_office_id = $office->id;
            $mySubject->subject_id = $subject->id;
            $mySubject->save();
        });
        return redirect(route('my-office.show', $office));
    }

    public function removeSubject(MySubject $subject)
    {
        $office = $subject->office;
        if (!Gate::allows('see-office', $office)) {
            Toast::warning('Access Denied')->autoDismiss(5);
            return redirect(Referer::get());
        }
        DB::transaction(function () use ($subject) {
            $subject->delete();
        });
        return redirect(route('my-office.show', $office));
    }

    public function showSubject(MySubject $subject)
    {
        if (!Gate::allows('see-office', $subject->office)) {
            Toast::warning('Access Denied')->autoDismiss(5);
            return redirect(Referer::get());
        }
        return view('my-office.show', [
            'myOffice' => $subject->office,
            'myActiveSubject' => $subject
        ]);
    }

    public function addTopic(MySubject $subject, Topic $topic)
    {
        $mySubject = $subject;
        if (!Gate::allows('see-office', $subject->office)) {
            Toast::warning('Access Denied')->autoDismiss(5);
            return redirect(Referer::get());
        }
        DB::transaction(function () use ($mySubject, $topic) {
            $myTopic = new MyTopic;
            $myTopic->my_subject_id = $mySubject->id;
            $myTopic->topic_id = $topic->id;
            $myTopic->save();
        });
        return redirect(Referer::get());
    }

    public function removeTopic(MyTopic $topic)
    {
        $myTopic = $topic;
        $mySubject = $myTopic->subject;
        if (!Gate::allows('see-office', $mySubject->office)) {
            Toast::warning('Access Denied')->autoDismiss(5);
            return redirect(Referer::get());
        }
        DB::transaction(function () use ($myTopic) {
            $myTopic->delete();
        });
        return redirect(route('my-office.subjects.show', $mySubject));
    }

    public function showTopic(MyTopic $topic)
    {
        $myTopic = $topic;
        $mySubject = $myTopic->subject;
        if (!Gate::allows('see-office', $mySubject->office)) {
            Toast::warning('Access Denied')->autoDismiss(5);
            return redirect(Referer::get());
        }
        return view('my-office.show', [
            'myOffice' => $mySubject->office,
            'myActiveSubject' => $mySubject,
            'myActiveTopic' => $myTopic,
        ]);
    }
    public function reorderSubjects(Request $request)
    {
        $newOrder = $request->input('newOrder', []);
        $firstSubject = $newOrder[0];
        $office = MySubject::find($firstSubject['id'])?->office;
        if (!Gate::allows('see-office', $office)) {
            Toast::warning('Access Denied')->autoDismiss(5);
            return redirect(Referer::get());
        }
        DB::transaction(function () use ($request) {
            collect($request->input('newOrder', []))->each(
                function ($subject) {
                    $oldSubject = MySubject::with('topics')->find($subject['id']);
                    if (!empty($oldSubject)) {
                        $newSubject = $oldSubject->replicate();
                        $newSubject->save();
                        $oldSubject->topics?->each(
                            function ($topic) use ($newSubject) {
                                $topic->my_subject_id = $newSubject->id;
                                $topic->save();
                            }
                        );
                        $oldSubject->delete();
                    }
                }
            );
        });
        return redirect(Referer::get());
    }
    public function reorderTopics(Request $request)
    {
        $newOrder = $request->input('newOrder', []);
        $firstTopic = $newOrder[0];
        $office = MyTopic::find($firstTopic['id'])?->subject->office;
        if (!Gate::allows('see-office', $office)) {
            Toast::warning('Access Denied')->autoDismiss(5);
            return redirect(Referer::get());
        }
        DB::transaction(function () use ($request) {
            collect($request->input('newOrder', []))->each(
                function ($topic) {
                    $oldTopic = MyTopic::with('checkpoints')->find($topic['id']);
                    if (!empty($oldTopic)) {
                        $newTopic = $oldTopic->replicate();
                        $newTopic->save();
                        $oldTopic->checkpoints?->each(
                            function ($checkpoints) use ($newTopic) {
                                $checkpoints->my_topic_id = $newTopic->id;
                                $checkpoints->save();
                            }
                        );
                        $oldTopic->delete();
                    }
                }
            );
        });
        return redirect(Referer::get());
    }
}
