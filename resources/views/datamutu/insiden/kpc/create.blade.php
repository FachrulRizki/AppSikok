@extends('layouts.main')

@section('title', 'Laporan Insiden KPC')

@section('content')
    <div class="container-fluid">
        <div class="card bg-primary-subtle shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-1">Laporan Insiden Kejadian Potensial Cedera (KPC)</h4>
                        <p class="mb-3 text-muted">
                            Merupakan kondisi yang sangat berpotensi menimbulkan insiden, namun belum terjadi.
                        </p>
                        <nav aria-label="breadcrumb" style="--bs-breadcrumb-divider: '/'">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a class="text-muted text-decoration-none" href="{{ route('dashboard') }}">Beranda</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a class="text-muted text-decoration-none" href="{{ route('insiden') }}">Insiden
                                        Keselamatan Pasien</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a class="text-muted text-decoration-none" href="{{ route('insiden.kpc.index') }}">KPC</a>
                                </li>
                                <li class="breadcrumb-item" aria-current="page">Tambah Laporan</li>
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
        <div class="card mb-4">
            <div class="card-body">
                <form action="{{ route('insiden.kpc.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Inisial Pelapor<span class="text-danger">*</span></label>
                            <input type="text" name="nama_inisial" class="form-control @error('nama_inisial') is-invalid @enderror"
                                value="{{ old('nama_inisial', $kpc->nama_inisial ?? '') }}">
                            @error('nama_inisial')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal & Waktu<span class="text-danger">*</span></label>
                            <input type="datetime-local" name="waktu" class="form-control @error('waktu') is-invalid @enderror"
                                value="{{ old('waktu', isset($kpc) ? $kpc->waktu->format('Y-m-d\TH:i') : '') }}">
                            @error('waktu')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Unit Terkait<span class="text-danger">*</span></label>
                            <input type="text" name="unit_terkait" class="form-control @error('unit_terkait') is-invalid @enderror"
                                value="{{ old('unit_terkait', $kpc->unit_terkait ?? '') }}">
                            @error('unit_terkait')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Ruangan Pelapor<span class="text-danger">*</span></label>
                            <input type="text" name="ruangan" class="form-control @error('ruangan') is-invalid @enderror"
                                value="{{ old('ruangan', $kpc->ruangan ?? '') }}">
                            @error('ruangan')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    

                    <div class="mb-3">
                        <label class="form-label">Temuan Kejadian/Insiden<span class="text-danger">*</span></label>
                        <textarea name="temuan" class="form-control @error('temuan') is-invalid @enderror" rows="3">
                            {{ old('temuan', $kpc->temuan ?? '') }}
                        </textarea>
                        @error('temuan')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Kronologis Insiden<span class="text-danger">*</span></label>
                        <textarea name="kronologis" class="form-control @error('kronologis') is-invalid @enderror" rows="4">
                            {{ old('kronologis', $kpc->kronologis ?? '') }}
                        </textarea>
                        @error('kronologis')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Sumber Informasi<span class="text-danger">*</span></label>
                            @foreach (['Karyawan', 'Pasien/Keluarga', 'Melihat Sendiri'] as $sumber)
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="sumber" value="{{ $sumber }}"
                                        id="sumber_{{ $loop->index }}" {{ old('sumber') === $sumber ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ $sumber }}</label>
                                </div>
                            @endforeach
                            @error('sumber')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tindakan dilakukan oleh<span class="text-danger">*</span></label>
                            @foreach (['Tim', 'Dokter', 'Perawat'] as $pelaksana)
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="pelaksana" value="{{ $pelaksana }}"
                                        id="pelaksana_{{ $loop->index }}"
                                        {{ old('pelaksana') === $pelaksana ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ $pelaksana }}</label>
                                </div>
                            @endforeach
                            @error('pelaksana')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tindakan yang dilakukan<span class="text-danger">*</span></label>
                        <textarea name="tindakan" class="form-control @error('tindakan') is-invalid @enderror" rows="3">{{ old('tindakan', $kpc->tindakan ?? '') }}</textarea>
                        @error('tindakan')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Lampiran Foto (opsional)</label>
                        <input type="file" name="foto[]" class="form-control @error('foto') is-invalid @enderror" multiple accept="image/*">
                        <div class="form-text">Maksimal 5 file. Ukuran maks 100 MB per file.</div>
                        @error('foto')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="d-flex gap-3 mt-4">
                        <button class="btn btn-primary" type="submit">Simpan</button>
                        <a href="{{ route('insiden.kpc.index') }}" class="btn bg-primary-subtle text-primary">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
