
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\FlowerSampleController;
use App\Http\Controllers\Api\TreatmentRecommendationController;

// Public API test
Route::get('/flower-doctor', function () {
    return response()->json([
        'success' => true,
        'message' => 'Welcome to Flower Doctor API!',
        'status' => 'API is working',
    ]);
});

// Public authentication APIs
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Public treatment recommendation APIs
Route::get(
    '/treatment-recommendations',
    [TreatmentRecommendationController::class, 'index']
);

Route::get(
    '/treatment-recommendations/{id}',
    [TreatmentRecommendationController::class, 'show']
);

// Login required
Route::middleware('auth:sanctum')->group(function () {

    Route::get('/user', function (Request $request) {
        return response()->json([
            'success' => true,
            'data' => $request->user(),
        ]);
    });

    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Admin only: create, update and delete recommendations
    Route::middleware('role:admin')->group(function () {

        Route::post(
            '/treatment-recommendations',
            [TreatmentRecommendationController::class, 'store']
        );

        Route::put(
            '/treatment-recommendations/{id}',
            [TreatmentRecommendationController::class, 'update']
        );

        Route::patch(
            '/treatment-recommendations/{id}',
            [TreatmentRecommendationController::class, 'update']
        );

        Route::delete(
            '/treatment-recommendations/{id}',
            [TreatmentRecommendationController::class, 'destroy']
        );
    });

    // Farmer and admin can access flower APIs
    Route::middleware('role:farmer,admin')->group(function () {

        Route::get(
            '/flower-samples',
            [FlowerSampleController::class, 'index']
        );

        Route::get(
            '/flower-samples/{id}',
            [FlowerSampleController::class, 'show']
        );

        Route::post(
            '/flower-samples',
            [FlowerSampleController::class, 'store']
        );

        Route::put(
            '/flower-samples/{id}',
            [FlowerSampleController::class, 'update']
        );

        Route::patch(
            '/flower-samples/{id}',
            [FlowerSampleController::class, 'update']
        );

        Route::delete(
            '/flower-samples/{id}',
            [FlowerSampleController::class, 'destroy']
        );

        Route::post(
            '/flower-doctor/upload-image',
            [FlowerSampleController::class, 'uploadImage']
        );
    });
});
