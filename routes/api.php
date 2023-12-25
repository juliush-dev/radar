<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/plantuml/render', function (Request $request) {
    $code = $request->input('code');
    $response = "Source file couldn't be created";
    if ($code != null && ($code = trim($code))) {
        $fileName = "source_" . time();
        // Storage::disk('public')->deleteDirectory('plantuml');
        if (Storage::disk('public')->put("plantuml/$fileName", $code)) {
            $path = Storage::path("public/plantuml/$fileName");
            $dir = dirname($path);
            $response = $dir;
            shell_exec("cd .. && java -jar plantuml.jar -tsvg -o '$dir' $path");
            $response = Storage::url("public/plantuml/$fileName.svg");
        }
    }
    return $response;
});

Route::get('/plantuml/resolve', function (Request $request) {
    $sourceDiagram = $request->input('src');
    $arr = explode('/', $sourceDiagram);
    $diagramFileName = array_pop($arr);
    $arr = explode('.', $diagramFileName);
    $codeFileName = array_shift($arr);
    $response = "File not found";
    if (Storage::disk('public')->exists("plantuml/$codeFileName")) {
        $response = Storage::disk('public')->get("plantuml/$codeFileName");
    }
    return $response;
});
