@extends('layouts.main')

@section('title', 'Detail Cuci Tangan')

@section('content')
    <div class="container-fluid">
        <div class="card bg-primary-subtle shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-8">Detail Cuci Tangan</h4>
                        <nav aria-label="breadcrumb" style="--bs-breadcrumb-divider: '/'">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a class="text-muted text-decoration-none" href="{{ route('dashboard') }}">Beranda</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a class="text-muted text-decoration-none" href="{{ route('cuci_tangan.index') }}">Cuci
                                        Tangan</a>
                                </li>
                                <li class="breadcrumb-item" aria-current="page">Detail Cuci Tangan</li>
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
            <a href="{{ route('cuci_tangan.index') }}" class="btn bg-primary-subtle text-primary">Kembali</a>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-3">Detail Cuci Tangan</h4>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Tanggal & Waktu</label>
                                <div class="form-control bg-light">{{ $cuci_tangan->waktu->format('d-m-Y H:i') }} WIB</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Shift</label>
                                <div class="form-control bg-light">{{ $cuci_tangan->shift }}</div>
                            </div>
                        </div>

                        <div class="table-responsive border-top pt-3">
                            <table class="table w-100">
                                <thead>
                                    <tr class="text-nowrap">
                                        <th>Momen Cuci Tangan</th>
                                        <th>Sudah Dilaksanakan</th>
                                        <th>Catatan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $cuciTangan = [
                                            'Sebelum Menyentuh Pasien',
                                            'Sebelum Tindakan Aseptik',
                                            'Setelah Terpapar Cairan Tubuh Pasien',
                                            'Setelah Menyentuh Pasien',
                                            'Setelah Menyentuh Lingkungan Sekitar Pasien',
                                        ];
                                    @endphp

                                    @foreach ($cuciTangan as $i => $momen)
                                        <tr>
                                            <td>{{ $momen }}</td>
                                            <td>
                                                {{ $cuci_tangan->dilaksanakan[$i] ?? '-' }}
                                            </td>
                                            <td>
                                                {{ $cuci_tangan->catatan[$i] ?? '-' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
