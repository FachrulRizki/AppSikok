@extends('layouts.main')

@section('title', 'Detail Kuis')

@section('content')
<div class="container-fluid">
    <div class="card bg-primary-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Detail Kuis</h4>
                    <nav aria-label="breadcrumb" style="--bs-breadcrumb-divider: '/'">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ route('dashboard') }}">Beranda</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ route('quiz.index') }}">Kuis</a>
                            </li>
                            
                            <li class="breadcrumb-item" aria-current="page">Detail Kuis</li>
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

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Detail Kuis</h4>
                    <div class="table-responsive">
                        <table class="w-100 text-nowrap">
                            <tbody>
                                <tr>
                                    <th class="pb-2 text-start align-text-top">Judul Kuis</th>
                                    <td class="pb-2 text-end text-wrap">{{ $quiz->title }}</td>
                                </tr>
                                <tr>
                                    <th class="py-2 text-start">Total Soal</th>
                                    <td class="py-2 text-end text-primary"><strong>{{ $quiz->questions()->count() }}</strong> Butir</td>
                                </tr>
                                <tr>
                                    <th class="pt-2 text-start">Mengerjakan</th>
                                    <td class="pt-2 text-end text-primary"><strong>{{ $quiz->answers()->count() }}</strong> Peserta</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <hr class="my-3">
                    <div class="mt-3">
                        <label class="form-label">Deskripsi Kuis</label>
                        <p class="mb-0">{{ $quiz->description }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3 d-flex justify-content-between align-items-center">
                        <h4 class="mb-0 card-title">Peserta Mengerjakan</h4>
                        @can('kuis.export')
                            <a href="{{ route('attempt.export', ['quiz_id' => $quiz->id]) }}"
                                class="btn btn-primary btn-sm float-end" data-bs-toggle="tooltip" data-bs-placement="top" title="Export PDF"><i class="fa fa-download"></i></a>
                        @endcan
                    </div>
                    <div class="table-responsive">
                        <table class="table w-100 text-nowrap">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Peserta</th>
                                    <th class="text-center">Nilai Akhir</th>
                                    <th class="text-center">Dikerjakan pada</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($quiz->answers as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->user->name }}</td>
                                        <td class="text-center">
                                            <span class="badge bg-primary-subtle text-primary">{{ $item->score }}</span>
                                        </td>
                                        <td class="text-center">{{ $item->created_at->format('d-m-Y, H:i') }} WIB</td>
                                        <td>
                                           <div class="d-flex gap-2 justify-content-center">
                                                <a href="{{ route('attempt.show', $item->id) }}" class="btn btn-primary btn-sm"
                                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Detail">
                                                    <i class="ti ti-eye"></i>
                                                </a>
                                                <form action="{{ route('attempt.destroy', $item->id) }}" method="POST"
                                                    onsubmit="return confirm('Yakin hapus?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus">
                                                        <i class="ti ti-trash"></i>
                                                    </button>
                                                </form>
                                            </div> 
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center" colspan="5">Belum ada yang mengerjakan</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
