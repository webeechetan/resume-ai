<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ResumeController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/resume', [ResumeController::class, 'index'])->name('resume');
Route::post('/resume', [ResumeController::class, 'store'])->name('resume.store');
