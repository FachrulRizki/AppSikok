@extends('layouts.main')

@section('title', 'Riwayat Pengerjaan')

@section('content')
    <div class="container-fluid">
        <div class="card bg-primary-subtle shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-8">Riwayat Pengerjaan</h4>
                        <nav aria-label="breadcrumb" style="--bs-breadcrumb-divider: '/'">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a class="text-muted text-decoration-none" href="{{ route('dashboard') }}">Beranda</a>
                                </li>
                                <li class="breadcrumb-item" aria-current="page">Riwayat Pengerjaan</li>
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

        <div class="d-flex gap-2 mb-4 justify-content-center">
            <a href="{{ route('quiz.index') }}" class="btn {{ request()->routeIs('quiz.index') ? 'btn-primary' : 'bg-primary-subtle text-primary' }}" class="btn btn-primary">Kuis</a>
            <a href="{{ route('attempt.index') }}" class="btn {{ request()->routeIs('attempt.index') ? 'btn-primary' : 'bg-primary-subtle text-primary' }}" class="btn btn-primary">Riwayat Pengerjaan</a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card">
            <div class="card-body">
                <form action="" method="get">
                    <div class="row border-bottom">
                        <div class="col-md-4 mb-4">
                            <div class="form-group">
                                <label class="form-label">Pencarian</label>
                                <div class="input-group">
                                    <input type="search" value="{{ request('search') }}" name="search"
                                        class="form-control" placeholder="Masukkan kata kunci pencarian">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table w-100 text-nowrap">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>Judul Kuis</th>
                                <th class="text-center">Nilai Akhir</th>
                                <th class="text-center">Dikerjakan pada</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $item)
                                <tr>
                                    <td class="text-center">
                                        {{ ($data->currentPage() - 1) * $data->perPage() + $loop->iteration }}
                                    </td>
                                    <td>{{ $item->quiz->title }}</td>
                                    <td class="text-center">
                                        <span class="badge bg-primary-subtle text-primary">{{ $item->score }}</span>
                                    </td>
                                    <td class="text-center">
                                        {{ $item->created_at->format('d-m-Y, H:i') }} WIB
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ route('attempt.show', $item->id) }}" class="btn btn-primary btn-sm"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="Detail">
                                                <i class="ti ti-eye"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center" colspan="5">Tidak ada data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($data->hasPages())
                    <div class="mt-2 d-flex justify-content-center">
                        {{ $data->appends(['search' => request('search')])->links('vendor.pagination.bootstrap-4') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
