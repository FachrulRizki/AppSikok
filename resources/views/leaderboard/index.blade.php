@extends('layouts.main')

@section('title', 'Leaderboard Kinerja Perawat')

@section('content')
    <div class="container-fluid">
        <div class="card bg-primary-subtle shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-8">Leaderboard Kinerja Perawat</h4>
                        <nav aria-label="breadcrumb" style="--bs-breadcrumb-divider: '/'">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a class="text-muted text-decoration-none" href="{{ route('dashboard') }}">Beranda</a>
                                </li>
                                <li class="breadcrumb-item" aria-current="page">Leaderboard Kinerja Perawat</li>
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
        
        <div class="card">
            <div class="card-body">
                <form action="" method="get">
                    <div class="row border-bottom align-items-end">
                        <div class="col-md-5 mb-4">
                            <div class="form-group">
                                <label class="form-label">Filter Tanggal</label>
                                <div class="input-group">
                                    <input type="text" value="{{ request('start') }}" name="start" class="form-control" placeholder="Dari tanggal" onfocus="(this.type='date')" onblur="(this.type='text')">
                                    <input type="text" value="{{ request('end') }}" name="end" class="form-control" placeholder="Sampai tanggal" onfocus="(this.type='date')" onblur="(this.type='text')">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-filter"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7 mb-4">
                            @can('leaderboard.export')
                                @if (request('start') && request('end'))
                                    <a href="{{ route('leaderboard.export', ['start' => request('start'), 'end' => request('end')]) }}"
                                    class="btn btn-primary float-end" data-bs-toggle="tooltip" data-bs-placement="top" title="Export PDF"><i class="fa fa-download"></i></a>
                                @else
                                    <button type="button"
                                    class="btn float-end bg-primary-subtle text-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Filter belum dipilih"><i class="fa fa-download"></i></button>
                                @endif
                            @endcan
                        </div>
                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table w-100 text-nowrap">
                        <thead>
                            <tr>
                                <th class="text-center"><i class="fs-4 ti ti-trophy text-primary"></i></th>
                                <th>Perawat</th>
                                <th>Unit Kerja</th>
                                <th class="text-center">Skor</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($topPerawat as $data)
                                <tr>
                                    <td class="text-center @if ($loop->index + ($topPerawat->currentPage() - 1) * $topPerawat->perPage() < 3) fw-semibold text-primary @endif">{{ ($topPerawat->currentPage() - 1) * $topPerawat->perPage() + $loop->iteration }}</td>
                                    <td class="@if ($loop->index + ($topPerawat->currentPage() - 1) * $topPerawat->perPage() < 3) fw-semibold text-primary @endif">{{ $data['user']->name }}</td>
                                    <td class="@if ($loop->index + ($topPerawat->currentPage() - 1) * $topPerawat->perPage() < 3) fw-semibold text-primary @endif">{{ $data['user']->unit }}</td>
                                    <td class="text-center">
                                        <span class="badge bg-primary-subtle text-primary">{{ $data['score'] }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if ($topPerawat->hasPages())
                    <div class="mt-2 d-flex justify-content-center">
                        {{ $topPerawat->appends(['start' => request('start'), 'end' => request('end')])->links('vendor.pagination.bootstrap-4') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection