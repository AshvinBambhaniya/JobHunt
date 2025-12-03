<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobApplicationController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', function () {
    return redirect()->route('job-applications.index');
});

// This single line creates all routes: index, create, store, edit, update, destroy
Route::resource('job-applications', JobApplicationController::class);