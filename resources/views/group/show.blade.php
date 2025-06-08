@extends('layouts.main')

@section('title')
    {{ $data->name }}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card bg-primary-subtle shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-8">{{ $data->name }}</h4>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a class="text-muted text-decoration-none" href="{{ route('dashboard') }}">Beranda</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a class="text-muted text-decoration-none" href="{{ route('groups.index') }}">Grup Pengguna</a>
                                </li>
                                <li class="breadcrumb-item" aria-current="page">{{ $data->name }}</li>
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

        <div class="d-flex gap-2">
            <button type="submit" form="groupForm" class="btn btn-primary mb-4">Simpan</button>
            <a href="{{ route('groups.index') }}" class="btn bg-primary-subtle text-primary mb-4">Kembali</a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @php
            $groupedPermissions = collect($permissions)->groupBy(function ($item) {
                return explode('.', $item->name)[0];
            });
        @endphp
        
        <div class="card">
            <div class="card-body">
                <form action="{{ route('groups.update', $data->id) }}" method="POST" id="groupForm">
                    @csrf
                    @method('PUT')
                    <div class="accordion" id="permissionAccordion">
                        @forelse ($groupedPermissions as $prefix => $group)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading-{{ $prefix }}">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $prefix }}" aria-expanded="false" aria-controls="collapse-{{ $prefix }}">
                                        {{ Str::title(str_replace('_', ' ', $prefix)) }}
                                    </button>
                                </h2>
                                <div id="collapse-{{ $prefix }}" class="accordion-collapse collapse" aria-labelledby="heading-{{ $prefix }}" data-bs-parent="#permissionAccordion">
                                    <div class="accordion-body">
                                        <div class="row">
                                            @foreach ($group as $item)
                                                <div class="col-md-6 mb-2">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="{{ $item->name }}" name="permissions[]" id="permissions-{{ $item->name }}"
                                                            {{ $data->hasPermissionTo($item->name) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="permissions-{{ $item->name }}">
                                                            {{ $item->name }}
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="alert alert-warning">Tidak ada data permission</div>
                        @endforelse
                </form>
            </div>
        </div>
    </div>
@endsection