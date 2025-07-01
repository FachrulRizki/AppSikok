@extends('layouts.main')

@section('title', 'Detail Laporan Sentinel')

@section('content')
<div class="container-fluid">
        <div class="card bg-primary-subtle shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-1">Laporan Insiden Kejadian Sentinel</h4>
                        <p class="mb-3 text-muted">
                            Kejadian sentinel (KTD yang menyebabkan kematian, cacat, atau cedera berat).
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
                                        href="{{ route('insiden.sentinel.index') }}">Sentinel</a>
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
            <a href="{{ route('insiden.sentinel.index') }}" class="btn bg-primary-subtle text-primary">Kembali</a>
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
                                        <td class="pb-2 text-end">{{ $sentinel->no_rm }}</td>
                                    </tr>
                                    <tr>
                                        <th class="py-2 text-start">Nama Pasien</th>
                                        <td class="py-2 text-end">{{ $sentinel->nama_pasien }}</td>
                                    </tr>
                                    <tr>
                                        <th class="py-2 text-start">Umur</th>
                                        <td class="py-2 text-end">{{ $sentinel->umur }}</td>
                                    </tr>
                                    <tr>
                                        <th class="py-2 text-start">Jenis Kelamin</th>
                                        <td class="py-2 text-end">{{ $sentinel->jk }}</td>
                                    </tr>
                                    <tr>
                                        <th class="pt-2 text-start">Waktu Masuk RS</th>
                                        <td class="pt-2 text-end">
                                            {{ $sentinel->waktu_mskrs ? $sentinel->waktu_mskrs->format('d-m-Y H:i') . ' WIB' : '-' }}
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
                                            {{ $sentinel->waktu_insiden ? $sentinel->waktu_insiden->format('d-m-Y H:i') . ' WIB' : '-' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="py-2 text-start">Insiden Terjadi Pada</th>
                                        <td class="py-2 text-end">{{ $sentinel->unit_terkait }}</td>
                                    </tr>
                                    <tr>
                                        <th class="py-2 text-start">Sumber Informasi</th>
                                        <td class="py-2 text-end">{{ $sentinel->sumber }}</td>
                                    </tr>
                                    <tr>
                                        <th class="py-2 text-start">Rawat</th>
                                        <td class="py-2 text-end">{{ $sentinel->rawat }}</td>
                                    </tr>
                                    <tr>
                                        <th class="py-2 text-start">Poli</th>
                                        <td class="py-2 text-end">{{ $sentinel->poli }}</td>
                                    </tr>
                                    <tr>
                                        <th class="py-2 text-start">Akibat</th>
                                        <td class="py-2 text-end">{{ $sentinel->akibat }}</td>
                                    </tr>
                                    <tr>
                                        <th class="py-2 text-start">Unit Terkait</th>
                                        <td class="py-2 text-end">{{ $sentinel->lokasi }}</td>
                                    </tr>
                                    <tr>
                                        <th class="py-2 text-start">Pelaksana</th>
                                        <td class="py-2 text-end">{{ $sentinel->pelaksana }}</td>
                                    </tr>
                                    <tr>
                                        <th class="py-2 text-start">Nama Inisial Pelapor</th>
                                        <td class="py-2 text-end">{{ $sentinel->nama_inisial }}</td>
                                    </tr>
                                    <tr>
                                        <th class="pt-2 text-start">Ruangan Pelapor</th>
                                        <td class="pt-2 text-end">{{ $sentinel->ruangan_pelapor }}</td>
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
                            <label class="form-label">Temuan</label>
                            <div>{!! nl2br(e($sentinel->temuan)) !!}</div>
                        </div>
                        <div class="pb-3 mt-3 border-bottom">
                            <label class="form-label">Kronologi</label>
                            <div>{!! nl2br(e($sentinel->kronologis)) !!}</div>
                        </div>
                        <div class="mt-3">
                            <label class="form-label">Tindakan Segera</label>
                            <div>{!! nl2br(e($sentinel->tindakan_segera)) !!}</div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Lampiran Foto</h4>
                        <div class="row">
                            @forelse ($sentinel->foto as $img)
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
