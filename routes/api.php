<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\AboutUsController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\PackageController;
use App\Http\Controllers\Api\TrainingController;
use App\Http\Controllers\Api\AdvantageController;
use App\Http\Controllers\Api\Home\WordController;
use App\Http\Controllers\Api\ParagraphController;
use App\Http\Controllers\Api\StatisticsController;
use App\Http\Controllers\Api\TestimonialController;
use App\Http\Controllers\Api\Home\SectionController;
use App\Http\Controllers\Api\Guide\PricingController;
use App\Http\Controllers\Api\Home\HowWeWorkController;
use App\Http\Controllers\Api\Guide\ValueAddedTaxController;
use App\Http\Controllers\Api\Home\HowWeWorkTitleController;
use App\Http\Controllers\Api\Guide\FinancialModelController;
use App\Models\Blog;

Route::post('admin/login', [AuthController::class, 'login']);

// Unauthenticated GET routes
Route::get('blogs', [BlogController::class, 'index']);
Route::get('trainings', [TrainingController::class, 'index']);
Route::get('about-us', [AboutUsController::class, 'index']);
Route::get('paragraphs', [ParagraphController::class, 'index']);
Route::get('advantages', [AdvantageController::class, 'index']);
Route::get('packages', [PackageController::class, 'index']);
Route::get('financial-models', [FinancialModelController::class, 'index']);
Route::get('pricings', [PricingController::class, 'index']);
Route::get('value-added-taxes', [ValueAddedTaxController::class, 'index']);
Route::get('sections', [SectionController::class, 'index']);
Route::get('clients', [ClientController::class, 'index']);
Route::get('testimonials', [TestimonialController::class, 'index']);
Route::get('bookings', [BookingController::class, 'index']);
Route::get('how-we-work-titles', [HowWeWorkTitleController::class, 'index']);
Route::get('how-we-works', [HowWeWorkController::class, 'index']);
Route::get('words', [WordController::class, 'index']);
Route::get('statistics', [StatisticsController::class, 'index']);
Route::apiResource('bookings', BookingController::class)->except('index');

// Authenticated routes
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('blogs', BlogController::class)->except('index');
    Route::post('blogs/{blog}', [BlogController::class, 'update']);
    Route::apiResource('trainings', TrainingController::class)->except('index');
    Route::apiResource('about-us', AboutUsController::class)->except('index');
    Route::post('about-us', [AboutUsController::class, 'update']);
    Route::apiResource('paragraphs', ParagraphController::class)->except('index');
    Route::apiResource('advantages', AdvantageController::class)->except('update');
    Route::post('advantages/{advantage}', [AdvantageController::class, 'update']);
    
    Route::apiResource('packages', PackageController::class)->except('index');
    Route::apiResource('financial-models', FinancialModelController::class)->except('index');
    Route::post('financial-models', [FinancialModelController::class, 'update']);
    Route::apiResource('pricings', PricingController::class)->except('index');
    Route::post('pricings', [PricingController::class, 'update']);
    Route::apiResource('value-added-taxes', ValueAddedTaxController::class)->except('index');
    Route::post('value-added-taxes', [ValueAddedTaxController::class, 'update']);
    Route::apiResource('sections', SectionController::class)->except('index');
    Route::post('sections', [SectionController::class, 'update']);
    Route::apiResource('clients', ClientController::class)->except('index');
    Route::apiResource('testimonials', TestimonialController::class)->except('index');
    Route::apiResource('how-we-work-titles', HowWeWorkTitleController::class)->except('index');
    Route::post('how-we-work-titles', [HowWeWorkTitleController::class, 'update']);
    Route::apiResource('how-we-works', HowWeWorkController::class)->except('index');
    Route::apiResource('words', WordController::class)->except('index');
    Route::post('words', [WordController::class, 'update']);
    Route::apiResource('statistics', StatisticsController::class)->except('index');
});
