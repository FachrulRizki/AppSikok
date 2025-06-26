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
        width: 120px;
        text-align: left;
    }

    .export-label-2 {
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

@section('title', 'Rekap Laporan Insiden KNC')

@section('content')
<center>
    <h2 class="export-heading" style="margin-bottom: 5px;">REKAP LAPORAN INSIDEN KESELAMATAN PASIEN</h2>
    <h2 class="export-heading" style="margin-bottom: 5px;">KEJADIAN NYARIS CEDERA (KNC)</h2>
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
        <tr><th colspan="6" class="text-left">Data Pasien</th></tr>
        <tr>
            <th class="export-label">No. RM</th>
            <td class="export-separator">:</td>
            <td>{{ $item->no_rm }}</td>
            <th class="export-label">Jenis Kelamin</th>
            <td class="export-separator">:</td>
            <td>{{ $item->jk }}</td>
        </tr>
        <tr>
            <th class="export-label">Nama Pasien</th>
            <td class="export-separator">:</td>
            <td>{{ $item->nama_pasien }}</td>
            <th class="export-label">Waktu Masuk RS</th>
            <td class="export-separator">:</td>
            <td>{{ $item->waktu_mskrs->format('d-m-Y, H:i') }} WIB</td>
        </tr>
        <tr>
            <th class="export-label">Umur</th>
            <td class="export-separator">:</td>
            <td colspan="4">{{ $item->umur }} Tahun</td>
        </tr>
    </table>

    <table class="export-table" style="margin-bottom: .5rem">
        <tr><th colspan="6" class="text-left">Detail Insiden</th></tr>
        <tr>
            <th class="export-label-2">Tanggal & Waktu</th>
            <td class="export-separator">:</td>
            <td>{{ $item->waktu_insiden->format('d-m-Y, H:i') }} WIB</td>
            <th class="export-label-2">Unit Terkait</th>
            <td class="export-separator">:</td>
            <td>{{ $item->unit_terkait }}</td>
        </tr>
        <tr>
            <th class="export-label-2">Terjadi Pada</th>
            <td class="export-separator">:</td>
            <td>{{ $item->insiden_pada }}</td>
            <th class="export-label-2">Pelaksana</th>
            <td class="export-separator">:</td>
            <td>{{ $item->pelaksana }}</td>
        </tr>
        <tr>
            <th class="export-label-2">Sumber Informasi</th>
            <td class="export-separator">:</td>
            <td>{{ $item->sumber }}</td>
            <th class="export-label-2">Nama Inisial Pelapor</th>
            <td class="export-separator">:</td>
            <td>{{ $item->nama_inisial }}</td>
        </tr>
        <tr>
            <th class="export-label-2">Menyangkut Pasien</th>
            <td class="export-separator">:</td>
            <td>{{ $item->rawat }}</td>
            <th class="export-label-2">Ruangan Pelapor</th>
            <td class="export-separator">:</td>
            <td>{{ $item->ruangan_pelapor }}</td>
        </tr>
        <tr>
            <th class="export-label-2">Terjadi pada Pasien</th>
            <td class="export-separator">:</td>
            <td colspan="4">{{ $item->poli }}</td>
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
                <th class="w-1-3 text-left">Tindakan Segera</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $item->temuan }}</td>
                <td>{{ $item->kronologis }}</td>
                <td>{{ $item->tindakan_segera }}</td>
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
                <td class="{{ count($item->foto) > 0 ? 'pt-2rem' : '' }}">
                    @forelse ($item->foto as $f)
                        <div class="export-img">
                            <img src="{{ asset('storage/'.$f) }}" alt="">
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