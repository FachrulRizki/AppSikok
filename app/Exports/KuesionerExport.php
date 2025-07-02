<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class KuesionerExport implements FromView, WithStyles, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $data, $jumlahPerUnsur, $nrrTertimbang, $ikm, $bulan, $tahun;

    public function __construct($data, $jumlahPerUnsur, $nrrTertimbang, $ikm, $bulan, $tahun)
    {
        $this->data = $data;
        $this->jumlahPerUnsur = $jumlahPerUnsur;
        $this->nrrTertimbang = $nrrTertimbang;
        $this->ikm = $ikm;

        $this->bulan = $bulan;
        $this->tahun = $tahun;

    }
    public function view(): View
    {
        return view('kuisoner.export', [
            'data' => $this->data,
            'jumlahPerUnsur' => $this->jumlahPerUnsur,
            'nrrTertimbang' => $this->nrrTertimbang,
            'ikm' => $this->ikm,
            'bulan' => $this->bulan,
            'tahun' => $this->tahun
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();

        return [
            "A1:{$highestColumn}1" => [
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
            ],
            "A2:{$highestColumn}2" => [
                'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
            ],
            "A4:{$highestColumn}4" => [
                'font' => ['bold' => true],
            ],
            "A5:{$highestColumn}5" => [
                'font' => ['bold' => true],
            ],
            "A4:{$highestColumn}{$highestRow}" => [
                'alignment' => [
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'wrapText' => true,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => 'FF000000'],
                    ],
                ],
            ],
        ];
    }
}
