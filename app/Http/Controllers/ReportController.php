<?php

namespace App\Http\Controllers;

use App\Exports\SchoolsExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function exportPdf(Request $request)
    {
        // 1. Ambil data (simulasi)
        $data = [
            'title' => 'Laporan Ketimpangan Pendidikan',
            'date' => date('d F Y'),
            'schools' => [
                ['id' => 1, 'name' => 'SDN 1 Banda Aceh', 'ratio' => '1:12'],
                ['id' => 2, 'name' => 'SDN 5 Meuraxa', 'ratio' => '1:15'],
            ],
        ];

        // 2. Load view dan data ke dalam PDF
        $pdf = PDF::loadView('reports.school', $data);

        // 3. PERBAIKAN: Gunakan metode streaming dari Laravel
        $fileName = 'laporan-edumap-'.date('Y-m-d').'.pdf';

        return response()->streamDownload(
            fn () => print ($pdf->output()),
            $fileName
        );
    }

    public function exportCsv(Request $request)
    {
        // 1. Siapkan nama file
        $fileName = 'data-sekolah-edumap-'.date('Y-m-d').'.xlsx';

        // 2. PERBAIKAN: Gunakan metode streaming dari Laravel
        return response()->streamDownload(
            fn () => print (Excel::raw(new SchoolsExport, \Maatwebsite\Excel\Excel::XLSX)),
            $fileName
        );
    }
}
