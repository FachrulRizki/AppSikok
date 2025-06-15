@extends('layouts.main')

@section('title', 'Kuis')

@section('content')
    <div class="container-fluid">
        <div class="card bg-primary-subtle shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-8">Kuis</h4>
                        <nav aria-label="breadcrumb" style="--bs-breadcrumb-divider: '/'">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a class="text-muted text-decoration-none" href="{{ route('dashboard') }}">Beranda</a>
                                </li>
                                <li class="breadcrumb-item" aria-current="page">Kuis</li>
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

        @can('kuis.buat')
            <button type="button" data-bs-toggle="modal" data-bs-target="#addModal" class="btn btn-primary mb-4">Tambah Kuis</button>
        @endcan

        @can('kuis.mengerjakan')
            <div class="d-flex gap-2 mb-4 justify-content-center">
                <a href="{{ route('quiz.index') }}" class="btn {{ request()->routeIs('quiz.index') ? 'btn-primary' : 'bg-primary-subtle text-primary' }}" class="btn btn-primary">Kuis</a>
                <a href="{{ route('attempt.index') }}" class="btn {{ request()->routeIs('attempt.index') ? 'btn-primary' : 'bg-primary-subtle text-primary' }}" class="btn btn-primary">Riwayat Pengerjaan</a>
            </div>
        @endcan

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
                                <th class="text-center">Total Soal</th>
                                <th class="text-center">Mengerjakan</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $item)
                                <tr>
                                    <td class="text-center">
                                        {{ ($data->currentPage() - 1) * $data->perPage() + $loop->iteration }}
                                    </td>
                                    <td>{{ $item->title }}</td>
                                    <td class="text-center">
                                        <span class="badge bg-primary-subtle text-primary">{{ $item->questions->count() }} butir</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-primary-subtle text-primary">{{ $item->answers->count() }} peserta</span>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2">
                                            @can('kuis.mengerjakan')
                                                @if ($item->answers()->where('user_id', auth()->user()->id)->count() <= 0)
                                                    <a href="{{ route('attempt.create', ['quiz_id' => $item->id]) }}" class="btn btn-primary btn-sm"
                                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Kerjakan">
                                                        <i class="ti ti-clipboard"></i>
                                                    </a>
                                                @else
                                                    <span class="badge bg-primary-subtle text-primary"><i class="ti ti-file-check fs-4 me-1"></i>Dikerjakan</span>
                                                @endif
                                            @endcan
                                            @can('kuis.detail')
                                                <a href="{{ route('quiz.show', $item->id) }}" class="btn btn-primary btn-sm"
                                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Detail">
                                                    <i class="ti ti-eye"></i>
                                                </a>
                                            @endcan
                                            @can('kuis.edit')
                                                <a href="{{ route('quiz.edit', $item->id) }}" class="btn btn-warning btn-sm"
                                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                                    <i class="ti ti-edit"></i>
                                                </a>
                                            @endcan
                                            @can('kuis.hapus')
                                                <form action="{{ route('quiz.destroy', $item->id) }}" method="POST"
                                                    onsubmit="return confirm('Yakin hapus?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus">
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
                        {{ $data->appends(['search' => request('search')])->links('vendor.pagination.bootstrap-4') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
    @can('kuis.buat')
        <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="addModalLabel">Tambah Kuis</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('quiz.store') }}" method="post" id="addForm">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Judul Kuis</label>
                                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror">
                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div>
                                <label class="form-label">Deskripsi</label>
                                <textarea name="description" rows="3" class="form-control @error('description') is-invalid @enderror"></textarea>
                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn bg-primary-subtle text-primary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" form="addForm" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    @endcan
@endsection
