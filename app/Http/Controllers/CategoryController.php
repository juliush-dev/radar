<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Note;
use Facades\Spatie\Referer\Referer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{

    public function index(Note $note)
    {
        return view('note.categories', ['note' => $note, 'categoriesOptions' => Category::options()]);
    }
    public function delete(Note $note)
    {
        return view('category.delete', ['note' => $note, 'categoriesOptions' => Category::options()]);
    }

    public function destroy(Request  $request, Note $note)
    {
        DB::transaction(function () use ($request) {
            $selected = $request->input('selected');
            collect($selected)->each(function ($categoryId) {
                Category::find($categoryId)->delete();
            });
        });
        return redirect(route('notes.edit', $note));
    }

    public function categorize(Request $request, Note $note)
    {
        DB::transaction(function () use ($request, &$note) {
            $note->categories()->detach();
            $note->categories()->attach(collect($request->input('categories', []))->pluck('id'));
        });
        return redirect(route('notes.edit', $note));
    }

    public function create(Note $note)
    {
        return view('category.create', [
            'note' => $note
        ]);
    }

    public function edit(Note $note)
    {
        return view('category.edit', [
            'categoriesOptions' => Category::options(),
            'note' => $note
        ]);
    }

    public function update(Request $request, Category $category)
    {
        DB::transaction(function () use ($request, $category) {
            $newName = trim($request->input('name', ''));
            $oldName = $category->name;
            $category->name = empty($newName) || strlen($newName) < 4 ?  $oldName : $newName;
            $category->save();
        });
    }

    public function store(Request $request, Note $note)
    {
        DB::transaction(function () use ($request) {
            $category = new Category;
            $category->name = trim($request->input('name'));
            $category->save();
        });
        return redirect(route('notes.edit', $note));
    }
}
