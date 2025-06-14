@extends('layouts.main')

@section('title', 'Edit 5R')

@section('content')
<div class="container-fluid">
    <div class="card bg-primary-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Edit 5R</h4>
                    <nav aria-label="breadcrumb" style="--bs-breadcrumb-divider: '/'">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ route('dashboard') }}">Beranda</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ route('lima_r.index') }}">5R Kepala Ruang</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">Edit 5R</li>
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

    {{-- @include('spv_kepru.form', [
        'route' => route('spv_kepru.update', $spv_kepru->id),
        'method' => 'PUT',
        'spv_kepru' => $spv_kepru
    ]) --}}

    <form action="{{ route('lima_r.update', $lima_r->id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('lima_r.form')
    </form>
</div>
@endsection
