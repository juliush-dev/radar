<?php

use App\Enums\Year;
use App\Http\Controllers\ProfileController;
use App\Models\Field;
use App\Models\FieldYear;
use App\Models\Group;
use App\Models\Skill;
use App\Models\Topic;
use App\Services\RadarQuery;
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
        Route::post('/topics/{topic}/learning-materials/upload', [App\Http\Controllers\TopicController::class, 'uploadLearningMaterial'])->name('topics.learning-materials.upload');
        Route::post('/topics/learning-materials/{learningMaterial}/remove', [App\Http\Controllers\TopicController::class, 'removeLearningMaterial'])->name('topics.learning-materials.remove');
        Route::post('/topics/{topic}/assess', [App\Http\Controllers\TopicController::class, 'assess'])->name('topics.assess');
        Route::resource('topics', App\Http\Controllers\TopicController::class)->except(['show', 'index']);
        Route::resource('skills', App\Http\Controllers\SkillController::class)->except(['show', 'index']);
        Route::resource('profile', ProfileController::class)->except(['create', 'index', 'show']);
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
            return redirect()->route('skills.index');
        })->name('groups.update');
        Route::resource('fields', App\Http\Controllers\FieldController::class)->except(['index', 'show']);;
        Route::resource('subjects', App\Http\Controllers\SubjectController::class)->only(['edit', 'update']);
    });
    Route::resource('fields', App\Http\Controllers\FieldController::class)->only(['index', 'show']);
    Route::resource('topics', App\Http\Controllers\TopicController::class)->only(['index', 'show']);
    Route::resource('skills', App\Http\Controllers\SkillController::class)->only(['index', 'show']);
    require __DIR__ . '/auth.php';
});
