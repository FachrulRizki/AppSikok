@extends('layouts.main')

@section('title', 'Detail Respon Kuesioner')

@section('content')
    <div class="container-fluid">
        <div class="card bg-primary-subtle shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-8">Kuesioner Survei Kepuasan Pasien/Keluarga</h4>
                        <p class="mb-0 text-muted">
                            Detail respon penilaian kepuasan pasien atau keluarga
                        </p>
                    </div>
                    <div class="col-3">
                        <div class="text-center mb-n5">
                            <img src="{{ asset('assets/images/backgrounds/welcome-doctors.svg') }}" alt="modernize-img" class="img-fluid mb-n4" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @can('kuesioner.list')
            <div class="d-flex gap-2 mb-4">
                <a href="{{ route('kuesioner.index') }}" class="btn bg-primary-subtle text-primary">Kembali</a>
            </div>
        @endcan

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="row">
            <div class="col-md-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-3">Detail Responden</h4>
                        <div class="table-responsive">
                            <table class="w-100 text-nowrap">
                                <tbody>
                                    <tr>
                                        <th class="pb-2 text-start">Tanggal Survei</th>
                                        <td class="pb-2 text-end">{{ $kuesioner->waktu_survei->format('d-m-Y') }}</td>
                                    </tr>
                                    <tr>
                                        <th class="py-2 text-start">Jenis Kelamin</th>
                                        <td class="py-2 text-end">{{ $kuesioner->jk == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="py-2 text-start">Usia</th>
                                        <td class="py-2 text-end">{{ $kuesioner->usia }} Tahun</td>
                                    </tr>
                                    <tr>
                                        <th class="py-2 text-start">Pendidikan</th>
                                        <td class="py-2 text-end">{{ $kuesioner->pendidikan }}</td>
                                    </tr>
                                    <tr>
                                        <th class="py-2 text-start">Pekerjaan</th>
                                        <td class="py-2 text-end">{{ $kuesioner->pekerjaan }}</td>
                                    </tr>
                                    <tr>
                                        <th class="py-2 text-start">Hubungan dengan Pasien</th>
                                        <td class="py-2 text-end">{{ $kuesioner->hubungan_pasien }}</td>
                                    </tr>
                                    <tr>
                                        <th class="pt-2 text-start">Ruangan dinilai</th>
                                        <td class="pt-2 text-end">{{ $kuesioner->ruangan }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-3">Saran/Masukan</h4>
                        <p class="mb-0">{{ $kuesioner->saran ?? 'Tidak ada saran/masukan' }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-7">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-3">Penilaian Kepuasan</h4>
                        <div class="pb-3 mb-3 border-bottom">
                            <label class="form-label">Bagaimana pendapat Saudara tentang kesesuaian persyaratan pelayanan dengan jenis pelayanannya</label>
                            <div>Skor: {{ $kuesioner->p1 }}</div>
                        </div>
                        <div class="pb-3 mb-3 border-bottom">
                            <label class="form-label">Bagaimana pendapat Saudara tentang kecepatan waktu dalam memberikan pelayanan</label>
                            <div>Skor: {{ $kuesioner->p2 }}</div>
                        </div>
                        <div class="pb-3 mb-3 border-bottom">
                            <label class="form-label">Bagaimana pemahaman Saudara tentang kemudahan prosedur pelayanan di unit ini</label>
                            <div>Skor: {{ $kuesioner->p3 }}</div>
                        </div>
                        <div class="pb-3 mb-3 border-bottom">
                            <label class="form-label">Bagaimana pendapat Saudara tentang kewajaran biaya atau tarif dalam pelayanan</label>
                            <div>Skor: {{ $kuesioner->p4 }}</div>
                        </div>
                        <div class="pb-3 mb-3 border-bottom">
                            <label class="form-label">Bagaimana pendapat Saudara tentang kesesuaian produk pelayanan antara yang tercantum dalam standar pelayanan dengan hasil yang diberikan</label>
                            <div>Skor: {{ $kuesioner->p5 }}</div>
                        </div>
                        <div class="pb-3 mb-3 border-bottom">
                            <label class="form-label">Bagaimana pendapat Saudara tentang kompetensi/ kemampuan petugas dalam pelayanan</label>
                            <div>Skor: {{ $kuesioner->p6 }}</div>
                        </div>
                        <div class="pb-3 mb-3 border-bottom">
                            <label class="form-label">Bagamana pendapat saudara perilaku petugas dalam pelayanan terkait kesopanan dan keramahan</label>
                            <div>Skor: {{ $kuesioner->p7 }}</div>
                        </div>
                        <div class="pb-3 mb-3 border-bottom">
                            <label class="form-label">Bagaimana pendapat Saudara tentang kualitas sarana dan prasarana</label>
                            <div>Skor: {{ $kuesioner->p8 }}</div>
                        </div>
                        <div>
                            <label class="form-label">Bagaimana pendapat Saudara tentang penanganan pengaduan pengguna layanan</label>
                            <div>Skor: {{ $kuesioner->p9 }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
