@extends('layouts.main')

@section('title', 'Detail Laporan KNC')

@section('content')
    <div class="container-fluid">
        <div class="card bg-primary-subtle shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-1">Laporan Insiden Kejadian Nyaris Cedera (KNC)</h4>
                        <p class="mb-3 text-muted">
                            Merupakan insiden yang belum sampai terpapar kepada pasien dan tidak menimbulkan cedera.
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
                                    <a class="text-muted text-decoration-none"
                                        href="{{ route('insiden.knc.index') }}">KNC</a>
                                </li>
                                <li class="breadcrumb-item" aria-current="page">Detail Laporan</li>
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
            <a href="{{ route('insiden.knc.index') }}" class="btn bg-primary-subtle text-primary">Kembali</a>
        </div>

        <div class="row">
            <div class="col-md-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-3">Detail Pasien</h4>
                        <div class="table-responsive">
                            <table class="w-100 text-nowrap">
                                <tbody>
                                    <tr>
                                        <th class="pb-2 text-start">No. RM</th>
                                        <td class="pb-2 text-end">{{ $knc->no_rm }}</td>
                                    </tr>
                                    <tr>
                                        <th class="py-2 text-start">Nama Pasien</th>
                                        <td class="py-2 text-end">{{ $knc->nama_pasien }}</td>
                                    </tr>
                                    <tr>
                                        <th class="py-2 text-start">Umur</th>
                                        <td class="py-2 text-end">{{ $knc->umur }}</td>
                                    </tr>
                                    <tr>
                                        <th class="py-2 text-start">Jenis Kelamin</th>
                                        <td class="py-2 text-end">{{ $knc->jk }}</td>
                                    </tr>
                                    <tr>
                                        <th class="pt-2 text-start">Waktu Masuk RS</th>
                                        <td class="pt-2 text-end">
                                            {{ $knc->waktu_mskrs ? $knc->waktu_mskrs->format('d-m-Y H:i') . ' WIB' : '-' }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-3">Detail Insiden</h4>
                        <div class="table-responsive">
                            <table class="w-100 text-nowrap">
                                <tbody>
                                    <tr>
                                        <th class="pb-2 text-start">Tanggal & Waktu Insiden</th>
                                        <td class="pb-2 text-end">
                                            {{ $knc->waktu_insiden ? $knc->waktu_insiden->format('d-m-Y H:i') . ' WIB' : '-' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="py-2 text-start">Insiden Terjadi Pada</th>
                                        <td class="py-2 text-end">{{ $knc->insiden_pada }}</td>
                                    </tr>
                                    <tr>
                                        <th class="py-2 text-start">Sumber Informasi</th>
                                        <td class="py-2 text-end">{{ $knc->sumber }}</td>
                                    </tr>
                                    <tr>
                                        <th class="py-2 text-start">Insiden Menyangkut Pasien</th>
                                        <td class="py-2 text-end">{{ $knc->rawat }}</td>
                                    </tr>
                                    <tr>
                                        <th class="py-2 text-start">Insiden Terjadi Pada Pasien</th>
                                        <td class="py-2 text-end">{{ $knc->poli }}</td>
                                    </tr>
                                    <tr>
                                        <th class="py-2 text-start">Unit Terkait KNC</th>
                                        <td class="py-2 text-end">{{ $knc->unit_terkait }}</td>
                                    </tr>
                                    <tr>
                                        <th class="py-2 text-start">Tindakan Dilakukan Oleh</th>
                                        <td class="py-2 text-end">{{ $knc->pelaksana }}</td>
                                    </tr>
                                    <tr>
                                        <th class="py-2 text-start">Nama Inisial Pelapor</th>
                                        <td class="py-2 text-end">{{ $knc->nama_inisial }}</td>
                                    </tr>
                                    <tr>
                                        <th class="pt-2 text-start">Ruangan Pelapor</th>
                                        <td class="pt-2 text-end">{{ $knc->ruangan_pelapor }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-7">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-3">Isi Insiden</h4>
                        <div class="pb-3 border-bottom">
                            <label class="form-label">Temuan Kejadian/Insiden</label>
                            <div>{!! nl2br(e($knc->temuan)) !!}</div>
                        </div>
                        <div class="pb-3 mt-3 border-bottom">
                            <label class="form-label">Kronologi Insiden</label>
                            <div>{!! nl2br(e($knc->kronologis)) !!}</div>
                        </div>
                        <div class="mt-3">
                            <label class="form-label">Tindakan yang dilakukan segera setelah kesalahan/error terjadi dan
                                hasilnya</label>
                            <div>{!! nl2br(e($knc->tindakan_segera)) !!}</div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Lampiran Foto</h4>
                        <div class="row">
                            @forelse ($knc->foto as $img)
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
