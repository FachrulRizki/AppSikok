@extends('layouts.main')

@section('title', 'Detail Refleksi')

@section('content')
    <div class="container-fluid">
        <div class="card bg-primary-subtle shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-8">Detail Refleksi</h4>
                        <nav aria-label="breadcrumb" style="--bs-breadcrumb-divider: '/'">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a class="text-muted text-decoration-none" href="{{ route('dashboard') }}">Beranda</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a class="text-muted text-decoration-none" href="{{ route('refleksi.index') }}">Refleksi Harian</a>
                                </li>
                                <li class="breadcrumb-item" aria-current="page">Detail Refleksi</li>
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

        <div class="d-flex gap-2 mb-4">
            @canany(['refleksi.beri.approvement', 'refleksi.beri.nilai'])
                <button type="submit" form="formApprovement" class="btn btn-primary">Simpan</button>
            @endcanany
            <a href="{{ route('refleksi.index') }}" class="btn bg-primary-subtle text-primary">Kembali</a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="row">
            <div class="col-md-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-3">Detail Refleksi</h4>
                        <div class="table-responsive">
                            <table class="w-100 text-nowrap">
                                <tbody>
                                    <tr>
                                        <th class="pb-2 text-start align-text-top">Judul Kegiatan</th>
                                        <td class="pb-2 text-end text-wrap">{{ $refleksi->jdl_kegiatan }}</td>
                                    </tr>
                                    <tr>
                                        <th class="py-2 text-start">Tanggal</th>
                                        <td class="py-2 text-end">{{ $refleksi->waktu->format('d-m-Y') }}</td>
                                    </tr>
                                    <tr>
                                        <th class="py-2 text-start">Waktu</th>
                                        <td class="py-2 text-end">{{ $refleksi->waktu->format('H:i') }} WIB</td>
                                    </tr>
                                    <tr>
                                        <th class="py-2 text-start">Nama Peserta</th>
                                        <td class="py-2 text-end">{{ $refleksi->user->name }}</td>
                                    </tr>
                                    <tr>
                                        <th class="py-2 text-start">Unit Kerja</th>
                                        <td class="py-2 text-end">{{ $refleksi->user->unit }}</td>
                                    </tr>
                                    <tr>
                                        <th class="py-2 text-start">Persetujuan</th>
                                        <td class="py-2 text-end">
                                            @php
                                                $persetujuan = [
                                                    'waiting' => ['label' => 'Menunggu', 'color' => 'warning', 'icon' => 'clock'],
                                                    'approved' => ['label' => 'Disetujui', 'color' => 'primary', 'icon' => 'circle-check'],
                                                    'rejected' => ['label' => 'Ditolak', 'color' => 'danger', 'icon' => 'circle-x'],
                                                ][$refleksi->approvement];
                                            @endphp
                                            <span class="badge fs-2 bg-{{ $persetujuan['color'] }}-subtle text-{{ $persetujuan['color'] }}">
                                                <i class="ti ti-{{ $persetujuan['icon'] }} me-1"></i>
                                                {{ $persetujuan['label'] }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="pt-2 text-start">Nilai</th>
                                        <td class="pt-2 text-end">{{ $refleksi->nilai != 0 ? $refleksi->nilai : '-' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        @canany(['refleksi.beri.approvement', 'refleksi.beri.nilai'])
                            <hr>
                            <form action="{{ route('refleksi.update_approvement', $refleksi->id) }}" method="post" id="formApprovement">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    @can('refleksi.beri.approvement')
                                        <div class="col">
                                            <label class="form-label">Persetujuan</label>
                                            <select name="approvement" class="form-select">
                                                <option value="waiting" {{ $refleksi->approvement == 'waiting' ? 'selected' : '' }}>Menunggu</option>
                                                <option value="approved" {{ $refleksi->approvement == 'approved' ? 'selected' : '' }}>Disetujui</option>
                                                <option value="rejected" {{ $refleksi->approvement == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                                            </select>
                                        </div>
                                    @endcan
                                    @can('refleksi.beri.nilai')
                                        @if ($refleksi->approvement == 'approved')
                                            <div class="col">
                                                <label class="form-label">Nilai<span class="ms-2 text-muted fs-2">(0-100)</span></label>
                                                <input type="number" class="form-control" min="0" max="100" name="nilai" value="{{ $refleksi->nilai }}">
                                            </div>
                                        @endif
                                    @endcan
                                </div>
                                <div class="mt-3">
                                    <label class="form-label">Feedback</label>
                                    <textarea name="feedback" class="form-control" rows="3">{{ $refleksi->feedback }}</textarea>
                                </div>
                            </form>
                        @else
                            @if ($refleksi->approvement != 'waiting')
                                <hr>
                                <div>
                                    <label class="form-label">Feedback</label>
                                    <div>{{ $refleksi->feedback ?? '-' }}</div>
                                </div>
                            @endif
                        @endcanany
                    </div>
                </div>
            </div>
            <div class="col-md-7">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-3">Materi Refleksi</h4>
                        <div class="pb-3 border-bottom">
                            <label class="form-label">Poin Materi</label>
                            <div>{!! nl2br(e($refleksi->poin_materi)) !!}</div>
                        </div>
                        <div class="pb-3 mt-3 border-bottom">
                            <label class="form-label">Refleksi Pribadi</label>
                            <div>{!! nl2br(e($refleksi->pribadi)) !!}</div>
                        </div>
                        <div class="mt-3">
                            <label class="form-label">Rencana Tindakan</label>
                            <div>{!! nl2br(e($refleksi->tindakan)) !!}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
