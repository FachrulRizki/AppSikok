@extends('layouts.main')

@section('title', 'Data 5R')

@section('content')
<div class="container-fluid">
    <div class="card bg-primary-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Data Implementasi Prinsip 5R</h4>
                    <nav aria-label="breadcrumb" style="--bs-breadcrumb-divider: '/'">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ route('dashboard') }}">Beranda</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">Data 5R</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-3">
                    <div class="text-center mb-n5">
                        <img src="{{ asset('assets/images/backgrounds/welcome-doctors.svg') }}" alt="form-5r-img" class="img-fluid mb-n4" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    @can('lima_r.buat')
        <a href="{{ route('lima_r.create') }}" class="btn btn-primary mb-4">Tambah Formulir 5R</a>
    @endcan

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="" method="get">
                    <div class="row border-bottom align-items-end">
                        @can('lima_r.lihat.semua')
                        <div class="col-md-3 mb-4">
                            <div class="form-group">
                                <label class="form-label">Pencarian</label>
                                <div class="input-group">
                                    <input type="search" value="{{ request('search') }}" name="search" class="form-control" placeholder="Nama Petugas">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                        @endcan
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
                        <div class="col-md-4 mb-4">
                            @can('lima_r.export')
                                @if (request('start') && request('end'))
                                    <a href="{{ route('lima_r.export', ['start' => request('start'), 'end' => request('end')]) }}"
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
                <table class="table w-100">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th>Petugas</th>
                            <th>Shift</th>
                            <th>Tanggal & Waktu</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data as $item)
                            <tr>
                                <td class="text-center">{{ ($data->currentPage() - 1) * $data->perPage() + $loop->iteration }}</td>
                                <td>{{ $item->user->name ?? '-' }}</td>
                                <td>{{ $item->shift }}</td>
                                <td>{{ $item->waktu->format('d-m-Y, H:i') }} WIB</td>
                                <td>
                                    <div class="d-flex gap-2 justify-content-center">
                                        <a href="{{ route('lima_r.show', $item->id) }}"
                                            class="btn btn-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Detail">
                                            <i class="ti ti-eye"></i>
                                        </a>
                                        @can('lima_r.hapus')
                                            <form action="{{ route('lima_r.destroy', $item->id) }}" method="POST"
                                                onsubmit="return confirm('Yakin hapus?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus">
                                                    <i class="ti ti-trash"></i>
                                                </button>
                                            </form>
                                        @endcan
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
                    {{ $data->appends(['search' => request('search'), 'start' => request('start'), 'end' => request('end')])->links('vendor.pagination.bootstrap-4') }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
