<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Note;
use App\Services\RadarQuery;
use Facades\Spatie\Referer\Referer;
use Illuminate\Support\Facades\Route;

class NoteController extends Controller
{

    public function __construct(private RadarQuery $rq)
    {
    }

    public function filter(Request $request)
    {
        $categoriesFilterValue = $request->query('categories');
        if (!isset($categoriesFilterValue)) {
            return redirect(route('notes.index'));
        }
        $filter['categories'] = $categoriesFilterValue;
        return view('note.index', [
            'notes' => $this->rq->notes($filter),
            'filter' => $filter
        ]);
    }

    public function index()
    {
        return view('note.index', ['filter' => [], 'notes' => $this->rq->notes()]);
    }

    public function showAsReferer(Note $referer)
    {
        return view('note.referer', ['note' => $referer]);
    }

    public function edit(Request $request, Note $note)
    {
        $pile = null;
        if ($input = $request->input('pile')) {
            $pile = Note::find($input);
        }
        return view("note.edit", ['note' => $note, 'pile' => $pile]);
    }

    public function store(Request $request)
    {
        $newNote = null;
        DB::transaction(function () use ($request, &$newNote) {
            $newNote = new Note;
            $newNote->user_id = $request->user()->id;
            $newNote->content = '<h1>My new Note title</h1>';
            $newNote->save();
        });
        return redirect(route('notes.edit', $newNote));
    }

    public function update(Request $request, Note $note)
    {
        DB::transaction(function () use ($request, &$note) {
            $note->content = $request->input('content');
            $note->save();
        });
        $response['updated_at'] = $note->updated_at;
        return $response;
    }

    public function relatives(Note $note)
    {
        return view('note.relatives', [
            'note' => $note,
            'relativesOptions' => Note::relativesOptions($note->id),
        ]);
    }

    public function relate(Request $request, Note $note)
    {
        DB::transaction(function () use ($request, &$note) {
            $note->relatives()->detach();
            $note->relatives()->attach(collect($request->input('relatives', []))->pluck('id'));
        });
        return redirect(route('notes.edit', $note));
    }

    public function destroy(Note $note)
    {
        DB::transaction(function () use ($note) {
            $note->delete();
        });
        return redirect(route('notes.index'));
    }

    public function publish(Note $note)
    {
        DB::transaction(function () use ($note) {
            $note->is_public = true;
            $note->save();
        });
        return redirect(Referer::get());
    }

    public function unpublish(Note $note)
    {
        DB::transaction(function () use ($note) {
            $note->is_public = false;
            $note->save();
        });
        return redirect(Referer::get());
    }

    public function history()
    {
        $lastOpened = Note::latest('updated_at')->take(12)->get();
        return view('note.history', ['lastOpened' => $lastOpened]);
    }
}
