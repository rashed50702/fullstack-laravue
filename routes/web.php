<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TagController;
use App\Http\Controllers\CategoryController;


// Route::resources([
//     'tags' => TagController::class,
// ]);


Route::get('tag-list', [TagController::class, 'index']);
Route::post('tags', [TagController::class, 'store']);
Route::post('tag-edit', [TagController::class, 'update']);
Route::post('delete-tag', [TagController::class, 'deleteTag']);
Route::post('category-img-upload', [CategoryController::class, 'imgUpload']);
Route::post('delete-image', [CategoryController::class, 'deleteImage']);


Route::get('{slug}', function () {
    return view('app');
})->where('slug', '.*');