<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\SubjectYear;
use App\Services\RadarQuery;
use Facades\Spatie\Referer\Referer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use ProtoneMedia\Splade\Facades\Toast;

class SubjectController extends Controller
{
    public function __construct(private RadarQuery $rq)
    {
    }

    public function edit(Subject $subject)
    {
        return view('subject.edit', [
            'subject' => $subject,
            'years' => $this->rq->years()
        ]);
    }

    public function update(Request $request, Subject $subject)
    {
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
}
