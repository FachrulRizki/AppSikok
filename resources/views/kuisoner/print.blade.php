<div>
    <h2 style="margin-bottom: .8rem">Rekap Bulanan Kuesioner Kepuasan Pasien</h2>
    <h3 style="margin-top: 0">{{ \Carbon\Carbon::create()->month(request('bulan'))->locale('id')->monthName }} {{ request('tahun') }}</h3>
</div>
<table border="1" cellspacing="0" cellpadding="4" style="width: 100%">
    <thead bgcolor="#D9D9D9">
        <tr>
            <th rowspan="2">No</th>
            <th rowspan="2">Tanggal</th>
            <th colspan="9">Nilai Per Unsur Pelayanan</th>
        </tr>
        <tr>
            @for($i = 1; $i <= 9; $i++)
                <th>U{{ $i }}</th>
            @endfor
        </tr>
    </thead>
    <tbody>
        @forelse ($data as $item)
            <tr style="text-align: center">
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->waktu_survei->format('d-m-Y') }}</td>
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
    <tfoot bgcolor="#D9D9D9">
        <tr style="text-align: center">
            <th colspan="2">Jumlah Nilai Perunsur</th>
            @for($i = 1; $i <= 9; $i++)
                <td><strong>{{ $jumlahPerUnsur[$i] }}</strong></td>
            @endfor
        </tr>
        <tr style="text-align: center">
            <th colspan="2">NRR Tertimbang Unsur</th>
             @for($i = 1; $i <= 9; $i++)
                <td><strong>{{ $nrrTertimbang[$i] }}</strong></td>
            @endfor
        </tr>
        <tr style="text-align: center">
            <th colspan="2">IKM</th>
            <td colspan="9"><strong>{{ $ikm }}</strong></td>
        </tr>
    </tfoot>
</table>