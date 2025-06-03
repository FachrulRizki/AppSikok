@extends('layouts.main')
@section('content')
    <div class="container"><br>
        <h1>Daftar Aktivitas Keperawatan</h1>
        <a href="{{ route('aktivitas_keperawatan.create') }}" class="btn btn-success mb-3">Tambah Aktivitas</a>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <div class="card border-top-0 px-4 py-5">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Shift</th>
                    <th>Nama Perawat</th>
                    <th>Aktivitas Perawat</th>
                    <th>Unit Kerja</th>
                    <th>Catatan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                    <tr>
                        <td>{{ $item->waktu->format('d-m-Y H:i') }}</td>
                        <td>{{ $item->shift }}</td>
                        <td>{{ $item->nama_perawat }}</td>
                        <td>{{ $item->aktivitas_list }}</td>
                        <td>{{ $item->unit_kerja }}</td>
                        <td>{{ $item->catatan }}</td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('aktivitas_keperawatan.edit', $item->id) }}" class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                <form action="{{ route('aktivitas_keperawatan.destroy', $item->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin hapus?')">
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
