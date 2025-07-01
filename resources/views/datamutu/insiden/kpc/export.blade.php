@extends('layouts.export')

@push('style')
<style>
    .export-table {
        width: 100%;
        border-collapse: collapse;
    }
    .export-table th,
    .export-table td {
        padding: 4px;
        border: 1px solid black;
        font-size: 11pt;
    }
    .export-table th {
        background-color: #f2f2f2;
    }

    .export-heading {
        font-size: 14pt;
        margin: 0;
    }

    .export-subtext {
        font-size: 11pt;
        margin: 0;
    }

    .export-break {
        margin-bottom: 2rem;
        page-break-inside: avoid;
    }

    .export-divider {
        margin: 20px 0;
        border: 1.5px solid black;
    }

    .export-label {
        width: 150px;
        text-align: left;
    }

    .export-separator {
        width: 10px;
        text-align: center;
    }

    .export-img {
        margin: 5px;
        display: inline-block;
    }

    .export-img img {
        height: 120px;
    }

    .text-left {
        text-align: left;
    }

    .w-1-3 {
        width: 33.33%;
    }

    .font-bold {
        font-weight: bold;
    }

    .pt-2rem {
        padding-top: 2rem !important;
    }
</style>
@endpush

@section('title', 'Rekap Laporan Insiden KPC')

@section('content')
<center>
    <h2 class="export-heading" style="margin-bottom: 5px;">REKAP LAPORAN INSIDEN KESELAMATAN PASIEN</h2>
    <h2 class="export-heading" style="margin-bottom: 5px;">KEJADIAN POTENSIAL CEDERA (KPC)</h2>
    <h2 class="export-heading">RSUD BAYUNG LENCIR</h2>
</center>

<hr class="export-divider">

<center>
    <p class="export-subtext">Triwulan ke-{{ $triwulan }} tahun {{ $tahun }}</p>
</center>

@foreach ($data as $item)
<div class="export-break">
    <p class="font-bold" style="margin-bottom: .5rem;">No. {{ $loop->iteration }}</p>

    <table class="export-table" style="margin-bottom: .5rem">
        <tr>
            <th class="export-label">Nama Inisial Pelapor</th>
            <td class="export-separator">:</td>
            <td>{{ $item->nama_inisial }}</td>
            <th class="export-label">Unit Terkait</th>
            <td class="export-separator">:</td>
            <td>{{ $item->unit_terkait }}</td>
        </tr>
        <tr>
            <th class="export-label">Ruangan Pelapor</th>
            <td class="export-separator">:</td>
            <td>{{ $item->ruangan }}</td>
            <th class="export-label">Sumber Informasi</th>
            <td class="export-separator">:</td>
            <td>{{ $item->sumber }}</td>
        </tr>
        <tr>
            <th class="export-label">Tanggal & Waktu</th>
            <td class="export-separator">:</td>
            <td>{{ $item->waktu->format('d-m-Y, H:i') }} WIB</td>
            <th class="export-label">Pelaksana</th>
            <td class="export-separator">:</td>
            <td>{{ $item->pelaksana }}</td>
        </tr>
    </table>

    <table class="export-table" style="margin-bottom: .5rem">
        <thead>
            <tr>
                <th colspan="3" class="text-left">Isi Laporan</th>
            </tr>
            <tr>
                <th class="w-1-3 text-left">Temuan Kejadian/Insiden</th>
                <th class="w-1-3 text-left">Kronologis</th>
                <th class="w-1-3 text-left">Tindakan yang dilakukan</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $item->temuan }}</td>
                <td>{{ $item->kronologis }}</td>
                <td>{{ $item->tindakan }}</td>
            </tr>
        </tbody>
    </table>

    <table class="export-table">
        <thead>
            <tr>
                <th class="text-left">Lampiran Foto</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="{{ count($item->gambar_base64) > 0 ? 'pt-2rem' : '' }}">
                    @forelse ($item->gambar_base64 as $f)
                        <div class="export-img">
                            <img src="{{ $f }}" alt="">
                        </div>
                    @empty
                        -
                    @endforelse
                </td>
            </tr>
        </tbody>
    </table>
</div>
@endforeach
@endsection