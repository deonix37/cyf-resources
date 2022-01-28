<?php

use App\Http\Controllers\Api\ResourceUpvoteController;
use Illuminate\Support\Facades\Route;

Route::middleware('verified:sanctum')->group(function () {
    Route::apiResource(
        'resources.upvotes',
        ResourceUpvoteController::class,
    )->shallow();
});
