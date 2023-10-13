<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Jenssegers\Agent\Agent;

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
    Route::spladeWithVueBridge();

    // Registers routes to support password confirmation in Form and Link components...
    Route::spladePasswordConfirmation();

    // Registers routes to support Table Bulk Actions and Exports...
    Route::spladeTable();

    // Registers routes to support async File Uploads with Filepond...
    Route::spladeUploads();

    Route::get('/', function () {
        return view('welcome');
    })->name('welcome');

    Route::get(
        '/topics/learning-materials/{learningMaterial}/download',
        [App\Http\Controllers\TopicController::class, 'downloadLearningMaterial']
    )->name('topics.learning-materials.download');
    Route::middleware('auth')->group(function () {
        Route::controller(App\Http\Controllers\TopicController::class)
            ->prefix('topics')
            ->name('topics.')
            ->group(function () {
                Route::post(
                    '/{topic}/learning-materials/upload',
                    'uploadLearningMaterial'
                )->name('learning-materials.upload');
                Route::delete(
                    '/learning-materials/{learningMaterial}/remove',
                    'removeLearningMaterial'
                )->name('learning-materials.remove');
                Route::post(
                    '/learning-materials/{learningMaterial}/publish',
                    'publishLearningMaterial'
                )->name('learning-materials.publish');
                Route::post(
                    '/learning-materials/{learningMaterial}/unpublish',
                    'unpublishLearningMaterial'
                )->name('learning-materials.unpublish');
                Route::post(
                    '/{topic}/publish',
                    'publishTopic'
                )->name('publish');
                Route::post(
                    '/{topic}/unpublish',
                    'unpublishTopic'
                )->name('unpublish');
                Route::post(
                    '/{topic}/apply-update',
                    'applyUpdate'
                )->name('apply-update');

                Route::get(
                    '/subjects/{subject}/edit',
                    'editSubject'
                )->name('subjects.edit');
                Route::patch(
                    '/subjects/{subject}',
                    'updateSubject'
                )->name('subjects.update');
            });

        Route::resource('topics', App\Http\Controllers\TopicController::class)->except(['show', 'index']);
        Route::resource('skills', App\Http\Controllers\SkillController::class)->except(['show', 'index']);
        Route::resource('profile', ProfileController::class)->except(['create', 'index', 'show']);

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

        Route::resource('fields', App\Http\Controllers\FieldController::class)->except(['index', 'show']);;

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

                Route::get(
                    '/types/{type}/edit',
                    'editType'
                )->name('types.edit');
                Route::patch(
                    '/types/{type}',
                    'updateType'
                )->name('types.update');
            });
    });
    Route::resource(
        'fields',
        App\Http\Controllers\FieldController::class
    )->only(['index', 'show']);
    Route::resource(
        'topics',
        App\Http\Controllers\TopicController::class
    )->only(['index', 'show']);
    Route::resource(
        'skills',
        App\Http\Controllers\SkillController::class
    )->only(['index', 'show']);

    Route::get(
        '/dashboard',
        [App\Http\Controllers\DashboardController::class, 'index']
    )->name('dashboard.index');
    require __DIR__ . '/auth.php';
});
