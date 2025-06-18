@extends('layouts.export')

@push('style')
<style>
    th {
        background-color: #D9D9D9
    }
</style>
@endpush

@section('title', 'Export Supervisi Kepala Ruang')

@section('content')
<table border="1" cellspacing="0" cellpadding="4" style="width: 100%">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Kepala Ruang</th>
            <th>Ruangan</th>
            <th>Shift</th>
            <th>Tanggal</th>
            <th>Aktivitas</th>
            <th>Observasi</th>
            <th>Solusi Perbaikan</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($data as $item)
            <tr style="text-align: center">
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->user->name }}</td>
                <td>{{ $item->ruangan }}</td>
                <td>{{ $item->shift }}</td>
                <td>{{ $item->waktu->format('d-m-Y') }}</td>
                <td style="text-align: left">
                    <ul style="margin: 0">
                        @foreach ($item->aktivitas as $akt)
                            <li>{{ $akt }}</li>
                        @endforeach
                    </ul>
                </td>
                <td>{{ $item->observasi }}</td>
                <td>{{ $item->perbaikan }}</td>
            </tr>
        @empty
            <tr style="text-align: center">
                <td colspan="8">Tidak ada data aktivitas</td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection