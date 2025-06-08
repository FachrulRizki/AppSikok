@extends('layouts.main')

@section('title', 'Laporan Insiden KTC')

@section('content')
    <div class="container">
        <form action="{{ route('insiden.ktc.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="container-fluid">
                <div class="card bg-primary-subtle shadow-none position-relative overflow-hidden mb-4">
                    <div class="card-body px-4 py-3">
                        <div class="row align-items-center">
                            <div class="col-9">
                                <h4 class="fw-semibold mb-2">Kejadian Tidak Cedera (KTC)</h4>
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
                                        <li class="breadcrumb-item active" aria-current="page">KTC</li>
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

                        {{-- No RM & Nama Pasien --}}
                        <h4>Data Pasien</h4><br>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">No RM</label>
                                <input type="text" name="no_rm" class="form-control" required
                                    value="{{ old('no_rm', $ktc->no_rm ?? '') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nama Pasien</label>
                                <input type="text" name="nama_pasien" class="form-control" required
                                    value="{{ old('nama_pasien', $ktc->nama_pasien ?? '') }}">
                            </div>
                        </div>

                        {{-- Umur & JK --}}
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Umur</label>
                                <input type="text" name="umur" class="form-control" required
                                    value="{{ old('umur', $ktc->umur ?? '') }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Jenis Kelamin</label>
                                <select name="jk" class="form-control" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="Laki-Laki"
                                        {{ old('jk', $ktc->jk ?? '') == 'Laki-Laki' ? 'selected' : '' }}>Laki-Laki</option>
                                    <option value="Perempuan"
                                        {{ old('jk', $ktc->jk ?? '') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Tanggal dan Waktu Masuk RS</label>
                                <input type="datetime-local" name="waktu_mskrs" class="form-control"
                                    value="{{ old('waktu_mskrs', isset($ktc) ? $ktc->waktu_mskrs->format('Y-m-d\TH:i') : '') }}">
                            </div>
                        </div>
                        <hr>

                        {{-- Tanggal dan Waktu Insiden --}}
                        <h4>Rincian Kejadian</h4><br>
                        <div class="mb-3">
                            <label class="form-label">Tanggal dan Waktu Insiden</label>
                            <input type="datetime-local" name="waktu_insiden" class="form-control"
                                value="{{ old('waktu_insiden', isset($ktc) ? $ktc->waktu_insiden->format('Y-m-d\TH:i') : '') }}">
                        </div>

                        {{-- Temuan Kejadian & Kronologis --}}
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Temuan Kejadian/Insiden *</label>
                                <textarea name="temuan" class="form-control" rows="4" required>{{ old('temuan', $ktc->temuan ?? '') }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Kronologis Insiden *</label>
                                <textarea name="kronologis" class="form-control" rows="4" required>{{ old('kronologis', $ktc->kronologis ?? '') }}</textarea>
                            </div>
                        </div>

                        {{-- Unit & Ruangan --}}
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label">Insiden Terjadi Pada *</label>
                                <input type="text" name="unit_terkait" class="form-control" required
                                    value="{{ old('unit_terkait', $ktc->unit_terkait ?? '') }}">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Sumber Informasi *</label>
                                <select name="sumber" class="form-control" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="Karyawan"
                                        {{ old('sumber', $ktc->sumber ?? '') == 'Karyawan' ? 'selected' : '' }}>
                                        Karyawan</option>
                                    <option value="Pasien/Keluarga"
                                        {{ old('sumber', $ktc->sumber ?? '') == 'Pasien/Keluarga' ? 'selected' : '' }}>
                                        Pasien/Keluarga</option>
                                    <option value="Pengunjung"
                                        {{ old('sumber', $ktc->sumber ?? '') == 'Pengunjung' ? 'selected' : '' }}>
                                        Pengunjung</option>
                                    <option value="Melihat Sendiri"
                                        {{ old('sumber', $ktc->sumber ?? '') == 'Melihat Sendiri' ? 'selected' : '' }}>
                                        Melihat Sendiri</option>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Insiden Menyangkut Pasien *</label>
                                <select name="rawat" class="form-control" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="Pasien Rawat Inap"
                                        {{ old('rawat', $ktc->rawat ?? '') == 'Pasien Rawat Inap' ? 'selected' : '' }}>
                                        Pasien Rawat Inap</option>
                                    <option value="Pasien Rawat Jalan"
                                        {{ old('rawat', $ktc->rawat ?? '') == 'Pasien Rawat Jalan' ? 'selected' : '' }}>
                                        Pasien Rawat Jalan</option>
                                    <option value="Pasien IGD"
                                        {{ old('rawat', $ktc->rawat ?? '') == 'Pasien IGD' ? 'selected' : '' }}>
                                        Pasien IGD</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Insiden Terjadi Pada Pasien: ( Sesuai Kasus Penyakit )*</label>
                                <select name="poli" class="form-control" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="Penyakit Dalam"
                                        {{ old('poli', $ktc->poli ?? '') == 'Penyakit Dalam' ? 'selected' : '' }}>
                                        Penyakit Dalam</option>
                                    <option value="Anak"
                                        {{ old('poli', $ktc->poli ?? '') == 'Anak' ? 'selected' : '' }}>
                                        Anak</option>
                                    <option value="Bedah"
                                        {{ old('poli', $ktc->poli ?? '') == 'Bedah' ? 'selected' : '' }}>
                                        Bedah</option>
                                    <option value="OBGYN"
                                        {{ old('poli', $ktc->poli ?? '') == 'OBGYN' ? 'selected' : '' }}>
                                        OBGYN</option>
                                    <option value="THT" {{ old('poli', $ktc->poli ?? '') == 'THT' ? 'selected' : '' }}>
                                        THT</option>
                                    <option value="Mata"
                                        {{ old('poli', $ktc->poli ?? '') == 'Mata' ? 'selected' : '' }}>
                                        Mata</option>
                                    <option value="Saraf"
                                        {{ old('poli', $ktc->poli ?? '') == 'Saraf' ? 'selected' : '' }}>
                                        Saraf</option>
                                    <option value="Anastesi"
                                        {{ old('poli', $ktc->poli ?? '') == 'Anastesi' ? 'selected' : '' }}>
                                        Anastesi</option>
                                    <option value="Kulit dan Kelamin"
                                        {{ old('poli', $ktc->poli ?? '') == 'Kulit dan Kelamin' ? 'selected' : '' }}>
                                        Kulit dan Kelamin</option>
                                    <option value="Jantung"
                                        {{ old('poli', $ktc->poli ?? '') == 'Jantung' ? 'selected' : '' }}>
                                        Jantung</option>
                                    <option value="Paru"
                                        {{ old('poli', $ktc->poli ?? '') == 'Paru' ? 'selected' : '' }}>
                                        Paru</option>
                                    <option value="Jiwa"
                                        {{ old('poli', $ktc->poli ?? '') == 'Jiwa' ? 'selected' : '' }}>
                                        Jiwa</option>
                                    <option value="MCU" {{ old('poli', $ktc->poli ?? '') == 'MCU' ? 'selected' : '' }}>
                                        MCU</option>
                                </select>
                            </div>
                        </div>

                        {{-- Unit Terkait ktc --}}
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label">Lokasi Kejadian *</label>
                                <textarea name="lokasi" class="form-control" rows="4" required>{{ old('lokasi', $ktc->lokasi ?? '') }}</textarea>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Unit Terkait Yang Menyebabkan Insiden *</label>
                                <textarea name="unit" class="form-control" rows="4" required>{{ old('unit', $ktc->unit ?? '') }}</textarea>
                            </div>
                            <div class="col-md-5">
                                <label class="form-label">Tindakan Yang Dilakukan Segera Setelah Kejadian & Hasilnya *</label>
                                <textarea name="tindakan_segera" class="form-control" rows="4" required>{{ old('tindakan_segera', $ktc->tindakan_segera ?? '') }}</textarea>
                            </div>
                        </div>

                        {{-- Tindakan oleh --}}
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Tindakan Dilakukan Oleh *</label>
                                <select name="pelaksana" class="form-control" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="Tim"
                                        {{ old('pelaksana', $ktc->pelaksana ?? '') == 'Tim' ? 'selected' : '' }}>
                                        Tim</option>
                                    <option value="Dokter"
                                        {{ old('pelaksana', $ktc->pelaksana ?? '') == 'Dokter' ? 'selected' : '' }}>
                                        Dokter</option>
                                    <option value="Perawat"
                                        {{ old('pelaksana', $ktc->pelaksana ?? '') == 'Perawat' ? 'selected' : '' }}>
                                        Perawat</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Nama Inisial Pelapor *</label>
                                <input type="text" name="nama_inisial" class="form-control" required
                                    value="{{ old('nama_inisial', $ktc->nama_inisial ?? '') }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Ruangan Pelapor *</label>
                                <input type="text" name="ruangan_pelapor" class="form-control" required
                                    value="{{ old('ruangan_pelapor', $ktc->ruangan_pelapor ?? '') }}">
                            </div>
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
                    <a href="{{ route('insiden.ktc.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </form>
    </div>
@endsection
