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
Route::post('category-save', [CategoryController::class, 'store']);
Route::post('category-update', [CategoryController::class, 'update']);
Route::get('categories-list', [CategoryController::class, 'index']);


Route::get('{slug}', function () {
    return view('app');
})->where('slug', '.*');