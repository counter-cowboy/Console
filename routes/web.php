<?php

use App\Http\Controllers\UserController;
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
Route::get('/list-users', [UserController::class,'listUsers']);
Route::post('/create-user', [UserController::class, 'createUser']);
Route::delete('/delete-user/{user}', [UserController::class, 'deleteUser']);
