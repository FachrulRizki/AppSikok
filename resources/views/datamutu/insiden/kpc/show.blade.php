@extends('layouts.main')

@section('title', 'Detail Laporan KPC')

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
        <a href="{{ route('insiden.kpc.index') }}" class="btn bg-primary-subtle text-primary">Kembali</a>
    </div>

    <div class="row">
        <div class="col-md-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-3">Detail Laporan</h4>
                    <div class="table-responsive">
                        <table class="w-100 text-nowrap">
                            <tbody>
                                <tr>
                                    <th class="pb-2 text-start">Nama Inisial Pelapor</th>
                                    <td class="pb-2 text-end">{{ $kpc->nama_inisial }}</td>
                                </tr>
                                <tr>
                                    <th class="py-2 text-start">Tanggal</th>
                                    <td class="py-2 text-end">{{ $kpc->waktu->format('d-m-Y') }}</td>
                                </tr>
                                <tr>
                                    <th class="py-2 text-start">Waktu</th>
                                    <td class="py-2 text-end">{{ $kpc->waktu->format('H:i') }} WIB</td>
                                </tr>
                                <tr>
                                    <th class="py-2 text-start align-text-top">Sumber</th>
                                    <td class="py-2 text-end text-wrap">{{ $kpc->sumber }}</td>
                                </tr>
                                <tr>
                                    <th class="py-2 text-start">Unit Terkait</th>
                                    <td class="py-2 text-end">{{ $kpc->unit_terkait }}</td>
                                </tr>
                                <tr>
                                    <th class="py-2 text-start">Ruangan Pelapor</th>
                                    <td class="py-2 text-end">{{ $kpc->ruangan }}</td>
                                </tr>
                                <tr>
                                    <th class="pt-2 text-start">Pelaksana</th>
                                    <td class="pt-2 text-end">{{ $kpc->pelaksana }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Lampiran Foto</h4>
                        <div class="row">
                            @forelse ($kpc->foto as $img)
                                <div class="col-md-6">
                                    <a href="{{ asset('storage/' . $img) }}" target="_blank" class="ratio ratio-1x1 overflow-hidden">
                                        <img src="{{ asset('storage/' . $img) }}" alt="Foto" style="cursor: pointer; object-fit: cover;" class="rounded">
                                    </a>
                                </div>
                            @empty
                                <p class="text-center mb-0">Tidak ada lampiran foto</p>
                            @endforelse
                        </div>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-3">Isi Laporan</h4>
                    <div class="pb-3 border-bottom">
                        <label class="form-label">Temuan Kejadian/Insiden</label>
                        <div>{!! nl2br(e($kpc->temuan)) !!}</div>
                    </div>
                    <div class="pb-3 mt-3 border-bottom">
                        <label class="form-label">Kronologi Insiden</label>
                        <div>{!! nl2br(e($kpc->kronologis)) !!}</div>
                    </div>
                    <div class="mt-3">
                        <label class="form-label">Tindakan yang Dilakukan</label>
                        <div>{!! nl2br(e($kpc->tindakan)) !!}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
