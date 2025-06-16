@extends('layouts.main')

@section('title', 'Detail PPI')

@section('content')
    <div class="container-fluid">
        <div class="card bg-primary-subtle shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-8">Detail PPI</h4>
                        <nav aria-label="breadcrumb" style="--bs-breadcrumb-divider: '/'">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a class="text-muted text-decoration-none" href="{{ route('dashboard') }}">Beranda</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a class="text-muted text-decoration-none" href="{{ route('cuci_tangan.index') }}">Cuci
                                        Tangan</a>
                                </li>
                                <li class="breadcrumb-item" aria-current="page">Detail PPI</li>
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

        <div class="d-flex gap-2 mb-4">
            <a href="{{ route('cuci_tangan.index') }}" class="btn bg-primary-subtle text-primary">Kembali</a>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Petugas</label>
                                <p class="mb-0">{{ $cuci_tangan->user->name }}</p>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Unit Kerja</label>
                                <p class="mb-0">{{ $cuci_tangan->user->unit }}</p>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Tanggal & Waktu</label>
                                <p class="mb-0">{{ $cuci_tangan->waktu->format('d-m-Y H:i') }} WIB</p>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Shift</label>
                                <p class="mb-0">{{ $cuci_tangan->shift }}</p>
                            </div>
                        </div>

                        <div class="table-responsive border-top">
                            <table class="table w-100">
                                <thead>
                                    <tr class="text-nowrap">
                                        <th>Aktivitas</th>
                                        <th>Detail Aktivitas</th>
                                        <th>Catatan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $details = is_string($cuci_tangan->details)
                                            ? json_decode($cuci_tangan->details, true)
                                            : $cuci_tangan->details ?? [];
                                        $tasks = is_string($cuci_tangan->tasks)
                                            ? json_decode($cuci_tangan->tasks, true)
                                            : $cuci_tangan->tasks ?? [];
                                        $notes = is_string($cuci_tangan->notes)
                                            ? json_decode($cuci_tangan->notes, true)
                                            : $cuci_tangan->notes ?? [];

                                        foreach ($tasks as $detailId => $taskIds) {
                                            if (!in_array($detailId, $details)) {
                                                $details[] = $detailId;
                                            }
                                        }
                                    @endphp

                                    @foreach ($activities as $activity)
                                        <tr>
                                            <td class="align-top">
                                                {{ $activity['id'] }}. {{ $activity['nama'] }}
                                            </td>
                                            <td>
                                                @foreach ($activity['details'] ?? [] as $detail)
                                                    @if (in_array($detail['id'], $details))
                                                        <div class="mb-1">
                                                            <span>{{ $detail['id'] }}. {{ $detail['nama'] }}</span>
                                                            <ul class="ms-4 mt-1">
                                                                @foreach (collect($detail['tasks'] ?? [])->groupBy('tipe') as $tipe => $taskGroup)
                                                                    <li>
                                                                        <ul>
                                                                            @foreach ($taskGroup as $task)
                                                                                @if (in_array($task['id'], $tasks[$detail['id']] ?? []))
                                                                                    <li class="mb-1">{{ $task['id'] }}. {{ $task['nama'] }}</li>
                                                                                @endif
                                                                            @endforeach
                                                                        </ul>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td class="align-top">
                                                <div class="mb-3">
                                                    <p class="mb-0">{{ $notes[$activity['id']] ?? '-' }}</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
