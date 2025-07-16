@extends('layouts.export')

@push('style')
<style>
    th {
        background-color: #D9D9D9
    }
</style>
@endpush

@section('title', 'Export Hasil Kuis')

@section('content')
<table style="margin-bottom: 1rem">
    <tr>
        <td style="width: 100px">Judul Kuis</td>
        <td>:</td>
        <td>{{ $quiz->title }}</td>
    </tr>
    <tr>
        <td style="width: 100px">Jumlah Soal</td>
        <td>:</td>
        <td>{{ $quiz->questions()->count() }} Soal</td>
    </tr>
    <tr>
        <td style="width: 100px">Mengerjakan</td>
        <td>:</td>
        <td>{{ $data->count() }} Peserta</td>
    </tr>
</table>
<table border="1" cellspacing="0" cellpadding="4" style="width: 100%">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Peserta</th>
            <th>Unit Kerja</th>
            <th>Tanggal Pengerjaan</th>
            <th>Nilai Akhir</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($data as $item)
            <tr style="text-align: center">
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->user->name }}</td>
                <td>{{ $item->user->unit }}</td>
                <td>{{ $item->created_at->format('d-m-Y, H:i') }} WIB</td>
                <td>{{ $item->score }}</td>
            </tr>
        @empty
            <tr style="text-align: center">
                <td colspan="5">Belum ada peserta mengerjakan</td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection