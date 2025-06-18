@extends('layouts.main')

@section('title', 'Refleksi Harian')

@section('content')
    <div class="container-fluid">
        <div class="card bg-primary-subtle shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-8">Refleksi Harian</h4>
                        <nav aria-label="breadcrumb" style="--bs-breadcrumb-divider: '/'">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a class="text-muted text-decoration-none" href="{{ route('dashboard') }}">Beranda</a>
                                </li>
                                <li class="breadcrumb-item" aria-current="page">Refleksi Harian</li>
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

        @can('refleksi.buat')
            <a href="{{ route('refleksi.create') }}" class="btn btn-primary mb-4">Tambah Refleksi</a>
        @endcan

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card">
            <div class="card-body">
                <form action="" method="get">
                    <div class="row border-bottom">
                        <div class="col-md-4 mb-4">
                            <div class="form-group">
                                <label class="form-label">Pencarian</label>
                                <div class="input-group">
                                    <input type="search" value="{{ request('search') }}" name="search" class="form-control" placeholder="Masukkan kata kunci pencarian">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table w-100 text-nowrap">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>Jenis Kegiatan</th>
                                <th>Tanggal & Waktu</th>
                                @can('refleksi.lihat.semua')
                                <th>Nama Peserta</th>
                                <th>Unit Kerja</th>
                                @endcan
                                <th>Persetujuan</th>
                                <th class="text-center">Nilai</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $item)
                                <tr>
                                    <td class="text-center">{{ ($data->currentPage() - 1) * $data->perPage() + $loop->iteration }}</td>
                                    <td class="text-truncate" style="max-width: 250px">{{ $item->jdl_kegiatan }}</td>
                                    <td>{{ $item->waktu->format('d-m-Y, H:i') }} WIB</td>
                                    @can('refleksi.lihat.semua')
                                    <td>{{ $item->user->name }}</td>
                                    <td>{{ $item->user->unit }}</td>
                                    @endcan
                                    <td>
                                        @php
                                            $persetujuan = [
                                                'waiting' => ['label' => 'Menunggu', 'color' => 'warning', 'icon' => 'clock'],
                                                'approved' => ['label' => 'Disetujui', 'color' => 'primary', 'icon' => 'circle-check'],
                                                'rejected' => ['label' => 'Ditolak', 'color' => 'danger', 'icon' => 'circle-x'],
                                            ][$item->approvement];
                                        @endphp
                                        <span class="badge fs-2 bg-{{ $persetujuan['color'] }}-subtle text-{{ $persetujuan['color'] }}">
                                            <i class="ti ti-{{ $persetujuan['icon'] }} me-1"></i>
                                            {{ $persetujuan['label'] }}
                                        </span>
                                    </td>
                                    <td class="text-center">{{ $item->nilai != 0 ? $item->nilai : '-' }}</td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ route('refleksi.show', $item->id) }}"
                                                class="btn btn-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Detail">
                                                <i class="ti ti-eye"></i>
                                            </a>
                                            @can('refleksi.edit')
                                                @if ($item->approvement != 'approved')
                                                    <a href="{{ route('refleksi.edit', $item->id) }}"
                                                        class="btn btn-warning btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                                        <i class="ti ti-edit"></i>
                                                    </a>
                                                @endcan
                                            @endif
                                            @can('refleksi.hapus')
                                                @if ($item->approvement == 'waiting')
                                                    <form action="{{ route('refleksi.destroy', $item->id) }}"
                                                        method="POST" onsubmit="return confirm('Yakin hapus?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus">
                                                            <i class="ti ti-trash"></i>
                                                        </button>
                                                    </form>
                                                @endcan
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center" colspan="6">Tidak ada data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($data->hasPages())
                    <div class="mt-2 d-flex justify-content-center">
                        {{ $data->appends(['search' => request('search')])->links('vendor.pagination.bootstrap-4') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
