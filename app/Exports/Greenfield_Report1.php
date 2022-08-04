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

class Greenfield_Report1 implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles, WithColumnFormatting
{
    public function collection()
    {   
        return Session::get('resultReport');
    }
    
    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('1')->getFont()->setBold(true);
        $sheet->getStyle('A1:G1')->getFill()->applyFromArray(['fillType' => 'solid','rotation' => 0, 'color' => ['rgb' => '99ffcc'],]);
        $sheet->getStyle('I1:M1')->getFill()->applyFromArray(['fillType' => 'solid','rotation' => 0, 'color' => ['rgb' => '99ffcc'],]);
        $sheet->getStyle('N1')->getFill()->applyFromArray(['fillType' => 'solid','rotation' => 0, 'color' => ['rgb' => '00ff00'],]);
        $sheet->getStyle('H1')->getFill()->applyFromArray(['fillType' => 'solid','rotation' => 0, 'color' => ['rgb' => '00ff00'],]);

        return [
            // Styling an entire column.
            'A:O'  => ['font' => ['size' => 9, 'name' => 'Calibri']],
        ];
    }

    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'E' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'I:M' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
        ];
    }

    public function headings(): array
    {
        return [
            'No.',
            'Order Date',
            'No Order',
            'Area',
            'Quantity',
            'Pol. No',
            'Truck Type',
            'Destination',
            'Rate',
            'Other',
            'Multi Drop',
            'Un-Loading',
            'Total Invoices',
            'REMARKS',
            'Load ID',
        ];
    }

}