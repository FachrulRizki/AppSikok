@extends('layouts.main')

@section('title', 'Detail Aktivitas Keperawatan')

@section('content')
    <div class="container-fluid">
        <div class="card bg-primary-subtle shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-8">Detail Aktivitas Keperawatan</h4>
                        <nav aria-label="breadcrumb" style="--bs-breadcrumb-divider: '/'">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a class="text-muted text-decoration-none" href="{{ route('dashboard') }}">Beranda</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a class="text-muted text-decoration-none" href="{{ route('aktivitas_keperawatan.index') }}">Aktivitas Keperawatan</a>
                                </li>
                                <li class="breadcrumb-item" aria-current="page">Detail Aktivitas Keperawatan</li>
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
            @canany(['aktivitas_keperawatan.beri.nilai', 'refleksi.beri.nilai'])
                <button type="submit" form="formApprovement" class="btn btn-primary">Simpan</button>
            @endcanany
            <a href="{{ route('aktivitas_keperawatan.index') }}" class="btn bg-primary-subtle text-primary">Kembali</a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-3">Aktivitas</h4>
                        @php
                            $grouped = $aktivitas_keperawatan->logs
                                ->groupBy('activity.nama')
                                ->map(function ($logsByActivity) {
                                    return $logsByActivity->groupBy('activity_detail.nama')->map(function ($logsByDetail) {
                                        return $logsByDetail->groupBy(fn($log) => $log->activity_task?->tipe);
                                    });
                                });
                        @endphp

                        <ul class="list-group">
                            @foreach ($grouped as $activityName => $details)
                                <li class="list-group-item bg-primary text-white">
                                    <strong class="fs-4">{{ $activityName }}</strong>
                                </li>
                                <li class="list-group-item">
                                    <ul>
                                    @foreach ($details as $detailName => $types)
                                        <li class="mb-3">
                                            <strong>{{ $detailName }}</strong>
                                            <ul class="ms-3">
                                                @foreach ($types as $typeName => $logs)
                                                    <li class="mb-1">
                                                        <strong>{{ $typeName }} :</strong>
                                                        <ol>
                                                            @foreach ($logs as $log)
                                                                @if ($log->activity_task)
                                                                    <li>{{ $log->activity_task->nama }}</li>
                                                                @endif
                                                            @endforeach
                                                        </ol>
                                                    </li>
                                                @endforeach
                                            </ul>

                                            @php
                                                $catatan = $types->flatten()->first()?->catatan;
                                            @endphp
                                            <div class="ms-3 mt-2 border border-primary py-2 px-3 rounded d-flex align-items-start gap-1" style="--bs-border-style: dashed;">
                                                <strong>Catatan:</strong>{{ $catatan ?? '-' }}
                                            </div>
                                        </li>
                                    @endforeach
                                    </ul>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-3">Detail Aktivitas</h4>
                        <div class="table-responsive">
                            <table class="w-100 text-nowrap">
                                <tbody>
                                    <tr>
                                        <th class="py-2 text-start">Nama Peserta</th>
                                        <td class="py-2 text-end">{{ $aktivitas_keperawatan->user->name }}</td>
                                    </tr>
                                    <tr>
                                        <th class="py-2 text-start">Unit Kerja</th>
                                        <td class="py-2 text-end">{{ $aktivitas_keperawatan->user->unit }}</td>
                                    </tr>
                                    <tr>
                                        <th class="py-2 text-start">Tanggal</th>
                                        <td class="py-2 text-end">{{ $aktivitas_keperawatan->waktu->format('d-m-Y') }}</td>
                                    </tr>
                                    <tr>
                                        <th class="py-2 text-start">Waktu</th>
                                        <td class="py-2 text-end">{{ $aktivitas_keperawatan->waktu->format('H:i') }} WIB</td>
                                    </tr>
                                    <tr>
                                        <th class="py-2 text-start">Shift Kerja</th>
                                        <td class="py-2 text-end">{{ $aktivitas_keperawatan->shift }}</td>
                                    </tr>
                                    <tr>
                                        <th class="pt-2 text-start">Nilai</th>
                                        <td class="pt-2 text-end">{{ $aktivitas_keperawatan->nilai != 0 ? $aktivitas_keperawatan->nilai : '-' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <hr>
                        <div>
                            <label class="form-label">Catatan Tambahan</label>
                            <p class="mb-0">{{ $aktivitas_keperawatan->catatan }}</p>
                        </div>
                        @can(['aktivitas_keperawatan.beri.nilai'])
                            <hr>
                            <form action="{{ route('aktivitas_keperawatan.update_nilai', $aktivitas_keperawatan->id) }}" method="post" id="formApprovement">
                                @csrf
                                @method('PUT')
                                <div class="col">
                                    <label class="form-label">Nilai<span class="ms-2 text-muted fs-2">(0-100)</span></label>
                                    <input type="number" class="form-control" min="0" max="100" name="nilai" value="{{ $aktivitas_keperawatan->nilai }}">
                                </div>
                            </form>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
