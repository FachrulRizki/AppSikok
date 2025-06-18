@extends('layouts.main')

@section('title', 'Supervisi Kepala Ruang')

@section('content')
    <div class="container-fluid">
        <div class="card bg-primary-subtle shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-8">Supervisi Kepala Ruang</h4>
                        <nav aria-label="breadcrumb" style="--bs-breadcrumb-divider: '/'">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a class="text-muted text-decoration-none" href="{{ route('dashboard') }}">Beranda</a>
                                </li>
                                <li class="breadcrumb-item" aria-current="page">Supervisi Kepala Ruang</li>
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

        @can('supervisi_kepru.buat')
            <a href="{{ route('spv_kepru.create') }}" class="btn btn-primary mb-4">Tambah Supervisi</a>
        @endcan

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card">
            <div class="card-body">
                <form action="" method="get">
                    <div class="row border-bottom align-items-end">
                        @can('supervisi_kepru.lihat.semua')
                        <div class="col-md-3 mb-4">
                            <div class="form-group">
                                <label class="form-label">Pencarian</label>
                                <div class="input-group">
                                    <input type="search" value="{{ request('search') }}" name="search" class="form-control" placeholder="Nama Kepala Ruang">
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
                            @can('supervisi_kepru.export')
                                @if (request('start') && request('end'))
                                    <a href="{{ route('spv_kepru.export', ['start' => request('start'), 'end' => request('end')]) }}"
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
                                @can('supervisi_kepru.lihat.semua')
                                <th>Nama Kepala Ruang</th>
                                @endcan
                                <th>Ruangan</th>
                                <th>Shift</th>
                                <th>Tanggal & Waktu</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $item)
                                <tr>
                                    <td class="text-center">{{ ($data->currentPage() - 1) * $data->perPage() + $loop->iteration }}</td>
                                    @can('supervisi_kepru.lihat.semua')
                                    <td>{{ $item->user->name }}</td>
                                    @endcan
                                    <td>{{ $item->ruangan }}</td>
                                    <td>{{ $item->shift }}</td>
                                    <td>{{ $item->waktu->format('d-m-Y, H:i') }} WIB</td>
                                    <td>
                                        <div class="d-flex gap-2 justify-content-center">
                                            <a href="{{ route('spv_kepru.show', $item->id) }}"
                                                class="btn btn-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Detail">
                                                <i class="ti ti-eye"></i>
                                            </a>
                                            @can('supervisi_kepru.edit')
                                                <a href="{{ route('spv_kepru.edit', $item->id) }}" class="btn btn-warning btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                                    <i class="ti ti-edit"></i>
                                                </a>
                                            @endcan
                                            @can('supervisi_kepru.hapus')
                                                <form action="{{ route('spv_kepru.destroy', $item->id) }}" method="POST"
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
                                    <td class="text-center" colspan="6">Tidak ada data</td>
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
