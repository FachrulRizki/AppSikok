@extends('layouts.export')

@push('style')
<style>
    th {
        background-color: #D9D9D9
    }
    table {
        border-collapse: collapse;
        width: 100%
    }
    th, td {
        padding: 4px;
        border: 1px solid black;
    }
</style>
@endpush

@section('title', 'Export Leaderboard Kinerja Perawat')

@section('content')
<table>
    <thead>
        <tr>
            <th>Rank</th>
            <th>Perawat</th>
            <th>Unit Kerja</th>
            <th>Skor</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($data as $i => $item)
            <tr style="text-align: center">
                <td style="{{ $i < 3 ? 'font-weight: bold' : '' }}">{{ $loop->iteration }}</td>
                <td style="{{ $i < 3 ? 'font-weight: bold' : '' }}">{{ $item['user']->name }}</td>
                <td style="{{ $i < 3 ? 'font-weight: bold' : '' }}">{{ $item['user']->unit }}</td>
                <td style="{{ $i < 3 ? 'font-weight: bold' : '' }}">{{ $item['score'] }}</td>
            </tr>
        @empty
            <tr style="text-align: center">
                <td colspan="4">Tidak ada data</td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection