<?php

use App\Http\Controllers\Api\authController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\stepController;
use App\Http\Controllers\Api\settingController;
use App\Http\Controllers\Api\employeeController;
use App\Http\Controllers\Api\excelleController;
use App\Http\Controllers\Api\jobController;
use App\Http\Controllers\Api\rapportController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::prefix('job')->group(function () {
    Route::controller(jobController::class)->group(function () {
        Route::group(['middleware' => ['auth:sanctum']], function () {
                Route::post('/create-update', 'createOrUpdate');
                Route::get('/all', 'all');
                Route::get('/find/{uuid}', 'find');
        });
    });
});

Route::prefix('employee')->group(function () {
    Route::controller(employeeController::class)->group(function () {
        Route::post('/create/draft', 'createDraft');
        Route::get('/find/by-link/{identifier}', 'findByLink');
        Route::post('/update/draft', 'update');
        Route::group(['middleware' => ['auth:sanctum']], function () {
            Route::post('/create', 'create');
            Route::get('/approuve/draft/{uuid}', 'ApprouveEmployeDraft');
            Route::get('/duplicate/contract/{uuid}', 'duplicateEmployeeContract');
            Route::get('/get/one/{id}', 'getUser');
            Route::post('/update/by-link', 'updateByLink');
            Route::get('/find/{identifier}', 'find');
            Route::get('/all', 'getAll');
            Route::get('/all/draft', 'getAllDraft');
            Route::post('/update', 'update');
            Route::get('/delete/{id}/{uid}', 'delete');
            Route::post('/payroll/create-update', 'createOrUpdatePayroll');
            Route::post('/contract/create-update', 'createOrUpdateContract');
        });
    });
});




Route::prefix('setting')->group(function () {
    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::controller(settingController::class)->group(function () {
            Route::post('/create', 'create');
            Route::post('/update/step', 'updateStep');
            Route::post('/update/setting', 'updateSetting');
            Route::get('/get/setting', 'getSettingAll');
            Route::get('/get/step', 'getStepAll');
            Route::get('/delete/{id}/{uid}', 'delete');
        });
    });
});

Route::prefix('step')->group(function () {
    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::controller(stepController::class)->group(function () {
            Route::post('/create', 'create');
            Route::post('/update', 'update');
            Route::get('/all', 'getAll');
            Route::get('/delete/{id}/{uid}', 'delete');
        });
    });
});


Route::prefix('rapport')->group(function () {
    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::controller(rapportController::class)->group(function () {
            Route::post('/create', 'create');
            Route::post('/update', 'update');
            Route::get('/staff', 'getRapportStaff');
            Route::get('/delete/{id}/{uid}', 'delete');
            Route::get('/export/employee/{q?}/{date?}', 'exportEmployee');
        });
    });
});


Route::prefix('auth')->group(function () {
    Route::controller(authController::class)->group(function () {
        Route::post('/login', 'login');
        Route::group(['middleware' => ['auth:sanctum']], function () {
            Route::get('/logout', 'logout');
        });
    });
});
