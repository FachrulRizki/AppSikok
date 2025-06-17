<?php

namespace App\Exports;

use App\Models\Ktd;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class KtdExport implements FromCollection, WithHeadings, WithMapping, WithStyles
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
            'Insiden Terjadi Pada',
            'Sumber Informasi',
            'Menyangkut Pasien',
            'Terjadi Pada Pasien',
            'Akibat ke Pasien',
            'Lokasi Insiden',
            'Tindakan Segera',
            'Pelaksana',
            'Nama Inisial Pelapor',
            'Ruangan Pelapor'
        ];
    }

    public function map($row): array
    {
        $this->index++;

        return [
            $this->index,
            $row->no_rm,
            $row->nama_pasien,
            $row->umur,
            $row->jk,
            $row->waktu_mskrs->format('d-m-Y, H:i'),
            $row->waktu_insiden->format('d-m-Y, H:i'),
            $row->temuan,
            $row->kronologis,
            $row->unit_terkait,
            $row->sumber,
            $row->rawat,
            $row->poli,
            $row->akibat,
            $row->lokasi,
            $row->tindakan_segera,
            $row->pelaksana,
            $row->nama_inisial,
            $row->ruangan_pelapor
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $lastRow = $this->data->count() + 1;

        return [
            1 => ['font' => ['bold' => true]],

            'A1:S' . $lastRow => [
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
