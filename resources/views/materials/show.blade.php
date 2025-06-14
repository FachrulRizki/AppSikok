@extends('layouts.main')

@section('title')
    {{ $material->title }}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card bg-primary-subtle shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-8">{{ $material->title }}</h4>
                        <nav aria-label="breadcrumb" style="--bs-breadcrumb-divider: '/'">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a class="text-muted text-decoration-none" href="{{ route('dashboard') }}">Beranda</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a class="text-muted text-decoration-none" href="{{ route('materi.index') }}">Materi</a>
                                </li>
                                <li class="breadcrumb-item" aria-current="page">{{ $material->title }}</li>
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
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        @if ($material->type === 'pdf')
                            <a href="{{ asset('storage/' . $material->source) }}" target="_blank">
                                <img src="{{ asset('assets/images/thumbnail-show-pdf.jpg') }}" alt="Show PDF" class="w-100 rounded">
                            </a>
                        @endif

                        @if ($material->content)
                            <div class="mt-5">
                                <h5 class="fw-semibold mb-3">Isi Materi</h5>
                                {!! $material->content !!}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="fw-semibold mb-3">Informasi Materi</h5>
                        <div class="table-responsive">
                            <table class="w-100">
                                <tbody>
                                    <tr>
                                        <th class="pb-1">Penulis</th>
                                        <td class="pb-1 text-end">{{ $material->user->name }}</td>
                                    </tr>
                                    <tr>
                                        <th class="py-1">Tipe Materi</th>
                                        <td class="py-1 text-end text-uppercase">{{ $material->type }}</td>
                                    </tr>
                                    <tr>
                                        <th class="pt-1">Tanggal Pembuatan</th>
                                        <td class="pt-1 text-end">{{ $material->created_at->format('d-m-Y') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
