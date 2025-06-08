@extends('layouts.main')

@section('title', 'Kuesioner Survei Kepuasan Pasien/Keluarga')

@section('content')
    <div class="container">
        <form action="{{ route('kuisoner.store') }}" method="POST">
            @csrf

            <div class="container-fluid">
                <div class="card bg-primary-subtle shadow-none position-relative overflow-hidden mb-4">
                    <div class="card-body px-4 py-3">
                        <div class="row align-items-center">
                            <div class="col-9">
                                <h4 class="fw-semibold mb-2">Kuesioner Survei Kepuasan Pasien/Keluarga</h4>
                                <p class="mb-0 text-muted">Silakan isi formulir berikut berdasarkan pengalaman Anda.</p>
                            </div>
                            <div class="col-3 text-end">
                                <img src="{{ asset('assets/images/backgrounds/welcome-doctors.svg') }}" alt="survey"
                                    class="img-fluid" style="max-height: 100px;">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- FORM START --}}
                <div class="card mb-4">
                    <div class="card-body">

                        {{-- Identitas --}}
                        <h4>Data Responden</h4><br>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Tanggal dan Waktu Survei</label>
                                <input type="datetime-local" name="waktu_survei" class="form-control" id="waktuSurvei"
                                    value="{{ old('waktu_survei', isset($knc) ? $knc->waktu_survei->format('Y-m-d\TH:i') : '') }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Jenis Kelamin</label>
                                <select name="jk" class="form-control" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="Laki-Laki">Laki-Laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Usia</label>
                                <input type="number" name="usia" class="form-control" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Pendidikan</label>
                                <select name="pendidikan" class="form-control" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="SD">SD</option>
                                    <option value="SMP">SMP</option>
                                    <option value="SMA">SMA</option>
                                    <option value="S1">S1</option>
                                    <option value="S2">S2</option>
                                    <option value="S3">S3</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Pekerjaan</label>
                                <select name="pekerjaan" class="form-control" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="PNS">PNS</option>
                                    <option value="POLRI">POLRI</option>
                                    <option value="SWASTA">KARYAWAN SWASTA</option>
                                    <option value="WIRAUSAHA">WIRAUSAHA</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Hubungan dengan Pasien</label>
                                <select name="hubungan_pasien" class="form-control" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="Pasien">Pasien</option>
                                    <option value="Keluarga">Keluarga</option>
                                    <option value="Wali">Wali</option>
                                </select>
                            </div>
                        </div>

                        <hr>
                        {{-- Pertanyaan Kuesioner --}}
                        <h4>Penilaian Kepuasan</h4><br>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Bagaimana pendapat Saudara tentang kesesuaian persyaratan
                                    pelayanan dengan jenis pelayanannya.</label>
                                <select name="p1" class="form-control" required>
                                    <option value="">Beri Penilaian Anda</option>
                                    <option value="1">Tidak Sesuai</option>
                                    <option value="2">Kurang Sesuai</option>
                                    <option value="3">Sesuai</option>
                                    <option value="4">Sangat Sesuai</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Bagaimana pendapat Saudara tentang kecepatan waktu dalam
                                    memberikan pelayanan.</label>
                                <select name="p2" class="form-control" required>
                                    <option value="">Beri Penilaian Anda</option>
                                    <option value="1">Tidak Cepat</option>
                                    <option value="2">Kurang Cepat</option>
                                    <option value="3">Cepat</option>
                                    <option value="4">Sangat Cepat</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Bagaimana pemahaman Saudara tentang kemudahan prosedur pelayanan
                                    di unit ini.</label>
                                <select name="p3" class="form-control" required>
                                    <option value="">Beri Penilaian Anda</option>
                                    <option value="1">Tidak Mudah</option>
                                    <option value="2">Kurang Mudah</option>
                                    <option value="3">Mudah</option>
                                    <option value="4">Sangat Mudah</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Bagaimana pendapat Saudara tentang kewajaran biaya atau tarif
                                    dalam pelayanan.</label>
                                <select name="p4" class="form-control" required>
                                    <option value="">Beri Penilaian Anda</option>
                                    <option value="1">Sangat Mahal</option>
                                    <option value="2">Cukup Mahal</option>
                                    <option value="3">Murah</option>
                                    <option value="4">Gratis</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Bagaimana pendapat Saudara tentang kesesuaian produk pelayanan
                                    antara yang tercantum dalam standar pelayanan dengan hasil yang diberikan.</label>
                                <select name="p5" class="form-control" required>
                                    <option value="">Beri Penilaian Anda</option>
                                    <option value="1">Tidak Sesuai</option>
                                    <option value="2">Kurang Sesuai</option>
                                    <option value="3">Sesuai</option>
                                    <option value="4">Sangat Sesuai</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Bagaimana pendapat Saudara tentang kompetensi/ kemampuan petugas dalam pelayanan.</label>
                                <select name="p6" class="form-control" required>
                                    <option value="">Beri Penilaian Anda</option>
                                    <option value="1">Tidak Kompeten</option>
                                    <option value="2">Kurang Kompeten</option>
                                    <option value="3">Kompeten</option>
                                    <option value="4">Sangat Kompeten</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Bagamana pendapat saudara perilaku petugas dalam pelayanan terkait kesopanan dan keramahan.</label>
                                <select name="p7" class="form-control" required>
                                    <option value="">Beri Penilaian Anda</option>
                                    <option value="1">Tidak Sopan dan Ramah</option>
                                    <option value="2">Kurang Sopan dan Ramah</option>
                                    <option value="3">Sopan dan Ramah</option>
                                    <option value="4">Sangat Sopan dan Ramah</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Bagaimana pendapat Saudara tentang kualitas sarana dan prasarana.</label>
                                <select name="p8" class="form-control" required>
                                    <option value="">Beri Penilaian Anda</option>
                                    <option value="1">Buruk</option>
                                    <option value="2">Cukup Baik</option>
                                    <option value="3">Baik</option>
                                    <option value="4">Sangat Baik</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Bagaimana pendapat Saudara tentang penanganan pengaduan pengguna layanan.</label>
                                <select name="p9" class="form-control" required>
                                    <option value="">Beri Penilaian Anda</option>
                                    <option value="1">Tidak Ada</option>
                                    <option value="2">Ada Tapi Tidak Berfungsi</option>
                                    <option value="3">Berfungsi Kurang Maksimal</option>
                                    <option value="4">Dikelola Dengan Baik</option>
                                </select>
                            </div>
                        </div>


                        {{-- Saran / Kritik --}}
                        <div class="mb-3">
                            <label class="form-label">Saran / Masukan</label>
                            <textarea name="saran" rows="4" class="form-control"></textarea>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Kirim Kuesioner</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const input = document.getElementById('waktuSurvei');

                // Cek apakah input belum memiliki nilai (agar tidak timpa data edit)
                if (!input.value) {
                    const now = new Date();
                    const year = now.getFullYear();
                    const month = String(now.getMonth() + 1).padStart(2, '0');
                    const day = String(now.getDate()).padStart(2, '0');
                    const hour = String(now.getHours()).padStart(2, '0');
                    const minute = String(now.getMinutes()).padStart(2, '0');

                    // Format: yyyy-MM-ddTHH:mm (untuk input type datetime-local)
                    const localDatetime = `${year}-${month}-${day}T${hour}:${minute}`;
                    input.value = localDatetime;
                }
            });
        </script>
    </div>
@endsection
