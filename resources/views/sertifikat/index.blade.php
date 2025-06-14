@extends('layouts.main')

@section('title', 'Sertifikat')

@section('content')
    <div class="container-fluid">
        <div class="card bg-primary-subtle shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-8">Sertifikat</h4>
                        <nav aria-label="breadcrumb" style="--bs-breadcrumb-divider: '/'">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a class="text-muted text-decoration-none" href="{{ route('dashboard') }}">Beranda</a>
                                </li>
                                <li class="breadcrumb-item" aria-current="page">Sertifikat</li>
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
                <h1>Daftar Sertifikat</h1>

                <form action="{{ route('sertifikat.index') }}" method="GET">
                    <input type="text" name="search" value="{{ $search ?? '' }}"
                        placeholder="Cari berdasarkan nama sertifikat">
                    <button type="submit">Cari</button>
                </form>

                <a href="{{ route('sertifikat.create') }}">Unggah Sertifikat Baru</a>

                <table border="1" cellpadding="10">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama File</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sertifikat as $item)
                            <tr>
                                <td>{{ $loop->iteration + ($sertifikat->currentPage() - 1) * $sertifikat->perPage() }}</td>
                                <td>{{ $item->nama_sertifikat }}</td>
                                <td>
                                    <a href="{{ route('sertifikat.edit', $item) }}">Edit</a> |
                                    <a href="{{ route('sertifikat.download', $item) }}">Download</a> |
                                    <form action="{{ route('sertifikat.destroy', $item) }}" method="POST"
                                        style="display:inline">
                                        @csrf
                                        @method('DELETE')
                                        <button onclick="return confirm('Yakin akan dihapus?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{ $sertifikat->links() }}

                @if (session('status'))
                    <p>{{ session('status') }}</p>
                @endif
            </div>
        </div>
    </div>
@endsection
