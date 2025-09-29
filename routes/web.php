<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReportFormController; 
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return Inertia::render('Welcome'); // Kita akan buat file Welcome.vue
})->name('home');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
// Tambahkan grup rute ini di dalam grup middleware 'auth'
Route::middleware('admin')->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::patch('/admin/reports/{report}', [AdminController::class, 'updateStatus'])->name('admin.report.update');
});

Route::get('/peta', [MapController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('map.index');

Route::get('/tentang-kami', function () {
    return Inertia::render('AboutUs');
})->name('about.us');
    
Route::get('/report/pdf', [ReportController::class, 'exportPdf'])->name('report.pdf');
Route::get('/report/csv', [ReportController::class, 'exportCsv'])->name('report.csv');

Route::get('/lapor-data', [ReportFormController::class, 'create'])->name('report.create');
Route::post('/lapor-data', [ReportFormController::class, 'store'])->name('report.store');

require __DIR__.'/auth.php';
