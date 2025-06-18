@extends('layouts.export')

@push('style')
<style>
    th {
        background-color: #D9D9D9
    }
</style>
@endpush

@section('title', 'Export Laporan 5R')

@section('content')
<table border="1" cellspacing="0" cellpadding="4" style="width: 100%">
    <thead>
        <tr>
            <th rowspan="2">No</th>
            <th rowspan="2">Nama Petugas</th>
            <th rowspan="2">Shift</th>
            <th rowspan="2">Tanggal</th>
            <th colspan="5">Pelaksanaan 5R</th>
        </tr>
        <tr>
            <th>Ringkas</th>
            <th>Rapi</th>
            <th>Resik</th>
            <th>Rawat</th>
            <th>Rajin</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($data as $item)
            <tr style="text-align: center">
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->user->name }}</td>
                <td>{{ $item->shift }}</td>
                <td>{{ $item->waktu->format('d-m-Y') }}</td>
                @foreach (json_decode($item->dilaksanakan) as $i)
                    <td>{{ $i }}</td>
                @endforeach
            </tr>
        @empty
            <tr style="text-align: center">
                <td colspan="10">Tidak ada data</td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection