@extends('layouts.export')

@push('style')
<style>
    th {
        background-color: #D9D9D9
    }
</style>
@endpush

@section('title', 'Export Refleksi Harian')

@section('content')
<table border="1" cellspacing="0" cellpadding="4" style="width: 100%">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Perawat</th>
            <th>Unit Kerja</th>
            <th>Tanggal</th>
            <th>Persetujuan</th>
            <th>Nilai</th>
            <th>Feedback</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($data as $item)
            <tr style="text-align: center">
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->user->name }}</td>
                <td>{{ $item->user->unit }}</td>
                <td>{{ $item->waktu->format('d-m-Y') }}</td>
                @php
                    $persetujuan = [
                        'waiting' => ['label' => 'Menunggu'],
                        'approved' => ['label' => 'Disetujui'],
                        'rejected' => ['label' => 'Ditolak'],
                    ][$item->approvement];
                @endphp
                <td>{{ $persetujuan['label'] }}</td>
                <td>
                    @php
                        $category = $item->humanityScore?->category;

                        if ($category) {
                            $emoji = Str::substr($category, 0, 2);
                            $label = Str::after($category, ' ');
                        } else {
                            $emoji = '';
                            $label = '-';
                        }
                    @endphp
                    <span>{{ $label }}</span>
                </td>
                <td>{{ $item->feedback }}</td>
            </tr>
        @empty
            <tr style="text-align: center">
                <td colspan="7">Tidak ada data aktivitas</td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection