@extends('layouts.main')

@section('title', 'Tambah 5R')

@section('content')
<div class="container-fluid">
    <div class="card bg-primary-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Tambah 5R</h4>
                    <nav aria-label="breadcrumb" style="--bs-breadcrumb-divider: '/'">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ route('dashboard') }}">Beranda</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ route('lima_r.index') }}">5R</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">Tambah 5R</li>
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

    {{-- Menyisipkan form --}}
    {{-- @include('spv_kepru.form', [
        'route' => route('spv_kepru.store'),
        'method' => 'POST'
    ]) --}}
    <form action="{{ route('lima_r.store') }}" method="POST">
        @csrf
        @include('lima_r.form')
    </form>
</div>
@endsection
