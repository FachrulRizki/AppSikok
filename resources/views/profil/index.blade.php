@extends('layouts.main')

@section('title', 'Profil Saya')

@section('content')
    <div class="container-fluid">
        <div class="card bg-primary-subtle shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-8">Profil Saya</h4>
                        <nav aria-label="breadcrumb" style="--bs-breadcrumb-divider: '/'">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a class="text-muted text-decoration-none" href="{{ route('dashboard') }}">Beranda</a>
                                </li>
                                <li class="breadcrumb-item" aria-current="page">Profil Saya</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-3">
                        <div class="text-center mb-n5">
                            <img src="{{ asset('assets/images/backgrounds/welcome-doctors.svg') }}" alt="form-5r-img"
                                class="img-fluid mb-n4" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="row">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="mt-n5">
                            <div class="d-flex align-items-center justify-content-center mb-2">
                                <div class="d-flex align-items-center justify-content-center round-110">
                                    <div
                                        class="border border-4 border-white d-flex align-items-center justify-content-center rounded-circle overflow-hidden round-100">
                                        <img src="https://ui-avatars.com/api/?name={{ $user->name }}&background=01C0C8&color=fff" alt="modernize-img"
                                            class="w-100 h-100">
                                    </div>
                                </div>
                            </div>
                            <div class="text-center">
                                <h5 class="mb-0">{{ $user->name }}</h5>
                                <p class="mb-0">{{ $user->getRoleNames()->first() }}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="table-responsive">
                            <table class="w-100 text-nowrap">
                                <tr>
                                    <th class="pb-1 text-start">Nama Lengkap</th>
                                    <td class="pb-1 text-end">{{ $user->name }}</td>
                                </tr>
                                <tr>
                                    <th class="py-1 text-start">Username</th>
                                    <td class="py-1 text-end">{{ $user->username }}</td>
                                </tr>
                                <tr>
                                    <th class="pt-1 text-start">Unit Tugas</th>
                                    <td class="pt-1 text-end">{{ $user->unit }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Ubah Password</h4>
                        <form action="{{ route('profile.store') }}" method="post">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Password Sekarang<span class="text-danger">*</span></label>
                                <input type="password" class="form-control @error('password_sekarang') is-invalid @enderror" name="password_sekarang" placeholder="********">
                                @error('password_sekarang')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="row">
                                <div class="mb-3 col-lg-6">
                                    <label class="form-label">Password Baru<span class="text-danger">*</span></label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="********">
                                    @error('password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3 col-lg-6">
                                    <label class="form-label">Konfirmasi Password<span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" name="password_confirmation" placeholder="********">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
