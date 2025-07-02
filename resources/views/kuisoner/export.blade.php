@extends('layouts.export')

@section('title')
    {{ $bulan }}-{{ $tahun }}
@endsection

@section('content')
<table style="width: 100%">
    <tr><th colspan="12"><strong>Rekap Bulanan Kuesioner Kepuasan Pasien</strong></th></tr>
    <tr><th colspan="12">
        @if (request('bulan') && request('tahun'))
            {{ \Carbon\Carbon::createFromDate(request('tahun'), request('bulan'), 1)->locale('id')->translatedFormat('F Y') }} - {{ request('ruangan') ? 'Ruang ' . request('ruangan') : 'Semua Ruangan' }}
        @endif
    </th></tr>
</table>
<table border="1" cellspacing="0" cellpadding="4" style="width: 100%">
    <thead>
        <tr>
            <th rowspan="2" style="width: 50px">No</th>
            <th rowspan="2">Tanggal</th>
            <th rowspan="2">Ruangan</th>
            <th colspan="9">Nilai Per Unsur Pelayanan</th>
        </tr>
        <tr>
            @for ($i = 1; $i <= 9; $i++)
                <th>U{{ $i }}</th>
            @endfor
        </tr>
    </thead>
    <tbody>
        @forelse ($data as $item)
            <tr style="text-align: center">
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->waktu_survei->format('d-m-Y') }}</td>
                <td>{{ $item->ruangan }}</td>
                <td>{{ $item->p1 }}</td>
                <td>{{ $item->p2 }}</td>
                <td>{{ $item->p3 }}</td>
                <td>{{ $item->p4 }}</td>
                <td>{{ $item->p5 }}</td>
                <td>{{ $item->p6 }}</td>
                <td>{{ $item->p7 }}</td>
                <td>{{ $item->p8 }}</td>
                <td>{{ $item->p9 }}</td>
            </tr>
        @empty
            <tr style="text-align: center">
                <td colspan="11">Tidak ada data kuesioner</td>
            </tr>
        @endforelse
    </tbody>
    <tfoot>
        <tr style="text-align: center">
            <th colspan="3"><strong>Jumlah Nilai Perunsur</strong></th>
            @for ($i = 1; $i <= 9; $i++)
                <th><strong>{{ $jumlahPerUnsur[$i] }}</strong></th>
            @endfor
        </tr>
        <tr style="text-align: center">
            <th colspan="3"><strong>NRR Tertimbang Unsur</strong></th>
            @for ($i = 1; $i <= 9; $i++)
                <th><strong>{{ $nrrTertimbang[$i] }}</strong></th>
            @endfor
        </tr>
        <tr style="text-align: center">
            <th colspan="3"><strong>IKM</strong></th>
            <th colspan="9"><strong>{{ $ikm }}</strong></th>
        </tr>
    </tfoot>
</table>
@endsection