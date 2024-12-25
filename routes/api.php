<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\AboutUsController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\PackageController;
use App\Http\Controllers\Api\TrainingController;
use App\Http\Controllers\Api\AdvantageController;
use App\Http\Controllers\Api\Home\WordController;
use App\Http\Controllers\Api\ParagraphController;
use App\Http\Controllers\Api\TestimonialController;
use App\Http\Controllers\Api\Home\SectionController;
use App\Http\Controllers\Api\Guide\PricingController;
use App\Http\Controllers\Api\Home\HowWeWorkController;
use App\Http\Controllers\Api\Guide\ValueAddedTaxController;
use App\Http\Controllers\Api\Home\HowWeWorkTitleController;
use App\Http\Controllers\Api\Guide\FinancialModelController;

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

Route::apiResource('clients', ClientController::class);

Route::apiResource('testimonials', TestimonialController::class);
Route::apiResource('bookings', BookingController::class);

Route::apiResource('how-we-work-titles', HowWeWorkTitleController::class)->only('index', 'store');
Route::put('how-we-work-titles', [HowWeWorkTitleController::class, 'update']);


Route::apiResource('how-we-works', HowWeWorkController::class);

Route::apiResource('words', WordController::class)->only('index', 'store');
Route::put('words', [WordController::class, 'update']);