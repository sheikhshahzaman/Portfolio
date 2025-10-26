<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\PortfolioController;
use App\Http\Controllers\API\ContactController;

// Public Portfolio Routes
Route::prefix('portfolio')->group(function () {
    Route::get('/', [PortfolioController::class, 'index']);
    Route::get('/projects', [PortfolioController::class, 'projects']);
    Route::get('/projects/{slug}', [PortfolioController::class, 'project']);
    Route::get('/experiences', [PortfolioController::class, 'experiences']);
    Route::get('/skills', [PortfolioController::class, 'skills']);
    Route::get('/services', [PortfolioController::class, 'services']);
    Route::get('/blog', [PortfolioController::class, 'blog']);
    Route::get('/blog/{slug}', [PortfolioController::class, 'blogPost']);
});

// Languages Route
Route::get('/languages', [PortfolioController::class, 'languages']);

// Translation Keys Route
Route::get('/translations', [PortfolioController::class, 'translations']);

// Contact Route
Route::post('/contact', [ContactController::class, 'store']);

// Authenticated Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});
