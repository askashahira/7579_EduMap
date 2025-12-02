<?php

namespace App\Http\Controllers;

use App\Models\SchoolReport;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Inertia\Inertia;

class AdminController extends Controller
{
    public function index()
    {
        // Ambil semua laporan yang masih pending
        $pendingReports = SchoolReport::where('status', 'pending')->latest()->paginate(10);

        return Inertia::render('Admin/Index', [
            'reports' => $pendingReports,
        ]);
    }

    public function updateStatus(Request $request, SchoolReport $report)
    {
        $request->validate(['status' => 'required|in:approved,rejected']);

        $report->update(['status' => $request->status]);

        return back()->with('success', 'Status laporan berhasil diperbarui.');
    }
}
