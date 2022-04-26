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

class Smart_Report2 implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles, WithColumnFormatting
{
    public function collection()
    {   
        return Session::get('resultReport');
    }
    
    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('1')->getFont()->setBold(true);
        $sheet->getStyle('A1:Y1')->getFill()->applyFromArray(['fillType' => 'solid','rotation' => 0, 'color' => ['rgb' => '63cdcf'],]);

        return [
            // Styling an entire column.
            'A:Z'  => ['font' => ['size' => 12]],
        ];
    }

    public function columnFormats(): array
    {
        return [
            'D:E' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'H' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'J:K' => NumberFormat::FORMAT_NUMBER_00,
            'R:T' => NumberFormat::FORMAT_NUMBER_00,
            'W:X' => NumberFormat::FORMAT_NUMBER,
            'Y' => NumberFormat::FORMAT_NUMBER_00,
        ];
    }

    public function headings(): array
    {
        return [
            'No',
            'No SJ',
            'No DO',
            'Tanggal Input',
            'Update Terakhir',
            'Load ID',
            'Customer Type',
            'Tgl Muat',
            'Penerima',
            'Kuantitas',
            'Berat',
            'Utilitas',
            'City Routes',
            'Nopol',
            'Driver',
            'Tipe Kendaraan',
            'Kontainer',
            'Biaya Bongkar',
            'Overnight Charge',
            'Multidrop',
            'Kode SKU',
            'Deskripsi',
            'Qty',
            'Retur',
            'Subtotal Weight',
        ];
    }

}