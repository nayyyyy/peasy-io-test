<?php

declare(strict_types=1);

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Profile\ProfileController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Api\Admin\DailyRecord\BrowseDailyRecordController;
use App\Http\Controllers\Api\Admin\Profile\BrowseProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', fn () => redirect()->route('admin.dashboard.index'));

Route::prefix('admin')->as('admin.')->group(function (): void {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('report', [ReportController::class, 'index'])->name('report.index');

    Route::prefix('profiles')->as('profiles.')->group(function (): void {
        Route::delete('{id}', [ProfileController::class, 'destroy'])->name('destroy');
    });
});

Route::prefix('api')->as('api.')->group(function (): void {
    Route::prefix('profiles')->as('profiles.')->group(function (): void {
        Route::get('datatable', BrowseProfileController::class)->name('datatable');
    });

    Route::prefix('daily-records')->as('daily-records.')->group(function (): void {
        Route::get('datatable', BrowseDailyRecordController::class)->name('datatable');
    });
});
