@extends('layouts.main')

@section('title', 'Materi')

@section('content')
    <div class="container-fluid">
        <div class="card bg-primary-subtle shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-8">Materi Video/PDF</h4>
                        <nav aria-label="breadcrumb" style="--bs-breadcrumb-divider: '/'">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a class="text-muted text-decoration-none" href="{{ route('dashboard') }}">Beranda</a>
                                </li>
                                <li class="breadcrumb-item" aria-current="page">Materi</li>
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

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card">
            <div class="card-body">
                <form action="" method="get">
                    <div class="row align-items-end">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Filter</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="search"
                                        value="{{ request('search') }}" placeholder="Masukkan judul materi">
                                    <select name="type" class="form-select" style="max-width: 180px">
                                        <option value="">Pilih Tipe</option>
                                        <option value="youtube" {{ request('type') == 'youtube' ? 'selected' : '' }}>Video
                                            YouTube</option>
                                        <option value="pdf" {{ request('type') == 'pdf' ? 'selected' : '' }}>PDF</option>
                                    </select>
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-filter"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            @can('materi.buat')
                                <a href="{{ route('materi.create') }}" class="btn btn-primary float-end">Tambah Materi</a>
                            @endcan
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="row">
            @forelse ($data as $item)
                <div class="col-md-6 col-lg-3">
                    <div class="card overflow-hidden hover-img">
                        <div class="position-relative">
                            <a href="{{ route('materi.show', $item->id) }}">
                                @if ($item->type == 'youtube')
                                    <img src="{{ asset('assets/images/thumbnail-youtube.jpg') }}" class="card-img-top"
                                        alt="materi">
                                @else
                                    <img src="{{ asset('assets/images/thumbnail-pdf.jpg') }}" class="card-img-top"
                                        alt="materi">
                                @endif
                            </a>
                            @if (auth()->user()->id == $item->user->id)
                                <div class="d-flex gap-2 mt-9 me-9 position-absolute top-0 end-0">
                                    <a href="{{ route('materi.edit', $item->id) }}" class="btn btn-warning btn-sm">
                                        <ti class="ti ti-edit"></ti>
                                    </a>
                                    <form action="{{ route('materi.destroy', $item->id) }}" method="post"
                                        onsubmit="return confirm('Yakin hapus?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" href="{{ route('materi.destroy', $item->id) }}"
                                            class="btn btn-danger btn-sm">
                                            <ti class="ti ti-trash"></ti>
                                        </button>
                                    </form>
                                </div>
                            @endif
                            <img src="https://ui-avatars.com/api/?name={{ $item->user->name }}&background=59A5AA&color=fff"
                                alt="materi"
                                class="img-fluid rounded-circle position-absolute bottom-0 start-0 mb-n9 ms-9"
                                width="40" height="40" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-title="{{ $item->user->name }}">
                        </div>
                        <div class="card-body p-4">
                            <a class="d-block my-3 fs-4 text-dark fw-semibold link-primary text-justify"
                                href="{{ route('materi.show', $item->id) }}">{{ $item->title }}</a>
                            <div class="d-flex align-items-center gap-4">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="ti ti-message-2 text-dark fs-5"></i>{{ $item->comments->count() }}
                                </div>
                                <div class="d-flex align-items-center fs-2 ms-auto">
                                    <i class="ti ti-point text-dark"></i>{{ $item->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-md-12">
                    <div class="alert alert-primary border-0 text-primary mb-0 text-center">Belum ada materi</div>
                </div>
            @endforelse
        </div>
        @if ($data->hasPages())
            <div class="mt-2 d-flex justify-content-center">
                {{ $data->appends(['search' => request('search'), 'type' => request('type')])->links('vendor.pagination.bootstrap-4') }}
            </div>
        @endif
    </div>
@endsection
