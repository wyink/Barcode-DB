<?php

use App\Http\Controllers\BlastRunController;
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

Route::post('/blastRun',[BlastRunController::class,'index']);

Route::get('/download', function () {
    return view('download');
});
Route::get('/help', function () {
    return view('help');
});
Route::get('/taxonomy', function () {
    return view('taxonomy');
});
