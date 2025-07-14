@extends('layouts.main')

@section('title', 'Kuesioner Survei Kepuasan Pasien/Keluarga')

@section('content')
    <div class="container-fluid">
        <div class="card bg-primary-subtle shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-8">Kuesioner Survei Kepuasan Pasien/Keluarga</h4>
                        <p class="mb-0 text-muted">
                            Silakan isi formulir berikut berdasarkan pengalaman Anda.
                        </p>
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

        @if ($errors->has('aktivitas'))
            <div class="alert alert-danger">{{ $errors->first('aktivitas') }}</div>
        @endif

        <div class="card mb-4">
            <div class="card-body">
                <form action="{{ route('kuesioner.store') }}" method="POST">
                    @csrf
                    <h4 class="fw-semibold mb-4 fs-6">Data Responden</h4>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Tanggal Survei<span class="text-danger">*</span></label>
                            <input type="date" name="waktu_survei"
                                class="form-control @error('waktu_survei') is-invalid @enderror"
                                value="{{ old('waktu_survei', date('Y-m-d')) }}">
                            @error('waktu_survei')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Jenis Kelamin<span class="text-danger">*</span></label>
                            <select name="jk" class="form-control form-select @error('jk') is-invalid @enderror">
                                <option value="">-- Pilih --</option>
                                <option value="L">Laki-Laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                            @error('jk')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Usia<span class="text-danger">*</span></label>
                            <input type="number" min="1" name="usia"
                                class="form-control @error('usia') is-invalid @enderror">
                            @error('usia')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Pendidikan<span class="text-danger">*</span></label>
                            <select name="pendidikan"
                                class="form-control form-select @error('pendidikan') is-invalid @enderror">
                                <option value="">-- Pilih --</option>
                                <option value="SD">SD</option>
                                <option value="SMP">SMP</option>
                                <option value="SMA">SMA</option>
                                <option value="S1">S1</option>
                                <option value="S2">S2</option>
                                <option value="S3">S3</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                            @error('pendidikan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Pekerjaan<span class="text-danger">*</span></label>
                            <select name="pekerjaan"
                                class="form-control form-select @error('pekerjaan') is-invalid @enderror">
                                <option value="">-- Pilih --</option>
                                <option value="IRT">IRT</option>
                                <option value="PNS">PNS</option>
                                <option value="GURU">GURU</option>
                                <option value="TNI">TNI</option>
                                <option value="POLRI">POLRI</option>
                                <option value="SWASTA">KARYAWAN SWASTA</option>
                                <option value="WIRAUSAHA">WIRAUSAHA</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                            @error('pekerjaan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Hubungan dengan Pasien<span class="text-danger">*</span></label>
                            <select name="hubungan_pasien"
                                class="form-control form-select @error('hubungan_pasien') is-invalid @enderror">
                                <option value="">-- Pilih --</option>
                                <option value="Pasien">Pasien</option>
                                <option value="Keluarga">Keluarga</option>
                                <option value="Wali">Wali</option>
                            </select>
                            @error('hubungan_pasien')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <hr class="my-4">

                    <h4 class="fw-semibold mb-4 fs-6">Penilaian Kepuasan</h4>

                    <div class="row">
                        <div class="mb-3">
                            <label class="form-label">Ruangan dinilai<span class="text-danger">*</span></label>
                            <select name="ruangan" class="form-control form-select @error('ruangan') is-invalid @enderror">
                                <option value="">Pilih ruangan</option>
                                @foreach (['OK', 'IGD', 'ICU', 'POLI', 'RIA', 'RID', 'PAIDA', 'VIP', 'Kebidanan', 'PONEK', 'NICU', 'FARMASI', 'LABORATORIUM', 'RADIOLOGI', 'GUDANG OBAT'] as $r)
                                    <option value="{{ $r }}">{{ $r }}</option>
                                @endforeach
                            </select>
                            @error('ruangan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Bagaimana pendapat Saudara tentang kesesuaian persyaratan pelayanan
                                dengan jenis pelayanannya<span class="text-danger">*</span></label>
                            <select name="p1" class="form-control form-select @error('p1') is-invalid @enderror">
                                <option value="">Beri Penilaian Anda</option>
                                <option value="1">Tidak Sesuai</option>
                                <option value="2">Kurang Sesuai</option>
                                <option value="3">Sesuai</option>
                                <option value="4">Sangat Sesuai</option>
                            </select>
                            @error('p1')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Bagaimana pendapat Saudara tentang kecepatan waktu dalam memberikan
                                pelayanan<span class="text-danger">*</span></label>
                            <select name="p2" class="form-control form-select @error('p2') is-invalid @enderror">
                                <option value="">Beri Penilaian Anda</option>
                                <option value="1">Tidak Cepat</option>
                                <option value="2">Kurang Cepat</option>
                                <option value="3">Cepat</option>
                                <option value="4">Sangat Cepat</option>
                            </select>
                            @error('p2')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Bagaimana pemahaman Saudara tentang kemudahan prosedur pelayanan di
                                unit ini<span class="text-danger">*</span></label>
                            <select name="p3" class="form-control form-select @error('p3') is-invalid @enderror">
                                <option value="">Beri Penilaian Anda</option>
                                <option value="1">Tidak Mudah</option>
                                <option value="2">Kurang Mudah</option>
                                <option value="3">Mudah</option>
                                <option value="4">Sangat Mudah</option>
                            </select>
                            @error('p3')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Bagaimana pendapat Saudara tentang kewajaran biaya atau tarif dalam
                                pelayanan<span class="text-danger">*</span></label>
                            <select name="p4" class="form-control form-select @error('p4') is-invalid @enderror">
                                <option value="">Beri Penilaian Anda</option>
                                <option value="1">Sangat Mahal</option>
                                <option value="2">Cukup Mahal</option>
                                <option value="3">Murah</option>
                                <option value="4">Gratis</option>
                            </select>
                            @error('p4')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Bagaimana pendapat Saudara tentang kesesuaian produk pelayanan
                                antara yang tercantum dalam standar pelayanan dengan hasil yang diberikan<span
                                    class="text-danger">*</span></label>
                            <select name="p5" class="form-control form-select @error('p5') is-invalid @enderror">
                                <option value="">Beri Penilaian Anda</option>
                                <option value="1">Tidak Sesuai</option>
                                <option value="2">Kurang Sesuai</option>
                                <option value="3">Sesuai</option>
                                <option value="4">Sangat Sesuai</option>
                            </select>
                            @error('p5')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Bagaimana pendapat Saudara tentang kompetensi/ kemampuan petugas
                                dalam pelayanan<span class="text-danger">*</span></label>
                            <select name="p6" class="form-control form-select @error('p6') is-invalid @enderror">
                                <option value="">Beri Penilaian Anda</option>
                                <option value="1">Tidak Kompeten</option>
                                <option value="2">Kurang Kompeten</option>
                                <option value="3">Kompeten</option>
                                <option value="4">Sangat Kompeten</option>
                            </select>
                            @error('p6')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Bagamana pendapat saudara perilaku petugas dalam pelayanan terkait
                                kesopanan dan keramahan<span class="text-danger">*</span></label>
                            <select name="p7" class="form-control form-select @error('p7') is-invalid @enderror">
                                <option value="">Beri Penilaian Anda</option>
                                <option value="1">Tidak Sopan dan Ramah</option>
                                <option value="2">Kurang Sopan dan Ramah</option>
                                <option value="3">Sopan dan Ramah</option>
                                <option value="4">Sangat Sopan dan Ramah</option>
                            </select>
                            @error('p7')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Bagaimana pendapat Saudara tentang kualitas sarana dan
                                prasarana<span class="text-danger">*</span></label>
                            <select name="p8" class="form-control form-select @error('p8') is-invalid @enderror">
                                <option value="">Beri Penilaian Anda</option>
                                <option value="1">Buruk</option>
                                <option value="2">Cukup Baik</option>
                                <option value="3">Baik</option>
                                <option value="4">Sangat Baik</option>
                            </select>
                            @error('p8')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Bagaimana pendapat Saudara tentang penanganan pengaduan pengguna
                                layanan<span class="text-danger">*</span></label>
                            <select name="p9" class="form-control form-select @error('p9') is-invalid @enderror">
                                <option value="">Beri Penilaian Anda</option>
                                <option value="1">Tidak Ada</option>
                                <option value="2">Ada Tapi Tidak Berfungsi</option>
                                <option value="3">Berfungsi Kurang Maksimal</option>
                                <option value="4">Dikelola Dengan Baik</option>
                            </select>
                            @error('p9')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Saran / Masukan</label>
                        <textarea name="saran" rows="4" class="form-control @error('saran') is-invalid @enderror"></textarea>
                        @error('saran')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <hr>

                    <div class="mb-4">
                        <label class="form-label fs-5">Pilih tingkat kepuasan Anda</label>
                        <div class="row text-center">
                            <div class="col">
                                <input type="radio" class="btn-check" name="tingkat_kepuasan" id="sangat_puas"
                                    value="Sangat Puas" required>
                                <label class="btn btn-outline-success" for="sangat_puas">
                                    <div style="font-size: 7rem;">😊</div>
                                    Sangat Puas
                                </label>
                            </div>
                            <div class="col">
                                <input type="radio" class="btn-check" name="tingkat_kepuasan" id="puas" value="Puas">
                                <label class="btn btn-outline-warning" for="puas">
                                    <div style="font-size: 7rem;">😐</div>
                                    Puas
                                </label>
                            </div>
                            <div class="col">
                                <input type="radio" class="btn-check" name="tingkat_kepuasan" id="tidak_puas"
                                    value="Tidak Puas">
                                <label class="btn btn-outline-danger" for="tidak_puas">
                                    <div style="font-size: 7rem;">😞</div>
                                    Tidak Puas
                                </label>
                            </div>
                        </div>
                    </div>
                    <hr>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">Kirim Kuesioner</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
