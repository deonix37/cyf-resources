<?php

use App\Http\Controllers\Api\ResourceController;
use App\Http\Controllers\Api\ResourceUpvoteController;
use Illuminate\Support\Facades\Route;

Route::middleware('verified:sanctum')->group(function () {
    Route::apiResource(
        'resources.upvotes',
        ResourceUpvoteController::class,
        ['except' => 'update'],
    )->shallow();
});

Route::apiResource('resources', ResourceController::class);
