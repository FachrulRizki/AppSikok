@extends('layouts.main')

@section('content')
    <div class="container">
        <div class="container-fluid">
            <div class="card bg-primary-subtle shadow-none position-relative overflow-hidden mb-4">
                <div class="card-body px-4 py-3">
                    <div class="row align-items-center">
                        <div class="col-9">
                            <h4 class="fw-semibold mb-2">LAPORAN INSIDEN KEJADIAN SENTINEL</h4>
                            <p class="mb-0 text-muted">
                                KEJADIAN SENTINEL (KTD YANG MENYEBABKAN KEMATIAN, CACAT, ATAU CEDERA BERAT).
                            </p>
                            <nav aria-label="breadcrumb" class="mt-2">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('dashboard') }}">Beranda</a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('insiden') }}">Data Mutu Insiden</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">Sentinel</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="col-3 text-end">
                            <img src="{{ asset('assets/images/backgrounds/welcome-doctors.svg') }}" alt="doctor"
                                class="img-fluid" style="max-height: 100px;">
                        </div>
                    </div>
                </div>
            </div>
             <a href="{{ route('insiden.sentinel.create') }}" class="btn btn-primary mb-3">Tambah Insiden</a>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No RM</th>
                        <th>Nama Pasien</th>
                        <th>Tanggal & Waktu Masuk RS</th>
                        <th>Tanggal & Waktu Insiden</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sentinels as $sentinel)
                        <tr>
                            <td>{{ $sentinel->no_rm }}</td>
                            <td>{{ $sentinel->nama_pasien }}</td>
                            <td>{{ $sentinel->waktu_mskrs }}</td>
                            <td>{{ $sentinel->waktu_insiden }}</td>
                            <td>
                                <a href="{{ route('insiden.sentinel.show', $sentinel->id) }}" class="btn btn-sm btn-info">View</a>
                                {{-- <a href="{{ route('insiden.sentinel.edit', $sentinel->id) }}" class="btn btn-sm btn-warning">Edit</a> --}}
                                <form action="{{ route('insiden.sentinel.destroy', $sentinel->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Yakin ingin menghapus?')"
                                        class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
