<?php

use App\Http\Controllers\ProfileController;
use App\Models\Skill;
use App\Models\Topic;
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
    });

    Route::resource('skills', App\Http\Controllers\SkillController::class)->only(['show', 'index']);
    Route::resource('topics', App\Http\Controllers\TopicController::class)->only(['show', 'index']);
    Route::resource('skill-topics', App\Http\Controllers\SkillTopicController::class)->only(['show']);
    //App\Http\Controllers\ContributionController
    Route::middleware('auth')->group(function () {
        Route::resource('subjects', App\Http\Controllers\SubjectController::class)->only(['show', 'index']);
        Route::resource('learning-materials', App\Http\Controllers\LearningMaterialController::class)->only(['show', 'index']);
        Route::resource('contributions', App\Http\Controllers\ContributionController::class)->only(['index']);
        Route::name('contributions.')->group(function () {
            Route::prefix('/contributions')->group(function () {
                Route::controller(App\Http\Controllers\ContributionController::class)->group(function () {
                    Route::post('/{contribution}/approve', 'approve')->name('approve');
                    Route::post('/{contribution}/reject', 'reject')->name('reject');
                    Route::post('/{contribution}/publish', 'publish')->name('publish');
                    Route::post('/{contribution}/hide', 'hide')->name('hide');
                });
                Route::resource('skills', App\Http\Controllers\Contribution\SkillController::class);
                Route::resource('topics', App\Http\Controllers\Contribution\TopicController::class);
                Route::resource('subjects', App\Http\Controllers\Contribution\SubjectController::class);
                Route::resource('learning-materials', App\Http\Controllers\Contribution\LearningMaterialController::class);
            });
        });
        Route::resource('profile', ProfileController::class)->except(['create', 'index', 'show']);
        Route::get('/api/topics/{skill?}', function (Request $request, Skill $skill = null) {
            if ($skill == null) {
                $skill = new Skill;
            }
            $skill->fields_covered_by_it = $request->query('fields');
            $skill->years_levels_covering_it = $request->query('years');
            if ($skill->fields_covered_by_it == 0 || $skill->years_levels_covering_it == 0) {
                return [];
            } else {
                return $skill->topicsOptions();
            }
        })->name("topics.options");
        Route::get('/api/subjects/{topic?}', function (Request $request, Topic $topic = null) {
            if ($topic == null) {
                $topic = new Topic;
            }
            $topic->year_teached_at = $request->query('year');
            if ($topic->year_teached_at == 0) {
                return [];
            } else {
                return $topic->subjectsOptions();
            }
        })->name("subjects.options");
    });

    require __DIR__ . '/auth.php';
});
