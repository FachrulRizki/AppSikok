<?php

namespace App\Exports;

use App\Models\Kpc;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class KpcExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize, WithColumnWidths
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
            'Foto 1',
            'Foto 2',
            'Foto 3',
            'Foto 4',
            'Foto 5',
        ];
    }

    public function map($row): array
    {
        $this->index++;

        $fotoList = [];
        if (is_array($row->foto)) {
            foreach ($row->foto as $i => $path) {
                $url = asset('storage/' . $path);
                $fotoList[] = '=HYPERLINK("' . $url . '", "Link")';
            }
        }

        $maxFoto = 5;
        while (count($fotoList) < $maxFoto) {
            $fotoList[] = null;
        }

        return array_merge([
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
        ], $fotoList);
    }

    public function styles(Worksheet $sheet)
    {
        $lastRow = $this->data->count() + 1;

        return [
            1 => ['font' => ['bold' => true]],

            'A1:O' . $lastRow => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => '000000'],
                    ],
                ],
            ],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'H' => 40,
            'I' => 50,
            'J' => 40,
            'K' => 20,
            'L' => 20,
            'M' => 20,
            'N' => 20,
            'O' => 20,
        ];
    }
}
