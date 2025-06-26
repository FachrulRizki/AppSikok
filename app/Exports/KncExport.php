<?php

namespace App\Exports;

use App\Models\Knc;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class KncExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize, WithColumnWidths
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
            'No. RM',
            'Nama Pasien',
            'Umur',
            'Jenis Kelamin',
            'Waktu Masuk RS',
            'Waktu Insiden',
            'Temuan',
            'Kronologis',
            'Tindakan Segera',
            'Insiden Pada',
            'Unit Terkait',
            'Sumber Informasi',
            'Menyangkut Pasien',
            'Terjadi Pada Pasien',
            'Pelaksana',
            'Nama Inisial Pelapor',
            'Ruangan Pelapor',
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
            $row->no_rm,
            $row->nama_pasien,
            $row->umur,
            $row->jk,
            $row->waktu_mskrs->format('d-m-Y, H:i'),
            $row->waktu_insiden->format('d-m-Y, H:i'),
            $row->temuan,
            $row->kronologis,
            $row->tindakan_segera,
            $row->insiden_pada,
            $row->unit_terkait,
            $row->sumber,
            $row->rawat,
            $row->poli,
            $row->pelaksana,
            $row->nama_inisial,
            $row->ruangan_pelapor
        ], $fotoList);
    }

    public function styles(Worksheet $sheet)
    {
        $lastRow = $this->data->count() + 1;

        return [
            1 => ['font' => ['bold' => true]],

            'A1:W' . $lastRow => [
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
            'I' => 40,
            'J' => 40,
            'L' => 40,
        ];
    }
}
