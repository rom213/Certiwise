<?php

declare(strict_types=1);

use App\Http\Controllers\CollectionController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\RecipientController;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use Stancl\Tenancy\Middleware\InitializeTenancyByPath;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

/*Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    Route::get('/', function () {
        dd(\App\Models\User::all());
        return 'This is your multi-tenant application. The id of the current tenant is ' . tenant('id');
    });
});*/

Route::prefix('api/v1')->middleware(['api', ])->group(function () {
    Route::prefix('{tenant}')->middleware(['auth:sanctum', InitializeTenancyByPath::class, 'check.tenant.authorization'])->group(function () {
        /** ============ Collections ============ */
        Route::apiResource('collections', CollectionController::class);
        Route::prefix('collections')->group(function() {
            Route::get('/{id}/events', [CollectionController::class, 'events']);
            Route::post('/{id}/events', [CollectionController::class, 'addEvent']);
        });

        /** ============ Events ============ */
        Route::apiResource('events', EventController::class);
        Route::prefix('events')->group(function() {
            Route::get('{id}/images', [EventController::class, 'images']);
            Route::post('{id}/images', [EventController::class, 'addImage']);
            Route::delete('{id}/images/{imageId}', [EventController::class, 'deleteImage']);
            Route::get('{id}/certificates', [EventController::class, 'certificate']);
            Route::post('{id}/certificates', [EventController::class, 'updateOrCreateCertificate']);
            Route::get('{id}/pages', [EventController::class, 'viewPage']);
            Route::post('{id}/pages', [EventController::class, 'updateOrCreateViewPage']);
            Route::get('{id}/recipients', [EventController::class, 'recipients']);
            Route::post('{id}/recipients', [EventController::class, 'addRecipients']);
            Route::get('{id}/emails', [EventController::class, 'email']);
            Route::post('{id}/emails', [EventController::class, 'updateOrCreateEmail']);
        });

        /** ============ Recipients ============ */
        Route::apiResource('recipients', RecipientController::class)->only(['index', 'show']);
    });

});

