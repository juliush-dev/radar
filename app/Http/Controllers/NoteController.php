<?php

namespace App\Http\Controllers;

use App\Models\Note;

class NoteController extends Controller
{
    public function references(Note $note)
    {
        return view('note.references', ['note' => $note]);
    }
}
