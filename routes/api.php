<?php

use App\Http\Controllers\MapController;
use App\Models\SchoolReport;
use Illuminate\Http\Request; // <-- Pastikan 'use' ini ada
use Illuminate\Support\Facades\Route;

Route::get('/heatmap-data', [MapController::class, 'getHeatmapData']);

Route::get('/v1/schools', function () {
    $approvedSchools = SchoolReport::where('status', 'approved')
        ->select('school_name', 'province', 'regency', 'latitude', 'longitude', 'internet_access')
        ->get();

    return response()->json($approvedSchools);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
