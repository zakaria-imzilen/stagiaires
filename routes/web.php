<?php

use App\Http\Controllers\StagiaireController;
use Database\Seeders\StagiareSeed;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [StagiaireController::class, 'list_all'])->name('home');

Route::post('/internee/add', [StagiaireController::class, 'add']);
Route::get('/internee/deleteAll', [StagiaireController::class, 'deleteAll']);
Route::post('/internee/search', [StagiaireController::class, 'search']);
Route::post('/internee/edit', [StagiaireController::class, 'edit']);
Route::get('/internee/delete/{id}', [StagiaireController::class, 'delete']);
