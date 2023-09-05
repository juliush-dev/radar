<?php

use App\Http\Controllers\ContributionController;
use App\Http\Controllers\KnowledgeController;
use App\Http\Controllers\LearningMaterialController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
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

    Route::middleware('auth')->group(function () {
        Route::get('/contributions', [ContributionController::class, 'index'])->middleware(['verified'])->name('contribution.index');
        Route::get('/skills/new', [SkillController::class, 'create'])->name('skill.create');
        Route::post('/skills/new', [SkillController::class, 'store'])->name('skill.store');

        Route::get('/teachers/new', [TeacherController::class, 'create'])->name('teacher.create');
        Route::post('/teachers/new', [TeacherController::class, 'store'])->name('teacher.store');

        Route::get('/subjects/new', [SubjectController::class, 'create'])->name('subject.create');
        Route::post('/subjects/new', [SubjectController::class, 'store'])->name('subject.store');

        Route::get('/knowledge/new', [KnowledgeController::class, 'create'])->name('knowledge.create');
        Route::post('/knowledge/new', [KnowledgeController::class, 'store'])->name('knowledge.store');


        Route::get('/learning-materials/new', [LearningMaterialController::class, 'create'])->name('learning-material.create');
        Route::post('/learning-materials/new', [LearningMaterialController::class, 'store'])->name('learning-material.store');

        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    require __DIR__ . '/auth.php';
});
