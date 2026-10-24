
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\FlowerController;
use App\Http\Controllers\Api\FlowerSampleController;
use App\Http\Controllers\Api\TreatmentRecommendationController;
use App\Http\Controllers\Api\FlowerClassificationController;

/*
|--------------------------------------------------------------------------
| Public API Routes
|--------------------------------------------------------------------------
*/

// API welcome route
Route::get('/flower-doctor', function () {
    return response()->json([
        'success' => true,
        'message' => 'Welcome to Flower Doctor API!',
        'status' => 'API is working',
    ]);
});

// Authentication
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Flower information - public read access
Route::get('/flowers', [FlowerController::class, 'index']);
Route::get('/flowers/{id}', [FlowerController::class, 'show']);

// Treatment recommendations - public read access
Route::get(
    '/treatment-recommendations',
    [TreatmentRecommendationController::class, 'index']
);

Route::get(
    '/treatment-recommendations/{id}',
    [TreatmentRecommendationController::class, 'show']
);

// AI flower classification
Route::post(
    '/classify-flower',
    [FlowerClassificationController::class, 'predict']
);

/*
|--------------------------------------------------------------------------
| Authenticated API Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function () {

    // Current logged-in user
    Route::get('/user', function (Request $request) {
        return response()->json([
            'success' => true,
            'data' => $request->user(),
        ]);
    });

    // User profile
    Route::get('/profile', [AuthController::class, 'profile']);

    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);

    /*
    |--------------------------------------------------------------------------
    | Admin-only Routes
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:admin')->group(function () {

        // Flower information management
        Route::post('/flowers', [FlowerController::class, 'store']);
        Route::put('/flowers/{id}', [FlowerController::class, 'update']);
        Route::patch('/flowers/{id}', [FlowerController::class, 'update']);
        Route::delete('/flowers/{id}', [FlowerController::class, 'destroy']);

        // Treatment recommendation management
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

    /*
    |--------------------------------------------------------------------------
    | Farmer and Admin Routes
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:farmer,admin')->group(function () {

        // Flower sample management
        Route::get('/flower-samples', [FlowerSampleController::class, 'index']);
        Route::get('/flower-samples/{id}', [FlowerSampleController::class, 'show']);
        Route::post('/flower-samples', [FlowerSampleController::class, 'store']);
        Route::put('/flower-samples/{id}', [FlowerSampleController::class, 'update']);
        Route::patch('/flower-samples/{id}', [FlowerSampleController::class, 'update']);
        Route::delete('/flower-samples/{id}', [FlowerSampleController::class, 'destroy']);

        // Flower image upload
        Route::post(
            '/flower-doctor/upload-image',
            [FlowerSampleController::class, 'uploadImage']
        );
    });
});
