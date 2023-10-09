<?php

use App\Http\Controllers\ProfileController;
use App\Models\Group;
use Facades\Spatie\Referer\Referer;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use ProtoneMedia\Splade\Facades\Toast;

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
            Route::post('/{topic}/assess', [App\Http\Controllers\TopicController::class, 'assess'])->name('assess');
            Route::post('/{topic}/publish', [App\Http\Controllers\TopicController::class, 'publishTopic'])->name('publish');
            Route::post('/{topic}/unpublish', [App\Http\Controllers\TopicController::class, 'unpublishTopic'])->name('unpublish');
            Route::post('/{topic}/apply-update', [App\Http\Controllers\TopicController::class, 'applyUpdate'])->name('apply-update');
        });

        Route::resource('topics', App\Http\Controllers\TopicController::class)->except(['show', 'index']);
        Route::resource('skills', App\Http\Controllers\SkillController::class)->except(['show', 'index']);
        Route::resource('profile', ProfileController::class)->except(['create', 'index', 'show']);

        Route::post('/profile/{profile}/block', [App\Http\Controllers\ProfileController::class, 'block'])->name('profile.block');
        Route::post('/profile/{profile}/unblock', [App\Http\Controllers\ProfileController::class, 'unblock'])->name('profile.unblock');


        Route::get('/groups/{group}/edit', function (Group $group) {
            return view('group.edit', ['group' => $group]);
        })->name('groups.edit');
        Route::patch('/groups/{group}', function (Request $request, Group $group) {
            $title = $request->input('title');
            if ($title != $group->title) {
                $group->title = $title;
                $group->save();
            }
            Toast::title('Group sucessfuly updated!')->autoDismiss(5);
            return redirect(Referer::get());
        })->name('groups.update');

        Route::resource('fields', App\Http\Controllers\FieldController::class)->except(['index', 'show']);;
        Route::resource('subjects', App\Http\Controllers\SubjectController::class)->only(['edit', 'update']);
    });
    Route::resource('fields', App\Http\Controllers\FieldController::class)->only(['index', 'show']);
    Route::resource('topics', App\Http\Controllers\TopicController::class)->only(['index', 'show']);
    Route::resource('skills', App\Http\Controllers\SkillController::class)->only(['index', 'show']);
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard.index');
    require __DIR__ . '/auth.php';
});
