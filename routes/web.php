<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\ProfileController;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('splade')->group(function () {
    // Registers routes to support the interactive components...
    // Route::spladeWithVueBridge();

    // Registers routes to support password confirmation in Form and Link components...
    Route::spladePasswordConfirmation();

    // Registers routes to support Table Bulk Actions and Exports...
    Route::spladeTable();

    // Registers routes to support async File Uploads with Filepond...
    Route::spladeUploads();

    Route::get('/', [App\Http\Controllers\NoteController::class, 'index'])->name('notes.index');
    Route::get('/notes/filter', [App\Http\Controllers\NoteController::class, 'filter'])->name('notes.filter');


    Route::middleware('auth')->group(function () {
        Route::get('/notes/modal', function (Request $request) {
            $note = Note::find($request->input('note'));
            $response = ['content' => $note->content ?? null, 'src' => $note->exists ? route('notes.edit', $note) : null];
            return $response;
        })->name('notes.modal');
        Route::resource(
            'notes',
            App\Http\Controllers\NoteController::class
        )->except(['show', 'index', 'create']);
        Route::get('/notes/{note}/relatives', [NoteController::class, 'relatives'])->name('notes.relatives');
        Route::post('/notes/{note}/relate', [NoteController::class, 'relate'])->name('notes.relate');
        Route::patch('/notes/{note}/publish', [NoteController::class, 'publish'])->name('notes.publish');
        Route::patch('/notes/{note}/unpublish', [NoteController::class, 'unpublish'])->name('notes.unpublish');
        Route::get('/notes/last-opened', [NoteController::class, 'history'])->name('notes.history');


        Route::get('/notes/{referer}', [App\Http\Controllers\NoteController::class, 'showAsReferer'])->name('notes.referer');


        Route::resource(
            'skills',
            App\Http\Controllers\SkillController::class
        )->except(['show', 'index']);


        Route::get('/categories/notes/{note}', [CategoryController::class, 'index'])->name('categories.index');
        Route::get('/categories/notes/{note}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
        Route::post('/categories/notes/{note}/store', [CategoryController::class, 'store'])->name('categories.store');
        Route::patch('/categories/{category}/notes/{note}', [CategoryController::class, 'update'])->name('categories.update');
        Route::get('/categories/notes/{note}/create', [CategoryController::class, 'create'])->name('categories.create');
        Route::post('/categories/notes/{note}/categorize', [CategoryController::class, 'categorize'])->name('notes.categorize');
        Route::get('/categories/notes/{note}/delete', [CategoryController::class, 'delete'])->name('categories.delete');
        Route::delete('/categories/notes/{note}/destroy', [CategoryController::class, 'destroy'])->name('categories.destroy');

        Route::resource(
            'profile',
            ProfileController::class
        )->except(['create', 'index', 'show']);

        Route::controller(App\Http\Controllers\ProfileController::class)
            ->prefix('profile')
            ->name("profile.")
            ->group(function () {
                Route::post(
                    '/{profile}/block',
                    'block'
                )->name('block');
                Route::post(
                    '/{profile}/unblock',
                    'unblock'
                )->name('unblock');
            });

        Route::resource(
            'fields',
            App\Http\Controllers\FieldController::class
        )->except(['index', 'show']);

        Route::controller(App\Http\Controllers\SkillController::class)
            ->prefix('skills')
            ->name('skills.')
            ->group(function () {
                Route::post(
                    '/{skill}/assess',
                    'assess'
                )->name('assess');

                Route::get(
                    '/groups/{group}/edit',
                    'editGroup'
                )->name('groups.edit');

                Route::patch(
                    '/groups/{group}',
                    'updateGroup'
                )->name('groups.update');

                Route::delete(
                    '/groups/{group}/remove',
                    'destroyGroup'
                )->name('groups.remove');

                Route::get(
                    '/types/{type}/edit',
                    'editType'
                )->name('types.edit');

                Route::patch(
                    '/types/{type}',
                    'updateType'
                )->name('types.update');
            });
        Route::resource(
            'checkpoints',
            App\Http\Controllers\CheckpointController::class
        )->only(['edit', 'update', 'destroy']);
    });

    Route::resource(
        'fields',
        App\Http\Controllers\FieldController::class
    )->only(['index', 'show']);

    Route::resource(
        'skills',
        App\Http\Controllers\SkillController::class
    )->only(['index', 'show']);

    Route::get(
        '/dashboard',
        [
            App\Http\Controllers\DashboardController::class, 'index'
        ]
    )->name('dashboard.index');
    require __DIR__ . '/auth.php';
});
