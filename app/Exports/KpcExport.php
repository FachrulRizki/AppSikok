<?php

namespace App\Exports;

use App\Models\Kpc;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class KpcExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $data;
    protected $index = 0;

    public function __construct($data)
    {
        $this->data = $data;
    }
    
    public function collection(): Collection
    {
        return $this->data;
    }

    public function headings(): array
    {
        return [
            'No',
            'Tanggal & Waktu Kejadian',
            'Sumber',
            'Unit Terkait',
            'Ruangan Pelapor',
            'Pelaksana',
            'Nama Inisial Pelapor',
            'Temuan',
            'Kronologis',
            'Tindakan',
        ];
    }

    public function map($row): array
    {
        $this->index++;

        return [
            $this->index,
            $row->waktu->format('d-m-Y, H:i'),
            $row->sumber,
            $row->unit_terkait,
            $row->ruangan,
            $row->pelaksana,
            $row->nama_inisial,
            $row->temuan,
            $row->kronologis,
            $row->tindakan,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $lastRow = $this->data->count() + 1;

        return [
            1 => ['font' => ['bold' => true]],

            'A1:J' . $lastRow => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => '000000'],
                    ],
                ],
            ],
        ];
    }
}
