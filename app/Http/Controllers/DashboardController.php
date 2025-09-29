<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
// Pastikan model SchoolReport di-import jika Anda ingin menggunakannya nanti
use App\Models\SchoolReport;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil filter dari URL.
        $selectedRegencyId = $request->input('regency_id');
        $selectedVillageId = $request->input('village_id');
        $timeFilter = $request->input('time_filter');

        // 2. Siapkan data default (jika tidak ada filter)
        $dashboardData = [
            'schoolCount' => 32457,
            'teacherStudentRatio' => '1:16',
            'internetAccess' => 78,
            'dropoutRate' => 2.1,
            'barChartData' => [14, 18, 15, 22, 12],
            'pieChartData' => [78, 22],
        ];

        // 3. SIMULASI: Jika ada filter, ganti data dengan data yang relevan
        // Nanti, bagian ini akan diganti dengan query database asli
        if ($selectedRegencyId) {
            $dashboardData = [
                'schoolCount' => 1250,
                'teacherStudentRatio' => '1:14',
                'internetAccess' => 85,
                'dropoutRate' => 1.8,
                'barChartData' => [15, 19, 16, 23, 13], // Data baru
                'pieChartData' => [85, 15],             // Data baru
            ];
        }
        
        if ($selectedVillageId) {
            $dashboardData = [
                'schoolCount' => 8,
                'teacherStudentRatio' => '1:12',
                'internetAccess' => 95,
                'dropoutRate' => 0.5,
                'barChartData' => [12, 13, 11, 14, 10], // Data lebih baru lagi
                'pieChartData' => [95, 5],              // Data lebih baru lagi
            ];
        }

        // Logika untuk rekomendasi dengan data contoh yang lebih baik
        $allReports = collect([
            ['id' => 1, 'school_name' => 'SDN 1 Pulo Aceh', 'regency' => 'Aceh Besar', 'internet_access' => 'tidak_tersedia', 'student_count' => 80, 'teacher_count' => 4], // Rasio 1:20
            ['id' => 2, 'school_name' => 'SDN 2 Tangse', 'regency' => 'Pidie', 'internet_access' => 'terbatas', 'student_count' => 150, 'teacher_count' => 6], // Rasio 1:25
            ['id' => 3, 'school_name' => 'SDN 5 Meulaboh', 'regency' => 'Aceh Barat', 'internet_access' => 'stabil', 'student_count' => 250, 'teacher_count' => 15],
            ['id' => 4, 'school_name' => 'SDN 3 Simpang Kiri', 'regency' => 'Subulussalam', 'internet_access' => 'terbatas', 'student_count' => 120, 'teacher_count' => 5], // Rasio 1:24
            ['id' => 5, 'school_name' => 'SDN 1 Banda Aceh', 'regency' => 'Kota Banda Aceh', 'internet_access' => 'stabil', 'student_count' => 300, 'teacher_count' => 20],
            ['id' => 6, 'school_name' => 'SDN 1 Geumpang', 'regency' => 'Pidie', 'internet_access' => 'tidak_tersedia', 'student_count' => 90, 'teacher_count' => 3], // Rasio 1:30
        ]);

        $prioritySchools = $allReports->map(function ($report) {
            $score = 0;
            if ($report['internet_access'] === 'terbatas') $score += 2;
            if ($report['internet_access'] === 'tidak_tersedia') $score += 5;
            if ($report['teacher_count'] > 0) {
                $ratio = $report['student_count'] / $report['teacher_count'];
                if ($ratio > 20) $score += ($ratio - 20) / 2; // Dibagi 2 agar skor lebih halus
            }
            $report['score'] = $score;
            return $report;
        })
        ->sortByDesc('score')
        ->take(5)
        ->values(); // Reset keys agar menjadi array biasa

        // 4. Kirim semua data ke komponen Vue sebagai props
        return Inertia::render('Dashboard', [
            'dashboardData' => $dashboardData,
            'filters' => $request->only(['regency_id', 'village_id', 'time_filter']),
            'prioritySchools' => $prioritySchools,
        ]);
    }
}