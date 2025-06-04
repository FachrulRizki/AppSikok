@extends('layouts.main')

@section('title', 'Laporan Insiden KPC')

@section('content')
    <div class="container">
        <form action="{{ route('insiden.kpc.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="container-fluid">
                <div class="card bg-primary-subtle shadow-none position-relative overflow-hidden mb-4">
                    <div class="card-body px-4 py-3">
                        <div class="row align-items-center">
                            <div class="col-9">
                                <h4 class="fw-semibold mb-2">Laporan Insiden Kejadian Potensial Cedera (KPC)</h4>
                                <p class="mb-0 text-muted">
                                    Merupakan kondisi yang sangat berpotensi menimbulkan insiden, namun belum terjadi.
                                </p>
                                <nav aria-label="breadcrumb" class="mt-2">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">
                                            <a href="{{ route('dashboard') }}">Beranda</a>
                                        </li>
                                        <li class="breadcrumb-item">
                                            <a href="{{ route('insiden') }}">Data Mutu Insiden</a>
                                        </li>
                                        <li class="breadcrumb-item active" aria-current="page">KPC</li>
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

                {{-- FORM START --}}
                <div class="card mb-4">
                    <div class="card-body">

                        {{-- Tanggal dan Waktu --}}
                        <div class="mb-3">
                            <label class="form-label">Tanggal dan Waktu</label>
                            <input type="datetime-local" name="waktu" class="form-control"
                                value="{{ old('waktu', isset($kpc) ? $kpc->waktu->format('Y-m-d\TH:i') : '') }}">
                        </div>

                        {{-- Temuan Kejadian --}}
                        <div class="mb-3">
                            <label class="form-label">Temuan Kejadian/Insiden *</label>
                            <textarea name="temuan" class="form-control" rows="3" required>{{ old('temuan', $kpc->temuan ?? '') }}</textarea>
                        </div>

                        {{-- Kronologis --}}
                        <div class="mb-3">
                            <label class="form-label">Kronologis Insiden *</label>
                            <textarea name="kronologis" class="form-control" rows="4" required>{{ old('kronologis', $kpc->kronologis ?? '') }}</textarea>
                        </div>

                        {{-- Sumber Informasi --}}
                        <div class="mb-3">
                            <label class="form-label">Sumber Informasi *</label>
                            @foreach (['Karyawan', 'Pasien/Keluarga', 'Melihat Sendiri'] as $sumber)
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="sumber"
                                        value="{{ $sumber }}" id="sumber_{{ $loop->index }}"
                                        {{ old('sumber') === $sumber ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ $sumber }}</label>
                                </div>
                            @endforeach
                        </div>

                        {{-- Unit & Ruangan --}}
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Unit Terkait *</label>
                                <input type="text" name="unit_terkait" class="form-control" required
                                    value="{{ old('unit_terkait', $kpc->unit_terkait ?? '') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Ruangan Pelapor *</label>
                                <input type="text" name="ruangan" class="form-control" required
                                    value="{{ old('ruangan', $kpc->ruangan ?? '') }}">
                            </div>
                        </div>

                        {{-- Tindakan --}}
                        <div class="mb-3">
                            <label class="form-label">Tindakan yang dilakukan *</label>
                            <textarea name="tindakan" class="form-control" rows="3" required>{{ old('tindakan', $kpc->tindakan ?? '') }}</textarea>
                        </div>

                        {{-- Tindakan oleh --}}
                        <div class="mb-3">
                            <label class="form-label">Tindakan dilakukan oleh *</label>
                            @foreach (['Tim', 'Dokter', 'Perawat'] as $pelaksana)
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="pelaksana"
                                        value="{{ $pelaksana }}" id="pelaksana_{{ $loop->index }}"
                                        {{ old('pelaksana') === $pelaksana ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ $pelaksana }}</label>
                                </div>
                            @endforeach
                        </div>

                        {{-- Nama Inisial --}}
                        <div class="mb-3">
                            <label class="form-label">Nama Inisial Pelapor *</label>
                            <input type="text" name="nama_inisial" class="form-control" required
                                value="{{ old('nama_inisial', $kpc->nama_inisial ?? '') }}">
                        </div>

                        {{-- Upload --}}
                        <div class="mb-3">
                            <label class="form-label">Lampiran Foto (opsional)</label>
                            <input type="file" name="foto[]" class="form-control" multiple accept="image/*">
                            <div class="form-text">Maksimal 5 file. Ukuran maks 100 MB per file.</div>
                        </div>
                    </div>
                </div>
                {{-- FORM END --}}

                {{-- Tombol --}}
                <div class="mb-5">
                    <button type="submit" class="btn btn-success">Simpan</button>
                    <a href="{{ route('insiden.kpc.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </form>
    </div>
@endsection
