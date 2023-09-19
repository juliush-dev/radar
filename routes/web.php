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
    });

    Route::resource('skills', App\Http\Controllers\SkillController::class)->only(['index']);
    //App\Http\Controllers\ContributionController
    Route::middleware('auth')->group(function () {
        Route::resource('skills', App\Http\Controllers\SkillController::class)->except(['show', 'index']);
        Route::resource('learning-materials', App\Http\Controllers\LearningMaterialController::class)->except(['show']);
        Route::resource('profile', ProfileController::class)->except(['create', 'index', 'show']);
    });

    require __DIR__ . '/auth.php';
});
