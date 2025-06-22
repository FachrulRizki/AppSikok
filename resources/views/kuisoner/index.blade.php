@extends('layouts.main')

@section('title', 'Kuesioner Survei Kepuasan Pasien/Keluarga')

@section('content')
    <div class="container-fluid">
        <div class="card bg-primary-subtle shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-8">Kuesioner Survei Kepuasan Pasien/Keluarga</h4>
                        <nav aria-label="breadcrumb" style="--bs-breadcrumb-divider: '/'">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a class="text-muted text-decoration-none" href="{{ route('dashboard') }}">Beranda</a>
                                </li>
                                <li class="breadcrumb-item" aria-current="page">Kepuasan Pasien</li>
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

        @can('kuesioner.buat')
            <a href="{{ route('kuesioner.create') }}" class="btn btn-primary mb-4">Tambah Kuisoner</a>
        @endcan

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card">
            <div class="card-body">
                <form action="" method="get">
                    <div class="row border-bottom align-items-end">
                        <div class="col-md-6 mb-4">
                            <div class="form-group">
                                <label class="form-label">Filter</label>
                                <div class="input-group">
                                    <select name="bulan" class="form-select">
                                        <option value="">Pilih Bulan</option>
                                        @foreach ($availablePeriods->unique('bulan') as $p)
                                            <option value="{{ $p->bulan }}"
                                                {{ request('bulan') == $p->bulan ? 'selected' : '' }}>
                                                {{ \Carbon\Carbon::create()->month($p->bulan)->locale('id')->monthName }}
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
                                    <select name="ruangan" class="form-select">
                                        <option value="">Pilih Ruangan</option>
                                        @foreach ($availablePeriods->unique('ruangan') as $p)
                                            <option value="{{ $p->ruangan }}"
                                                {{ request('ruangan') == $p->ruangan ? 'selected' : '' }}>{{ $p->ruangan }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-filter"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            @if (request('bulan') && request('tahun'))
                                <a href="{{ route('kuesioner.export', ['bulan' => request('bulan'), 'tahun' => request('tahun'), 'ruangan' => request('ruangan')]) }}"
                                class="btn btn-primary float-end"><i class="fa fa-download"></i></a>
                            @else
                                <button type="button"
                                    class="btn float-end bg-primary-subtle text-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Filter belum dipilih"><i class="fa fa-download"></i></button>
                            @endif
                        </div>
                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table w-100">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>Tanggal</th>
                                <th>Ruangan dinilai</th>
                                <th>Hubungan dengan Pasien</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $item)
                                <tr>
                                    <td class="text-center">
                                        {{ ($data->currentPage() - 1) * $data->perPage() + $loop->iteration }}</td>
                                    <td>{{ $item->waktu_survei->format('d-m-Y') }}</td>
                                    <td>{{ $item->ruangan }}</td>
                                    <td>{{ $item->hubungan_pasien }}</td>
                                    <td>
                                        <div class="d-flex gap-2 justify-content-center">
                                            <a href="{{ route('kuesioner.show', $item->id) }}"
                                                class="btn btn-warning btn-sm btn-primary" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Detail">
                                                <i class="ti ti-eye"></i>
                                            </a>
                                            <form action="{{ route('kuesioner.destroy', $item->id) }}" method="POST"
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
                                    <td class="text-center" colspan="4">Tidak ada data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($data->hasPages())
                    <div class="mt-2 d-flex justify-content-center">
                        {{ $data->links('vendor.pagination.bootstrap-4') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
