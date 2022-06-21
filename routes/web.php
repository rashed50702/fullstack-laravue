<?php

use App\Http\Controllers\AdminUserController;
use Illuminate\Support\Facades\Route;



Route::get('/', [AdminUserController::class, 'index']);
Route::post('login', [AdminUserController::class, 'adminLogin']);
Route::get('logout', [AdminUserController::class, 'logout']);
Route::any('{slug}', [AdminUserController::class, 'index']);



// Route::get('{slug}', function () {
//     return view('app');
// })->where('slug', '.*');