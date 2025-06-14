@extends('layouts.main')

@section('title', 'Detail 5R')

@section('content')
    <div class="container-fluid">
        <div class="card bg-primary-subtle shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-8">Detail 5R</h4>
                        <nav aria-label="breadcrumb" style="--bs-breadcrumb-divider: '/'">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a class="text-muted text-decoration-none" href="{{ route('dashboard') }}">Beranda</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a class="text-muted text-decoration-none"
                                        href="{{ route('lima_r.index') }}">5R</a>
                                </li>
                                <li class="breadcrumb-item" aria-current="page">Detail 5R</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-3">
                        <div class="text-center mb-n5">
                            <img src="{{ asset('assets/images/backgrounds/welcome-doctors.svg') }}" alt="modernize-img"
                                class="img-fluid mb-n4" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex gap-2 mb-4">
            <a href="{{ route('lima_r.index') }}" class="btn bg-primary-subtle text-primary">Kembali</a>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col">
                        <label class="form-label">Tanggal & Waktu</label>
                        <input type="datetime-local" class="form-control" value="{{ $lima_r->waktu->format('Y-m-d\TH:i') }}"
                            readonly>
                    </div>
                    <div class="col">
                        <label class="form-label">Shift</label>
                        <input type="text" class="form-control" value="{{ $lima_r->shift }}" readonly>
                    </div>
                </div><br>

                <div class="table-responsive border-top">
                    <table class="table w-100">
                        <thead>
                            <tr class="text-nowrap">
                                <th>Prinsip 5R</th>
                                <th>Kegiatan</th>
                                <th>Sudah Dilaksanakan</th>
                                <th>Catatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $prinsip5R = ['Ringkas', 'Rapi', 'Resik', 'Rawat', 'Rajin'];
                                $kegiatan = [
                                    'Memilih barang yang diperlukan dan tidak',
                                    'Menata alat dan perlengkapan dengan teratur',
                                    'Menjaga kebersihan lingkungan kerja',
                                    'Merawat dan memelihara peralatan dengan baik',
                                    'Melakukan kegiatan secara konsisten dan rutin',
                                ];
                                $dilaksanakan = json_decode($lima_r->dilaksanakan, true);
                                $catatan = json_decode($lima_r->catatan, true);
                            @endphp

                            @foreach ($prinsip5R as $i => $prinsip)
                                <tr>
                                    <td>{{ $prinsip }}</td>
                                    <td>{{ $kegiatan[$i] ?? '' }}</td>
                                    <td>{{ $dilaksanakan[$i] ?? '-' }}</td>
                                    <td>{{ $catatan[$i] ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

               <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Lampiran Foto</h4>
                        <div class="row">
                            @forelse ($lima_r->foto as $img)
                                <div class="col-md-3 mb-3">
                                    <a href="{{ asset('storage/' . $img) }}" target="_blank"
                                        class="ratio ratio-1x1 overflow-hidden">
                                        <img src="{{ asset('storage/' . $img) }}" alt="Foto"
                                            style="cursor: pointer; object-fit: cover;" class="rounded">
                                    </a>
                                </div>
                            @empty
                                <p class="text-center mb-0">Tidak ada lampiran foto</p>
                            @endforelse
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
@endsection
