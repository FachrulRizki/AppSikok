@extends('layouts.main')
@section('content')
    <div class="container"><br>
        <h1>Daftar Refleksi Harian</h1>
        <a href="{{ route('refleksi.create') }}" class="btn btn-success mb-3">Tambah Refleksi</a>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <div class="card border-top-0 px-4 py-5">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Judul Kegiatan</th>
                        <th>Nama Peserta</th>
                        <th>Unit Kerja</th>
                        <th>Poin Materi</th>
                        <th>Refleksi Pribadi</th>
                        <th>Rencana Tindakan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                    <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td>{{ $item->waktu->format('d-m-Y H:i') }}</td>
                                <td>{{ $item->jdl_kegiatan }}</td>
                                <td>{{ $item->nm_peserta }}</td>
                                <td>{{ $item->unit_kerja }}</td>
                                <td>{{ $item->poin_materi }}</td>
                                <td>{{ $item->pribadi }}</td>
                                <td>{{ $item->tindakan }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('refleksi.edit', $item->id) }}"
                                            class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </a>
                                        <form action="{{ route('refleksi.destroy', $item->id) }}"
                                            method="POST" onsubmit="return confirm('Yakin hapus?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

            </table>
        </div>
    </div>
@endsection
