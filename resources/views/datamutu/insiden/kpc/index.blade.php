@extends('layouts.main')

@section('title', 'KPC')
    
@section('content')
    <div class="container-fluid">
        <div class="card bg-primary-subtle shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-1">Laporan Insiden Kejadian Potensial Cedera (KPC)</h4>
                        <p class="mb-3 text-muted">
                            Merupakan kondisi yang sangat berpotensi menimbulkan insiden, namun belum terjadi.
                        </p>
                        <nav aria-label="breadcrumb" style="--bs-breadcrumb-divider: '/'">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a class="text-muted text-decoration-none" href="{{ route('dashboard') }}">Beranda</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a class="text-muted text-decoration-none" href="{{ route('insiden') }}">Insiden
                                        Keselamatan Pasien</a>
                                </li>
                                <li class="breadcrumb-item" aria-current="page">KPC</li>
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

        @can('insiden.buat')
            <a href="{{ route('insiden.kpc.create') }}" class="btn btn-primary mb-4">Tambah Laporan</a>
        @endcan

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card">
            <div class="card-body">
                <form action="" method="get">
                    <div class="row border-bottom align-items-end">
                        <div class="col-md-5 mb-4">
                            <div class="form-group">
                                <label class="form-label">Filter Triwulan</label>
                                <div class="input-group">
                                    <select name="triwulan" class="form-select">
                                        <option value="">Pilih Triwulan</option>
                                        @foreach ($availablePeriods as $p)
                                            <option value="{{ $p->triwulan }}"
                                                {{ request('triwulan') == $p->triwulan ? 'selected' : '' }}>
                                                {{ $p->triwulan }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <select name="tahun" class="form-select">
                                        <option value="">Pilih Tahun</option>
                                        @foreach ($availablePeriods->unique('tahun') as $p)
                                            <option value="{{ $p->tahun }}"
                                                {{ request('tahun') == $p->tahun ? 'selected' : '' }}>{{ $p->tahun }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-filter"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7 mb-4">
                            @can('insiden.export')
                                @if (request('triwulan') && request('tahun'))
                                    <a href="{{ route('insiden.kpc.export', ['triwulan' => request('triwulan'), 'tahun' => request('tahun')]) }}"
                                    class="btn btn-primary float-end" data-bs-toggle="tooltip" data-bs-placement="top" title="Export Excel"><i class="fa fa-print"></i></a>
                                @else
                                    <button type="button"
                                    class="btn float-end bg-primary-subtle text-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Filter belum dipilih"><i class="fa fa-print"></i></button>
                                @endif
                            @endcan
                        </div>
                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table w-100 text-nowrap">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>Temuan Kejadian/Insiden</th>
                                <th>Tanggal & Waktu</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($kpcs as $kpc)
                                <tr>
                                    <td class="text-center">{{ ($kpcs->currentPage() - 1) * $kpcs->perPage() + $loop->iteration }}</td>
                                    <td>{{ $kpc->temuan }}</td>
                                    <td>{{ $kpc->waktu->format('d-m-Y, H:i') }} WIB</td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ route('insiden.kpc.show', $kpc->id) }}" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Detail">
                                                <i class="ti ti-eye"></i>
                                            </a>
                                            @can('insiden.hapus')
                                                <form action="{{ route('insiden.kpc.destroy', $kpc->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button onclick="return confirm('Yakin ingin menghapus?')"
                                                        class="btn btn-sm btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus"><i class="ti ti-trash"></i></button>
                                                </form>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Tidak ada data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($kpcs->hasPages())
                    <div class="mt-2 d-flex justify-content-center">
                        {{ $kpcs->appends(['triwulan' => request('triwulan'), 'tahun' => request('tahun')])->links('vendor.pagination.bootstrap-4') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
