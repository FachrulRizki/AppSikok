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

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    @if ($material->type === 'pdf')
                        <a href="{{ asset('storage/' . $material->source) }}" target="_blank">
                            <img src="{{ asset('assets/images/thumbnail-show-pdf.jpg') }}" alt="Show PDF"
                                class="w-100 rounded-top">
                        </a>
                    @else
                        <div class="ratio ratio-16x9">
                            <iframe 
                                class="rounded-top {{ !$material->content ? 'rounded-bottom' : '' }}"
                                width="100%" 
                                height="100%" 
                                src="{{ $videoEmbed }}" 
                                title="YouTube video player" 
                                frameborder="0" 
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                                referrerpolicy="strict-origin-when-cross-origin" 
                                allowfullscreen>
                            </iframe>
                        </div>
                    @endif
                    @if ($material->content)
                        <div class="card-body">
                            <div>
                                <h5 class="fw-semibold mb-3">Isi Materi</h5>
                                {!! $material->content !!}
                            </div>
                        </div>
                    @endif
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
        <div class="card">
            <div class="card-body">
                <h4 class="mb-4 fw-semibold">Forum Materi</h4>
                <form action="{{ route('comments.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="material_id" value="{{ $material->id }}">
                    <textarea class="form-control mb-4" rows="5" name="comment"></textarea>
                    <button type="submit" class="btn btn-primary">Kirim Komentar</button>
                </form>
                <div class="d-flex align-items-center gap-3 mb-4 mt-7 pt-8">
                    <h4 class="mb-0">Komentar</h4>
                    <span class="badge bg-primary-subtle text-primary fs-4 fw-semibold px-6 py-8 rounded">{{ $material->comments->count() }}</span>
                </div>
                <div class="position-relative" id="komentar-container">
                    @include('components.komentar-list')
                </div>
                @if ($comments->hasMorePages())
                    <button id="load-more" data-page="2" data-id="{{ $material->id }}" class="btn btn-primary mt-3">Lebih banyak</button>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.getElementById('load-more')?.addEventListener('click', function () {
            let button = this;
            let page = parseInt(button.getAttribute('data-page'));
            let materiId = button.getAttribute('data-id');

            button.innerText = 'Loading...';

            fetch(`/materi/${materiId}/komentar?page=${page}`)
                .then(res => res.text())
                .then(data => {
                    document.getElementById('komentar-container').insertAdjacentHTML('beforeend', data);
                    button.setAttribute('data-page', page + 1);

                    if (!data.includes('div class="komentar"')) {
                        button.style.display = 'none';
                    } else {
                        button.innerText = 'Load More';
                    }
                })
                .catch(() => {
                    button.innerText = 'Gagal memuat';
                });
        });
    </script>
@endpush