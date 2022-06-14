<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TagController;


// Route::resources([
//     'tags' => TagController::class,
// ]);


Route::get('tag-list', [TagController::class, 'index']);
Route::post('tags', [TagController::class, 'store']);
Route::post('tag-edit', [TagController::class, 'update']);
Route::post('delete-tag', [TagController::class, 'deleteTag']);
Route::get('{slug}', function () {
    return view('app');
})->where('slug', '.*');