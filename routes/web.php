<?php

use App\Http\Controllers\ContributionController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubjectController;
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

    Route::get('/skills', [SkillController::class, 'index'])->name('skill.index');
    Route::get('/skills/{skill}', [SkillController::class, 'show'])->name('skill.show');

    Route::middleware('auth')->group(function () {

        Route::get('/skills/{skill}/topics/new', [TopicController::class, 'create'])->name('topic.create');
        Route::post('/skills/{skill}/topics/new', [TopicController::class, 'store'])->name('topic.store');
        Route::get('/skills/{skill}/subjects/new', [SubjectController::class, 'create'])->name('subject.create');
        Route::post('/skills/{skill}/subjects/new', [SubjectController::class, 'store'])->name('subject.store');

        Route::get('/contributions', [ContributionController::class, 'index'])->middleware(['verified'])->name('contribution.index');


        Route::get('/contributions/skills', [App\Http\Controllers\Contribution\SkillController::class, 'index'])->name('contribution.skill.index');
        Route::get('/contributions/teachers', [App\Http\Controllers\Contribution\TeacherController::class, 'index'])->name('contribution.teacher.index');
        Route::get('/contributions/subjects', [App\Http\Controllers\Contribution\SubjectController::class, 'index'])->name('contribution.subject.index');
        Route::get('/contributions/topic', [App\Http\Controllers\Contribution\TopicController::class, 'index'])->name('contribution.topic.index');
        Route::get('/contributions/learning-materials', [App\Http\Controllers\Contribution\LearningMaterialController::class, 'index'])->name('contribution.learning-material.index');

        Route::get('/contributions/skills/new', [App\Http\Controllers\Contribution\SkillController::class, 'create'])->name('contribution.skill.create');
        Route::get('/contributions/teachers/new', [App\Http\Controllers\Contribution\TeacherController::class, 'create'])->name('contribution.teacher.create');
        Route::get('/contributions/subjects/new', [App\Http\Controllers\Contribution\SubjectController::class, 'create'])->name('contribution.subject.create');
        Route::get('/contributions/topic/new', [App\Http\Controllers\Contribution\TopicController::class, 'create'])->name('contribution.topic.create');
        Route::get('/contributions/learning-materials/new', [App\Http\Controllers\Contribution\LearningMaterialController::class, 'create'])->name('contribution.learning-material.create');

        Route::post('/contributions/skills/new', [App\Http\Controllers\Contribution\SkillController::class, 'store'])->name('contribution.skill.store');
        Route::post('/contributions/teachers/new', [App\Http\Controllers\Contribution\TeacherController::class, 'store'])->name('contribution.teacher.store');
        Route::post('/contributions/subjects/new', [App\Http\Controllers\Contribution\SubjectController::class, 'store'])->name('contribution.subject.store');
        Route::post('/contributions/topic/new', [App\Http\Controllers\Contribution\TopicController::class, 'store'])->name('contribution.topic.store');
        Route::post('/contributions/learning-materials/new', [App\Http\Controllers\Contribution\LearningMaterialController::class, 'store'])->name('contribution.learning-material.store');


        Route::get('/{skill}/skill-requirements', [App\Http\Controllers\SkillRequirementController::class, 'index'])->name('skill-requirement.index');
        Route::get('/{skill}/skill-requirements/new', [App\Http\Controllers\SkillRequirementController::class, 'create'])->name('skill-requirement.create');
        Route::post('/{skill}/skill-requirements/new', [App\Http\Controllers\SkillRequirementController::class, 'store'])->name('skill-requirement.store');
        Route::post('/skill-requirements/delete', [App\Http\Controllers\SkillRequirementController::class, 'delete'])->name('skill-requirement.delete');

        Route::get('/{topic}/topic-subjects/new', [App\Http\Controllers\SubjectCoveringTopicController::class, 'create'])->name('topic-subject.create');
        Route::get('/topic-subjects/{topic-subject}/edit', [App\Http\Controllers\SubjectCoveringTopicController::class, 'edit'])->name('topic-subject.edit');
        Route::post('/{topic}/topic-subjects/new', [App\Http\Controllers\SubjectCoveringTopicController::class, 'store'])->name('topic-subject.store');
        Route::post('/topic-subjects/delete', [App\Http\Controllers\SubjectCoveringTopicController::class, 'delete'])->name('topic-subject.delete');

        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    require __DIR__ . '/auth.php';
});
