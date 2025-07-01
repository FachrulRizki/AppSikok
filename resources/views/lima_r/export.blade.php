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

@section('title', 'Rekap Laporan 5R')

@section('content')
<center>
    <h2 class="export-heading" style="margin-bottom: 5px;">REKAP LAPORAN DATA 5R</h2>
    <h2 class="export-heading">RSUD BAYUNG LENCIR</h2>
</center>

<hr class="export-divider">

<center>
    <p class="export-subtext">Periode : {{ $start_date }} s/d {{ $end_date }}</p>
</center>

@foreach ($data as $item)
<div class="export-break">
    <p class="font-bold" style="margin-bottom: .5rem;">No. {{ $loop->iteration }}</p>

    <table class="export-table" style="margin-bottom: .5rem">
        <tr>
            <th class="export-label">Petugas</th>
            <td class="export-separator">:</td>
            <td>{{ $item->user->name }}</td>
        </tr>
        <tr>
            <th class="export-label">Unit Tugas</th>
            <td class="export-separator">:</td>
            <td>{{ $item->user->unit }}</td>
        </tr>
        <tr>
            <th class="export-label">Shift</th>
            <td class="export-separator">:</td>
            <td>{{ $item->shift }}</td>
        </tr>
        <tr>
            <th class="export-label">Tanggal & Waktu</th>
            <td class="export-separator">:</td>
            <td>{{ $item->waktu->format('d-m-Y, H:i') }} WIB</td>
        </tr>
    </table>

    <table class="export-table" style="margin-bottom: .5rem">
        <thead>
            <tr>
                <th style="width: 80px;" class="text-left">Prinsip 5R</th>
                <th style="width: 300px;" class="text-left">Kegiatan</th>
                <th style="width: 100px">Dilaksanakan</th>
                <th class="text-left">Catatan</th>
            </tr>
        </thead>
        <tbody>
            @php
                $prinsip5R = ['Ringkas', 'Rapi', 'Resik', 'Rawat', 'Rajin'];
                $kegiatan = [
                    'Memilih barang yang diperlukan dan tidak',
                    'Menata alat dan perlengkapan dengan teratur',
                    'Menjaga kebersihan lingkungan kerja',
                    'Merawat dan memelihara peralatan dengan baik',
                    'Melakukan kegiatan secara konsisten dan rutin',
                ];
                $dilaksanakan = json_decode($item->dilaksanakan, true);
                $catatan = json_decode($item->catatan, true);
            @endphp
            @foreach ($prinsip5R as $i => $prinsip)
                <tr>
                    <td>{{ $prinsip }}</td>
                    <td>{{ $kegiatan[$i] ?? '' }}</td>
                    <td style="text-align: center">{{ $dilaksanakan[$i] ?? '-' }}</td>
                    <td>{{ $catatan[$i] ?? '-' }}</td>
                </tr>
            @endforeach
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