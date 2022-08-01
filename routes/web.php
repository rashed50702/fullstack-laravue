<?php

use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\PayOrderController;
use Illuminate\Support\Facades\Route;



Route::get('/', [AdminUserController::class, 'index']);
Route::get('/pay', [PayOrderController::class, 'store']);
Route::post('login', [AdminUserController::class, 'adminLogin']);
Route::get('logout', [AdminUserController::class, 'logout']);
// Route::any('{slug?}', [AdminUserController::class, 'index'])->where('slug', '([A-z\d\-\/_.]+)?');
Route::any('{slug?}', [AdminUserController::class, 'index']);
// Route::get('/{vue_capture?}', function () {
//     return view('app');
// })->where('vue_capture', '([A-z\d\-\/_.]+)?');
// Route::any('{slug}', [AdminUserController::class, 'index'])->where('slug', '([A-z\d\-\/_.]+)?');

// Route::get('{slug}', function () {
//     return view('app');
// })->where('slug', '.*');