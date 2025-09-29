<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use App\Models\SchoolReport;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MapController extends Controller
{
    public function index()
    {
        return Inertia::render('Map/Index');
    }

    public function getHeatmapData()
    {
        /**
         * =================================================================
         * BAGIAN DATA DUMMY (SEMENTARA)
         * =================================================================
         * Ini akan selalu mengirimkan data contoh ke frontend,
         * mengabaikan apa yang ada di database.
         * Hapus atau beri komentar pada blok ini jika Anda sudah siap
         * menggunakan data asli dari database.
         */

        $dummyHeatmapPoints = [
            // [latitude, longitude, intensity]
            [5.558, 95.322, 0.5], // Banda Aceh, intensitas rendah
            [5.383, 95.960, 1.0], // Sigli, intensitas tinggi
            [5.890, 95.320, 0.8], // Sabang, intensitas sedang-tinggi
            [4.635, 95.598, 1.0], // Calang, intensitas tinggi
            [5.178, 97.150, 0.4], // Lhokseumawe, intensitas rendah
        ];

        return response()->json($dummyHeatmapPoints);


        /**
         * =================================================================
         * BAGIAN DATA ASLI (DARI DATABASE)
         * =================================================================
         * Kode di bawah ini adalah kode yang akan Anda gunakan nanti
         * jika sudah memiliki data di database.
         */
        
        /*
        $approvedReports = SchoolReport::where('status', 'approved')
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get();

        if ($approvedReports->isEmpty()) {
            return response()->json([]);
        }

        $heatmapPoints = $approvedReports->map(function ($report) {
            $intensity = 0.5;
            if ($report->internet_access === 'terbatas') $intensity += 0.2;
            if ($report->internet_access === 'tidak_tersedia') $intensity += 0.5;
            if ($report->teacher_count > 0) {
                $ratio = $report->student_count / $report->teacher_count;
                if ($ratio > 20) $intensity += 0.3;
            }
            return [(float)$report->latitude, (float)$report->longitude, $intensity];
        });

        return response()->json($heatmapPoints);
        */
    }
}