<?php

use App\Http\Middleware\AdminCheck;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TagController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\RoleController;

Route::prefix("admin")->middleware([AdminCheck::class])->group(function(){

    Route::controller(TagController::class)->group(function () {
        Route::get('tag-list', 'index');
        Route::post('tags', 'store');
        Route::post('tag-edit', 'update');
        Route::post('delete-tag', 'deleteTag');
    });


    Route::controller(CategoryController::class)->group(function () {
        Route::post('category-img-upload', 'imgUpload');
        Route::post('delete-image', 'deleteImage');
        Route::post('category-save', 'store');
        Route::post('category-update', 'update');
        Route::get('categories-list', 'index');
        Route::post('delete-category', 'destroy');
    });

    Route::controller(AdminUserController::class)->group(function () {
        Route::get('admin-user-list', 'adminUserList');
        Route::post('save-admin-user', 'store');
        Route::post('update-admin-user', 'update');
        
    });

    Route::controller(RoleController::class)->group(function () {
        Route::get('role-list', 'index');
        Route::post('save-role', 'store');
        Route::post('update-role', 'update');
        Route::post('delete-role', 'delete');
        Route::post('saving-permissions', 'savingPermissions');
    });

});