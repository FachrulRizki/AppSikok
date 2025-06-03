@extends('layouts.main')
@section('content')
    <div class="container"><br>
        <h1>Daftar Supervisi Harian</h1>
        <a href="{{ route('spv_kepru.create') }}" class="btn btn-success mb-3">Tambah Supervisi</a>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <div class="card border-top-0 px-4 py-5">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Nama Kepala Ruang</th>
                        <th>Shift</th>
                        <th>Fokus Supervisi</th>
                        <th>Catatan Observasi</th>
                        <th>Saran Perbaikan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <td>{{ $item->waktu->format('d-m-Y H:i') }}</td>
                            <td>{{ $item->nm_kepru }}</td>
                            <td>{{ $item->shift }}</td>
                            <td>{{ $item->aktivitas_list }}</td>
                            <td>{{ $item->observasi }}</td>
                            <td>{{ $item->perbaikan }}</td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('spv_kepru.edit', $item->id) }}" class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </a>
                                    <form action="{{ route('spv_kepru.destroy', $item->id) }}" method="POST"
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
