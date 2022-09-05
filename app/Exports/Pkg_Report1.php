<?php

namespace App\Exports;

use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\BeforeImport;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class Pkg_Report1 implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles, WithColumnFormatting
{
    public function collection()
    {   
        return Session::get('resultReport');
    }
    
    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('1')->getFont()->setBold(true);
        $sheet->getStyle('A1:O1')->getFill()->applyFromArray(['fillType' => 'solid','rotation' => 0, 'color' => ['rgb' => 'f2a0c9'],]);
        return [
            // Styling an entire column.
            'A:O'  => ['font' => ['size' => 9, 'name' => 'Calibri']],
        ];
    }

    public function columnFormats(): array
    {
        return [
            'D:E' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'C' => NumberFormat::FORMAT_NUMBER,
            'I' => NumberFormat::FORMAT_NUMBER,
            'J' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'K' => NumberFormat::FORMAT_NUMBER,
        ];
    }

    public function headings(): array
    {
        return [
            'No',
            'No POSTO',
            'Qty POSTO',
            'Tgl terbit POSTO',
            'Expired Date',
            'Produk',
            'No DO',
            'Load ID',
            'Qty Muat',
            'Pick Up Date',
            'Balance Qty (kg)',
            'Booking Code',
            'Nopol',
            'Tujuan',
            'Remarks',
        ];
    }

}