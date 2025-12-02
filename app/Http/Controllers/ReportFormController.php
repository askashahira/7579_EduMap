<?php

namespace App\Http\Controllers;

use App\Models\SchoolReport;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ReportFormController extends Controller
{
    /**
     * Menampilkan halaman formulir input data.
     */
    public function create()
    {
        return Inertia::render('Report/Create');
    }

    /**
     * Menyimpan laporan baru ke database.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'school_name' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'regency' => 'required|string|max:255',
            'teacher_count' => 'required|integer|min:0',
            'student_count' => 'required|integer|min:0',
            'internet_access' => 'required|string|in:stabil,terbatas,tidak_tersedia',
            'report_date' => 'required|date',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        $validatedData['user_id'] = Auth::id();

        SchoolReport::create($validatedData);

        return redirect()->route('report.create')->with('success', 'Data berhasil dikirim dan sedang menunggu verifikasi.');
    }
}
