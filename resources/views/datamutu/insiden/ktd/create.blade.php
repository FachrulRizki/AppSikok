@extends('layouts.main')

@section('title', 'Laporan Insiden KTD')

@section('content')
    <div class="container-fluid">
        <div class="card bg-primary-subtle shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-1">Laporan Insiden Kejadian Tidak Diinginkan (KTD)</h4>
                        <p class="mb-3 text-muted">
                            Merupakan insiden yang sudah terjadi yang mengakibatkan cedera.
                        </p>
                        <nav aria-label="breadcrumb" style="--bs-breadcrumb-divider: '/'">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a class="text-muted text-decoration-none" href="{{ route('dashboard') }}">Beranda</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a class="text-muted text-decoration-none" href="{{ route('insiden') }}">Insiden Keselamatan Pasien</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a class="text-muted text-decoration-none" href="{{ route('insiden.ktd.index') }}">KTD</a>
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

        <div class="card">
            <div class="card-body">
                <form action="{{ route('insiden.ktd.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <h4 class="fw-semibold mb-4 fs-6">Data Pasien</h4>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">No. RM<span class="text-danger">*</span></label>
                            <input type="text" name="no_rm" class="form-control @error('no_rm') is-invalid @enderror" value="{{ old('no_rm', $ktd->no_rm ?? '') }}">
                            @error('no_rm')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nama Pasien<span class="text-danger">*</span></label>
                            <input type="text" name="nama_pasien" class="form-control @error('nama_pasien') is-invalid @enderror" value="{{ old('nama_pasien', $ktd->nama_pasien ?? '') }}">
                            @error('nama_pasien')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Umur<span class="text-danger">*</span></label>
                            <input type="number" min="0" name="umur" class="form-control @error('umur') is-invalid @enderror" value="{{ old('umur', $ktd->umur ?? '') }}">
                            @error('umur')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Jenis Kelamin<span class="text-danger">*</span></label>
                            <select name="jk" class="form-control @error('jk') is-invalid @enderror">
                                <option value="">-- Pilih --</option>
                                <option value="Laki-Laki" {{ old('jk', $ktd->jk ?? '') == 'Laki-Laki' ? 'selected' : '' }}>
                                    Laki-Laki</option>
                                <option value="Perempuan" {{ old('jk', $ktd->jk ?? '') == 'Perempuan' ? 'selected' : '' }}>
                                    Perempuan</option>
                            </select>
                            @error('jk')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Tanggal & Waktu Masuk RS</label>
                            <input type="datetime-local" name="waktu_mskrs" class="form-control @error('waktu_mskrs') is-invalid @enderror" value="{{ old('waktu_mskrs', isset($ktd) ? $ktd->waktu_mskrs->format('Y-m-d\TH:i') : '') }}">
                            @error('waktu_mskrs')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <hr class="my-4">

                    <h4 class="fw-semibold mb-4 fs-6">Rincian Kejadian</h4>

                    <div class="mb-3">
                        <label class="form-label">Tanggal dan Waktu Insiden</label>
                        <input type="datetime-local" name="waktu_insiden" class="form-control @error('waktu_insiden') is-invalid @enderror" value="{{ old('waktu_insiden', isset($ktd) ? $ktd->waktu_insiden->format('Y-m-d\TH:i') : '') }}">
                        @error('waktu_insiden')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Temuan Kejadian/Insiden<span class="text-danger">*</span></label>
                            <textarea name="temuan" class="form-control @error('temuan') is-invalid @enderror" rows="4">{{ old('temuan', $ktd->temuan ?? '') }}</textarea>
                            @error('temuan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Kronologis Insiden<span class="text-danger">*</span></label>
                            <textarea name="kronologis" class="form-control @error('kronologis') is-invalid @enderror" rows="4">{{ old('kronologis', $ktd->kronologis ?? '') }}</textarea>
                            @error('kronologis')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label class="form-label">Insiden Terjadi Pada<span class="text-danger">*</span></label>
                            <input type="text" name="unit_terkait" class="form-control @error('unit_terkait') is-invalid @enderror" value="{{ old('unit_terkait', $ktd->unit_terkait ?? '') }}">
                            @error('unit_terkait')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Sumber Informasi<span class="text-danger">*</span></label>
                            <select name="sumber" class="form-control @error('sumber') is-invalid @enderror">
                                <option value="">-- Pilih --</option>
                                <option value="Karyawan"
                                    {{ old('sumber', $ktd->sumber ?? '') == 'Karyawan' ? 'selected' : '' }}>
                                    Karyawan</option>
                                <option value="Pasien/Keluarga"
                                    {{ old('sumber', $ktd->sumber ?? '') == 'Pasien/Keluarga' ? 'selected' : '' }}>
                                    Pasien/Keluarga</option>
                                <option value="Pengunjung"
                                    {{ old('sumber', $ktd->sumber ?? '') == 'Pengunjung' ? 'selected' : '' }}>
                                    Pengunjung</option>
                                <option value="Melihat Sendiri"
                                    {{ old('sumber', $ktd->sumber ?? '') == 'Melihat Sendiri' ? 'selected' : '' }}>
                                    Melihat Sendiri</option>
                            </select>
                            @error('sumber')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Insiden Menyangkut Pasien<span class="text-danger">*</span></label>
                            <select name="rawat" class="form-control @error('rawat') is-invalid @enderror">
                                <option value="">-- Pilih --</option>
                                <option value="Pasien Rawat Inap"
                                    {{ old('rawat', $ktd->rawat ?? '') == 'Pasien Rawat Inap' ? 'selected' : '' }}>
                                    Pasien Rawat Inap</option>
                                <option value="Pasien Rawat Jalan"
                                    {{ old('rawat', $ktd->rawat ?? '') == 'Pasien Rawat Jalan' ? 'selected' : '' }}>
                                    Pasien Rawat Jalan</option>
                                <option value="Pasien IGD"
                                    {{ old('rawat', $ktd->rawat ?? '') == 'Pasien IGD' ? 'selected' : '' }}>
                                    Pasien IGD</option>
                            </select>
                            @error('rawat')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Insiden Terjadi Pada Pasien<span class="text-danger">*</span></label>
                            <select name="poli" class="form-control @error('poli') is-invalid @enderror">
                                <option value="">-- Pilih --</option>
                                <option value="Penyakit Dalam"
                                    {{ old('poli', $ktd->poli ?? '') == 'Penyakit Dalam' ? 'selected' : '' }}>
                                    Penyakit Dalam</option>
                                <option value="Anak" {{ old('poli', $ktd->poli ?? '') == 'Anak' ? 'selected' : '' }}>
                                    Anak</option>
                                <option value="Bedah" {{ old('poli', $ktd->poli ?? '') == 'Bedah' ? 'selected' : '' }}>
                                    Bedah</option>
                                <option value="OBGYN" {{ old('poli', $ktd->poli ?? '') == 'OBGYN' ? 'selected' : '' }}>
                                    OBGYN</option>
                                <option value="THT" {{ old('poli', $ktd->poli ?? '') == 'THT' ? 'selected' : '' }}>
                                    THT</option>
                                <option value="Mata" {{ old('poli', $ktd->poli ?? '') == 'Mata' ? 'selected' : '' }}>
                                    Mata</option>
                                <option value="Saraf" {{ old('poli', $ktd->poli ?? '') == 'Saraf' ? 'selected' : '' }}>
                                    Saraf</option>
                                <option value="Anastesi"
                                    {{ old('poli', $ktd->poli ?? '') == 'Anastesi' ? 'selected' : '' }}>
                                    Anastesi</option>
                                <option value="Kulit dan Kelamin"
                                    {{ old('poli', $ktd->poli ?? '') == 'Kulit dan Kelamin' ? 'selected' : '' }}>
                                    Kulit dan Kelamin</option>
                                <option value="Jantung"
                                    {{ old('poli', $ktd->poli ?? '') == 'Jantung' ? 'selected' : '' }}>
                                    Jantung</option>
                                <option value="Paru" {{ old('poli', $ktd->poli ?? '') == 'Paru' ? 'selected' : '' }}>
                                    Paru</option>
                                <option value="Jiwa" {{ old('poli', $ktd->poli ?? '') == 'Jiwa' ? 'selected' : '' }}>
                                    Jiwa</option>
                                <option value="MCU" {{ old('poli', $ktd->poli ?? '') == 'MCU' ? 'selected' : '' }}>
                                    MCU</option>
                            </select>
                            <small class="form-text">Sesuai kasus penyakit</small>
                            @error('poli')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Unit Terkait KTD<span class="text-danger">*</span></label>
                            <textarea name="lokasi" class="form-control" rows="4">{{ old('lokasi', $ktd->lokasi ?? '') }}</textarea>
                            @error('lokasi')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tindakan Yang Dilakukan Segera Setelah Kejadian & Hasilnya<span class="text-danger">*</span></label>
                            <textarea name="tindakan_segera" class="form-control @error('tindakan_segera') is-invalid @enderror" rows="4">{{ old('tindakan_segera', $ktd->tindakan_segera ?? '') }}</textarea>
                            @error('tindakan_segera')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Tindakan Dilakukan Oleh<span class="text-danger">*</span></label>
                            <select name="pelaksana" class="form-control @error('pelaksana') is-invalid @enderror">
                                <option value="">-- Pilih --</option>
                                <option value="Tim"
                                    {{ old('pelaksana', $ktd->pelaksana ?? '') == 'Tim' ? 'selected' : '' }}>
                                    Tim</option>
                                <option value="Dokter"
                                    {{ old('pelaksana', $ktd->pelaksana ?? '') == 'Dokter' ? 'selected' : '' }}>
                                    Dokter</option>
                                <option value="Perawat"
                                    {{ old('pelaksana', $ktd->pelaksana ?? '') == 'Perawat' ? 'selected' : '' }}>
                                    Perawat</option>
                            </select>
                            @error('pelaksana')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Akibat Insiden Terhadap Pasien<span class="text-danger">*</span></label>
                            <select name="akibat" class="form-control @error('akibat') is-invalid @enderror">
                                <option value="">-- Pilih --</option>
                                <option value="Kematian"
                                    {{ old('akibat', $ktd->akibat ?? '') == 'Kematian' ? 'selected' : '' }}>
                                    Kematian</option>
                                <option value="CederaBerat"
                                    {{ old('akibat', $ktd->akibat ?? '') == 'CederaBerat' ? 'selected' : '' }}>
                                    Cedera Berat</option>
                                <option value="CederaSedang"
                                    {{ old('akibat', $ktd->akibat ?? '') == 'CederaSedang' ? 'selected' : '' }}>
                                    Cedera Sedang</option>
                                <option value="CederaRingan"
                                    {{ old('akibat', $ktd->akibat ?? '') == 'CederaRingan' ? 'selected' : '' }}>
                                    Cedera Ringan</option>
                            </select>
                            @error('akibat')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama Inisial Pelapor<span class="text-danger">*</span></label>
                            <input type="text" name="nama_inisial" class="form-control @error('nama_inisial') is-invalid @enderror" value="{{ old('nama_inisial', $ktd->nama_inisial ?? '') }}">
                            @error('nama_inisial')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Ruangan Pelapor<span class="text-danger">*</span></label>
                            <input type="text" name="ruangan_pelapor" class="form-control @error('ruangan_pelapor') is-invalid @enderror" value="{{ old('ruangan_pelapor', $ktd->ruangan_pelapor ?? '') }}">
                            @error('ruangan_pelapor')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
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
                        <a href="{{ route('insiden.ktd.index') }}" class="btn bg-primary-subtle text-primary">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
