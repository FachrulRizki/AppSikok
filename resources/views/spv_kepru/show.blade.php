@extends('layouts.main')

@section('title', 'Detail Supervisi')

@section('content')
    <div class="container-fluid">
        <div class="card bg-primary-subtle shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-8">Detail Supervisi</h4>
                        <nav aria-label="breadcrumb" style="--bs-breadcrumb-divider: '/'">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a class="text-muted text-decoration-none" href="{{ route('dashboard') }}">Beranda</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a class="text-muted text-decoration-none" href="{{ route('spv_kepru.index') }}">Supervisi Kepala Ruang</a>
                                </li>
                                <li class="breadcrumb-item" aria-current="page">Detail Supervisi</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-3">
                        <div class="text-center mb-n5">
                            <img src="{{ asset('assets/images/backgrounds/welcome-doctors.svg') }}" alt="modernize-img" class="img-fluid mb-n4" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex gap-2 mb-4">
            <a href="{{ route('spv_kepru.index') }}" class="btn bg-primary-subtle text-primary">Kembali</a>
        </div>

        <div class="row">
            <div class="col-md-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-3">Detail Supervisi</h4>
                        <div class="table-responsive">
                            <table class="w-100 text-nowrap">
                                <tbody>
                                    <tr>
                                        <th class="pb-2 text-start">Nama Kepala Ruang</th>
                                        <td class="pb-2 text-end">{{ $spv_kepru->user->name }}</td>
                                    </tr>
                                    <tr>
                                        <th class="py-2 text-start">Ruangan</th>
                                        <td class="py-2 text-end">{{ $spv_kepru->ruangan }}</td>
                                    </tr>
                                    <tr>
                                        <th class="py-2 text-start">Shift</th>
                                        <td class="py-2 text-end">{{ $spv_kepru->shift }}</td>
                                    </tr>
                                    <tr>
                                        <th class="py-2 text-start">Tanggal</th>
                                        <td class="py-2 text-end">{{ $spv_kepru->waktu->format('d-m-Y') }}</td>
                                    </tr>
                                    <tr>
                                        <th class="pt-2 text-start">Waktu</th>
                                        <td class="pt-2 text-end">{{ $spv_kepru->waktu->format('H:i') }} WIB</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <hr>
                        <div>
                            <label class="form-label">Aktivitas</label>
                            <div>
                                <ol class="list-group list-group-numbered">
                                    @foreach ($spv_kepru->aktivitas as $item)
                                        <li class="list-group-item m-0">{{ $item }}</li>
                                    @endforeach
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-7">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-3">Isi Supervisi</h4>
                        <div class="pb-3 border-bottom">
                            <label class="form-label">Observasi</label>
                            <div>{!! nl2br(e($spv_kepru->observasi)) !!}</div>
                        </div>
                        <div class="mt-3">
                            <label class="form-label">Perbaikan</label>
                            <div>{!! nl2br(e($spv_kepru->perbaikan)) !!}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
