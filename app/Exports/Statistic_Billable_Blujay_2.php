<?php

namespace App\Exports;

use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\BeforeImport;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class Statistic_Billable_Blujay_2 implements WithTitle, FromCollection, ShouldAutoSize, WithStyles, WithColumnFormatting, WithHeadings
{
    public function collection()
    {   
        return Session::get('statistic_billable_blujay_2');
    }
    
    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('1')->getFont()->setBold(true);
        $sheet->getStyle('A1:B1')->getFill()->applyFromArray(['fillType' => 'solid','rotation' => 0, 'color' => ['rgb' => '99ffcc'],]);
        
        return [
            // Styling an entire column.
            'A:B'  => ['font' => ['size' => 12, 'name' => 'Calibri']],
        ];
    }

    public function columnFormats(): array
    {
        return [

        ];
    }

    public function headings(): array
    {
        return [
            'Billable Method',
            'Total Data'
        ];
    }

    public function title(): string
    {
        return 'Undefined Customers';
    }
}