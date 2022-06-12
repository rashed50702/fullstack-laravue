<?php

use Illuminate\Support\Facades\Route;

Route::get('{slug}', function () {
    return view('app');
})->where('slug', '.*');