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

class Sales_ReportCustomerPerformance implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles, WithColumnFormatting
{
    public function collection()
    {   
        return Session::get('resultReport');
    }
    
    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('1')->getFont()->setBold(true);
        $sheet->getStyle('A1:H1')->getFill()->applyFromArray(['fillType' => 'solid','rotation' => 0, 'color' => ['rgb' => '00f2ff'],]);
        return [
            // Styling an entire column.
            'A:H'  => ['font' => ['size' => 9, 'name' => 'Calibri']],
        ];
    }

    public function columnFormats(): array
    {
        return [
            'E:G' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'H' => NumberFormat::FORMAT_PERCENTAGE_00,
        ];
    }

    public function headings(): array
    {
        return [
            'No',
            'Customer Reference',
            'Customer Name',
            'Total Loads',
            'Billable',
            'Payable',
            'Profit',
            'Margin'
        ];
    }

}