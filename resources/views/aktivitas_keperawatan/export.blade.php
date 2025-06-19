@extends('layouts.export')

@push('style')
<style>
    th {
        background-color: #D9D9D9
    }
</style>
@endpush

@section('title', 'Export Aktivitas Keperawatan')

@section('content')
<table border="1" cellspacing="0" cellpadding="4" style="width: 100%">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Perawat</th>
            <th>Unit Kerja</th>
            <th>Shift</th>
            <th>Tanggal</th>
            <th>Nilai</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($data as $item)
            <tr style="text-align: center">
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->user->name }}</td>
                <td>{{ $item->user->unit }}</td>
                <td>{{ $item->shift }}</td>
                <td>{{ $item->waktu->format('d-m-Y') }}</td>
                <td>{{ $item->nilai != 0 ? $item->nilai : '-' }}</td>
            </tr>
        @empty
            <tr style="text-align: center">
                <td colspan="6">Tidak ada data aktivitas</td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection