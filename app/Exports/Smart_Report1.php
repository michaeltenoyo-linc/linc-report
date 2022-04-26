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

class Smart_Report1 implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles, WithColumnFormatting
{
    public function collection()
    {   
        return Session::get('resultReport');
    }
    
    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('1')->getFont()->setBold(true);

        return [
            // Styling an entire column.
            'A:Z'  => ['font' => ['size' => 9, 'name' => 'Calibri']],
        ];
    }

    public function columnFormats(): array
    {
        return [
            'D' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'K:M' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'Q:U' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
        ];
    }

    public function headings(): array
    {
        return [
            'No',
            'Load ID',
            'Customer Type',
            'Tgl Muat',
            'No SJ Smart',
            'No DO SDN',
            'Penerima',
            'Lokasi Tujuan',
            'Provinsi Tujuan',
            'Kota Tujuan',
            'Kuantitas',
            'Berat',
            'Utilitas',
            'Nopol',
            'Tipe Kendaraan',
            'Kontainer',
            'Biaya Kirim',
            'Biaya Bongkar',
            'Overnight Charge',
            'Multidrop',
            'Total',
            'Kode SKU',
            'Deskripsi',
            'Qty',
            'Item Weight',
            'Subtotal Weight'
        ];
    }

}