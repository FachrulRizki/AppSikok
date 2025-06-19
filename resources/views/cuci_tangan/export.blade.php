@extends('layouts.export')

@push('style')
    <style>
        th {
            background-color: #D9D9D9
        }
    </style>
@endpush

@section('title', 'Export Laporan PPI')

@section('content')
    <table border="1" cellspacing="0" cellpadding="4" style="width: 100%">
        <thead>
            <tr>
                <th style="width: 50px">No</th>
                <th>Nama Petugas</th>
                <th>Unit Kerja</th>
                <th>Shift</th>
                <th>Tanggal</th>
                <th>Aktivitas</th>
                <th>Detail Aktivitas</th>
                <th>Catatan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $i => $row)
                @php
                    $totalBaris = array_sum(array_map(fn($a) => count($a['rows']), $row['data']));
                    $renderedFirstRow = false;
                @endphp

                @foreach ($row['data'] as $activity)
                    @foreach ($activity['rows'] as $j => $item)
                        <tr>
                            @if (!$renderedFirstRow)
                                <td rowspan="{{ $totalBaris }}" style="text-align: center">{{ $i + 1 }}</td>
                                <td rowspan="{{ $totalBaris }}">{{ $row['user_name'] }}</td>
                                <td rowspan="{{ $totalBaris }}" style="text-align: center">{{ $row['user_unit'] }}</td>
                                <td rowspan="{{ $totalBaris }}" style="text-align: center">{{ $row['shift'] }}</td>
                                <td rowspan="{{ $totalBaris }}" style="text-align: center">{{ $row['waktu']->format('d-m-Y') }}</td>
                                @php $renderedFirstRow = true; @endphp
                            @endif

                            @if ($j === 0)
                                <td rowspan="{{ count($activity['rows']) }}">{{ $activity['nama'] }}</td>
                            @endif

                            <td>
                                {{ $item['detail'] }}
                                @if (!empty($item['tasks']))
                                    <ul style="margin: 0; padding-left: 20px">
                                        @foreach ($item['tasks'] as $task)
                                            <li>- {{ $task }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </td>

                            @if ($j === 0)
                                <td rowspan="{{ count($activity['rows']) }}">{{ $activity['catatan'] }}</td>
                            @endif
                        </tr>
                    @endforeach
                @endforeach
            @endforeach
        </tbody>
    </table>
@endsection
