<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\AboutUsController;
use App\Http\Controllers\Api\PackageController;
use App\Http\Controllers\Api\TrainingController;
use App\Http\Controllers\Api\AdvantageController;
use App\Http\Controllers\Api\ParagraphController;
use App\Http\Controllers\Api\Guide\PricingController;
use App\Http\Controllers\Api\Guide\FinancialModelController;
use App\Http\Controllers\Api\Guide\ValueAddedTaxController;
use App\Http\Controllers\Api\Home\SectionController;

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

Route::apiResource('financial-models', FinancialModelController::class)->only('index', 'store');
Route::put('financial-models', [FinancialModelController::class, 'update']);

Route::apiResource('pricings', PricingController::class)->only('index', 'store');
Route::put('pricings', [PricingController::class, 'update']);

Route::apiResource('value-added-taxes', ValueAddedTaxController::class)->only('index', 'store');
Route::put('value-added-taxes', [ValueAddedTaxController::class, 'update']);

//Home page
Route::apiResource('sections', SectionController::class)->only('index', 'store');
Route::put('sections', [SectionController::class, 'update']);
