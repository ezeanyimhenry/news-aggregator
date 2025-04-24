<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/files', function () {
    $files = \Illuminate\Support\Facades\Storage::disk('public')->files('custom');
    dd($files);
});