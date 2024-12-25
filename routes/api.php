<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\AboutUsController;
use App\Http\Controllers\Api\PackageController;
use App\Http\Controllers\Api\TrainingController;
use App\Http\Controllers\Api\AdvantageController;
use App\Http\Controllers\Api\ParagraphController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('blogs', BlogController::class);
Route::apiResource('trainings', TrainingController::class);
Route::apiResource('about-us', AboutUsController::class)->only('index', 'store');
Route::put('about-us', [AboutUsController::class, 'update']);
Route::apiResource('paragraphs', ParagraphController::class)->only('store', 'update', 'destroy');
Route::apiResource('advantages', AdvantageController::class);
Route::apiResource('packages', PackageController::class);