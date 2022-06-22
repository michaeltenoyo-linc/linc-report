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

class Smart_Report3 implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles, WithColumnFormatting
{
    public function collection()
    {   
        return Session::get('resultReport');
    }
    
    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('1')->getFont()->setBold(true);
        //Green Muntah
        $sheet->getStyle('A1')->getFill()->applyFromArray(['fillType' => 'solid','rotation' => 0, 'color' => ['rgb' => 'c2d69b'],]);
        $sheet->getStyle('D1:E1')->getFill()->applyFromArray(['fillType' => 'solid','rotation' => 0, 'color' => ['rgb' => 'c2d69b'],]);
        $sheet->getStyle('L1')->getFill()->applyFromArray(['fillType' => 'solid','rotation' => 0, 'color' => ['rgb' => 'c2d69b'],]);
        $sheet->getStyle('O1:T1')->getFill()->applyFromArray(['fillType' => 'solid','rotation' => 0, 'color' => ['rgb' => 'c2d69b'],]);
        $sheet->getStyle('G1:I1')->getFill()->applyFromArray(['fillType' => 'solid','rotation' => 0, 'color' => ['rgb' => 'c2d69b'],]);
        //White
        $sheet->getStyle('B1')->getFill()->applyFromArray(['fillType' => 'solid','rotation' => 0, 'color' => ['rgb' => 'ffffff'],]);
        //Yellow
        $sheet->getStyle('C1')->getFill()->applyFromArray(['fillType' => 'solid','rotation' => 0, 'color' => ['rgb' => 'ffff00'],]);
        $sheet->getStyle('F1')->getFill()->applyFromArray(['fillType' => 'solid','rotation' => 0, 'color' => ['rgb' => 'ffff00'],]);
        $sheet->getStyle('J1:K1')->getFill()->applyFromArray(['fillType' => 'solid','rotation' => 0, 'color' => ['rgb' => 'ffff00'],]);
        $sheet->getStyle('M1:N1')->getFill()->applyFromArray(['fillType' => 'solid','rotation' => 0, 'color' => ['rgb' => 'ffff00'],]);
        

        return [
            // Styling an entire column.
            'A:Z'  => ['font' => ['size' => 10, 'name' => 'Calibri']],
        ];
    }

    public function columnFormats(): array
    {
        return [
            'C' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'L' => NumberFormat::FORMAT_NUMBER,
            'O:T' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
        ];
    }

    public function headings(): array
    {
        return [
            'No',
            'Load ID',
            'TANGGAL MUAT',
            'No DO',
            'No SJ',
            'CUSTOMER',
            'ID STOP LOCATION',
            'PROVINSI TUJUAN',
            'KOTA TUJUAN',
            'SKU',
            'DESCRIPTION',
            'QTY',
            'NOPOL',
            'TIPE KENDARAAN',
            'BIAYA TRUKING',
            'BIAYA BONGKAR',
            'BIAYA MULTIDROP',
            'BIAYA STAPEL/INAP',
            'BIAYA LAIN-LAIN',
            'TOTAL',
            'CUST TYPE'
        ];
    }

}