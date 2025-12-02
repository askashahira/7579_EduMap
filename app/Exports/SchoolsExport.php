<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SchoolsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        // Nanti, ini akan diganti dengan query database
        return new Collection([
            [1, 'SDN 1 Banda Aceh', '1:12'],
            [2, 'SDN 5 Meuraxa', '1:15'],
            [3, 'SDN 10 Lhoknga', '1:20'],
        ]);
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama Sekolah',
            'Rasio Guru-Murid',
        ];
    }
}
