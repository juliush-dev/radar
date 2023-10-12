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

    Route::get('/topics/learning-materials/{learningMaterial}/download', [App\Http\Controllers\TopicController::class, 'downloadLearningMaterial'])->name('topics.learning-materials.download');
    Route::middleware('auth')->group(function () {
        Route::prefix('topics')->name('topics.')->group(function () {
            Route::post('/{topic}/learning-materials/upload', [App\Http\Controllers\TopicController::class, 'uploadLearningMaterial'])->name('learning-materials.upload');
            Route::delete('/learning-materials/{learningMaterial}/remove', [App\Http\Controllers\TopicController::class, 'removeLearningMaterial'])->name('learning-materials.remove');
            Route::post('/learning-materials/{learningMaterial}/publish', [App\Http\Controllers\TopicController::class, 'publishLearningMaterial'])->name('learning-materials.publish');
            Route::post('/learning-materials/{learningMaterial}/unpublish', [App\Http\Controllers\TopicController::class, 'unpublishLearningMaterial'])->name('learning-materials.unpublish');
            Route::post('/{topic}/publish', [App\Http\Controllers\TopicController::class, 'publishTopic'])->name('publish');
            Route::post('/{topic}/unpublish', [App\Http\Controllers\TopicController::class, 'unpublishTopic'])->name('unpublish');
            Route::post('/{topic}/apply-update', [App\Http\Controllers\TopicController::class, 'applyUpdate'])->name('apply-update');

            Route::get('/subjects/{subject}/edit', [App\Http\Controllers\TopicController::class, 'editSubject'])->name('subjects.edit');
            Route::patch('/subjects/{subject}', [App\Http\Controllers\TopicController::class, 'updateSubject'])->name('subjects.update');
        });

        Route::resource('topics', App\Http\Controllers\TopicController::class)->except(['show', 'index']);
        Route::resource('skills', App\Http\Controllers\SkillController::class)->except(['show', 'index']);
        Route::resource('profile', ProfileController::class)->except(['create', 'index', 'show']);

        Route::post('/profile/{profile}/block', [App\Http\Controllers\ProfileController::class, 'block'])->name('profile.block');
        Route::post('/profile/{profile}/unblock', [App\Http\Controllers\ProfileController::class, 'unblock'])->name('profile.unblock');
        Route::resource('fields', App\Http\Controllers\FieldController::class)->except(['index', 'show']);;

        Route::prefix('skills')->name('skills.')->group(function () {
            Route::post('/{skill}/assess', [App\Http\Controllers\SkillController::class, 'assess'])->name('assess');
            Route::get('/groups/{group}/edit', [App\Http\Controllers\SkillController::class, 'editGroup'])->name('groups.edit');
            Route::patch('/groups/{group}', [App\Http\Controllers\SkillController::class, 'updateGroup'])->name('groups.update');

            Route::get('/types/{type}/edit', [App\Http\Controllers\SkillController::class, 'editType'])->name('types.edit');
            Route::patch('/types/{type}', [App\Http\Controllers\SkillController::class, 'updateType'])->name('types.update');
        });
    });
    Route::resource('fields', App\Http\Controllers\FieldController::class)->only(['index', 'show']);
    Route::resource('topics', App\Http\Controllers\TopicController::class)->only(['index', 'show']);
    Route::resource('skills', App\Http\Controllers\SkillController::class)->only(['index', 'show']);

    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard.index');
    require __DIR__ . '/auth.php';
});
