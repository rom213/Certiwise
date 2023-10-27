<?php

use App\Http\Controllers\CertificateController;
use App\Http\Controllers\EmailHeaderController;
use App\Http\Controllers\EmailStyleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')->group(function () {
    Route::middleware(['auth:sanctum'])->group(function() {
        Route::get('/user', function (Request $request) {
            $user = $request->user();
            $user->tenants = $user->tenants()->get();
            return $user;
        });

        /** ============ Emails ============ */
        Route::prefix('emails')->group(function() {
            Route::get('/styles', [EmailStyleController::class, 'index']);
            Route::get('/headers', [EmailHeaderController::class, 'index']);
        });
    });
    /** ============ Certificates ============ */
    // id from pivot table
    Route::get('certificates/{id}', [CertificateController::class, 'show']);
});
