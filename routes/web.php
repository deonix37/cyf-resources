<?php

use App\Http\Controllers\HelpSubjectController;
use App\Http\Controllers\ResourceController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes(['verify' => true]);

Route::get('', [ResourceController::class, 'index'])->name('resources.index');
Route::patch(
    'resources/{resource}/status',
    [ResourceController::class, 'updateStatus'],
)->name('resources.updateStatus');
Route::resource('resources', ResourceController::class, ['except' => 'index']);

Route::get('help', HelpSubjectController::class)->name('help');
