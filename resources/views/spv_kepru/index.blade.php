@extends('layouts.main')

@section('title', 'Supervisi Kepala Ruang')

@section('content')
    <div class="container-fluid">
        <div class="card bg-primary-subtle shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-8">Supervisi Kepala Ruang</h4>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a class="text-muted text-decoration-none" href="{{ route('dashboard') }}">Beranda</a>
                                </li>
                                <li class="breadcrumb-item" aria-current="page">Supervisi Kepala Ruang</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-3">
                        <div class="text-center mb-n5">
                            <img src="{{ asset('assets/images/backgrounds/welcome-doctors.svg') }}" alt="modernize-img" class="img-fluid mb-n4" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <a href="{{ route('spv_kepru.create') }}" class="btn btn-primary mb-4">Tambah Supervisi</a>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card">
            <div class="card-body">
                <table class="table w-100">
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
                        @forelse ($data as $item)
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
                        @empty
                            <tr>
                                <td class="text-center" colspan="7">Tidak ada data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
