<?php

use App\Http\Controllers\BlastRunController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\TaxonomyController;
use App\Http\Middleware\BlastRunMiddleware;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/*get or post method will be implemented in the contoroller. */
Route::get('/', function () {
    return view('index');
});

Route::post('/blastRun',[BlastRunController::class,'index'])
        ->middleware('blastrun');

Route::get('/download', function () {
    return view('download');
});

Route::get('/download/{fileName}',[DownloadController::class,'index'])
        ->name('download.index');

Route::get('/help', function () {
    return view('help');
});
Route::get('/taxonomy', function () {
    return view('taxonomy');
});

Route::get('/taxonomy/{category}/{alp}',[TaxonomyController::class,'index']);
