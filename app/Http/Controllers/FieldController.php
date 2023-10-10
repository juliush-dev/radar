<?php

namespace App\Http\Controllers;

use App\Models\FieldYear;
use App\Models\Field;
use App\Services\RadarQuery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use ProtoneMedia\Splade\Facades\Toast;

class FieldController extends Controller
{
    public function __construct(private RadarQuery $rq)
    {
    }

    public function show(Field $field)
    {
        return view('field.show', ['field' => $field]);
    }

    public function index(Request $request)
    {
        if ($request->boolean('reset')) {
            return redirect(route('fields.index'));
        }
        $yearFilterValue = $request->query('year');
        $filterIsSet = array_reduce([$yearFilterValue], function ($acc, $value) {
            $acc |= isset($value);
            return $acc;
        }, false);
        return view('field.index', [
            'fields' => $this->rq->fields(
                [
                    'year' => $yearFilterValue,
                ]
            ),
            'rq' => $this->rq,
            'filterIsSet' => $filterIsSet
        ]);
    }

    public function create()
    {
        $this->authorize('create-field');
        return view('field.create', [
            'rq' => $this->rq
        ]);
    }

    public function edit(Request $request, Field $field)
    {
        $this->authorize('update-field');
        return view('field.edit', [
            'field' => $field,
            'rq' => $this->rq,
            'routeOnSuccess' => $request->input('routeOnSuccess'),
            'routeOnCancel' => $request->input('routeOnCancel') ?? route('fields.index'),
        ]);
    }

    public function update(Request $request, Field $field)
    {
        if (!Gate::allows('update-field')) {
            abort(403);
        }
        DB::transaction(function () use ($request, $field) {
            $title = $request->input('title');
            $code = $request->input('code');
            $details = $request->input('details');
            $years = $request->input('years');
            if ($title != $field->title) {
                $field->title = $title;
                $field->save();
            }
            if ($code != $field->code) {
                $field->code = $code;
                $field->save();
            }
            if ($details != $field->details) {
                $field->details = $details;
                $field->save();
            }
            if (is_array($years) && count($years) > 0) {
                $fieldYearsDeleted = $field->years()->pluck('year')->diff($years);
                $fieldYearsDeleted->each(function ($year) use ($field) {
                    FieldYear::where('field_id', $field->id)->where('year', $year)->delete();
                });
                $yearsAdded = collect($years)->diff($field->years()->pluck('year'));
                $yearsAdded->each(function ($year) use ($field) {
                    $fieldYear = new FieldYear;
                    $fieldYear->field_id = $field->id;
                    $fieldYear->year = $year;
                    $fieldYear->save();
                });
            }
        });
        Toast::title('Field sucessfuly updated!')->autoDismiss(5);
        return redirect()->route('fields.show', $field);
    }

    public function store(Request $request)
    {
        $this->authorize('create-field');
        $field = null;
        DB::transaction(function () use ($request, &$field) {
            $field = new Field;
            $field->title = $request->input('title');
            $field->code = $request->input('code');
            $field->details = $request->input('details');
            $field->save();
            $years = $request->input('years');
            if (is_array($years) && count($years) > 0) {
                collect($years)->each(function ($year) use ($field) {
                    $fieldYear = new FieldYear;
                    $fieldYear->field_id = $field->id;
                    $fieldYear->year = $year;
                    $fieldYear->save();
                });
            }
        });
        Toast::title('field sucessfuly created!')->autoDismiss(5);
        return redirect()->route('fields.show', $field);
    }
    public function destroy(Field $field)
    {
        $this->authorize('delete-field');
        $field->delete();
        Toast::title('field deleted')->autoDismiss(5);
        return redirect()->route('fields.index');
    }
}
