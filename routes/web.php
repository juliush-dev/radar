<?php

use App\Http\Controllers\ProfileController;
use App\Models\Skill;
use App\Models\Topic;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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
    Route::resource('topics', App\Http\Controllers\TopicController::class)->only(['index']);
    Route::middleware('auth')->group(function () {
        Route::post('/topics/{topic}/learning-materials/upload', [App\Http\Controllers\TopicController::class, 'uploadLearningMaterial'])->name('topics.learning-materials.upload');
        Route::post('/topics/learning-materials/{learningMaterial}/remove', [App\Http\Controllers\TopicController::class, 'removeLearningMaterial'])->name('topics.learning-materials.remove');
        Route::post('/topics/{topic}/assess', [App\Http\Controllers\TopicController::class, 'assess'])->name('topics.assess');
        Route::resource('topics', App\Http\Controllers\TopicController::class)->except(['show', 'index']);
        Route::resource('profile', ProfileController::class)->except(['create', 'index', 'show']);
    });

    require __DIR__ . '/auth.php';
});
