@extends('layouts.main')

@section('title', 'Log Aktivitas')

@section('content')
    <div class="container-fluid">
        <div class="card bg-primary-subtle shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-8">Log Aktivitas</h4>
                        <nav aria-label="breadcrumb" style="--bs-breadcrumb-divider: '/'">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a class="text-muted text-decoration-none" href="{{ route('dashboard') }}">Beranda</a>
                                </li>
                                <li class="breadcrumb-item" aria-current="page">Log Aktivitas</li>
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
        
        <div class="card">
            <div class="card-body">
                <form action="" method="get">
                    <div class="row border-bottom align-items-end">
                        <div class="col-md-3 mb-4">
                            <div class="form-group">
                                <label class="form-label">Jenis Aktivitas</label>
                                <div class="input-group">
                                    <select name="event" class="form-select">
                                        <option value="">Pilih Jenis</option>
                                        @foreach ($availableEvents->unique('event') as $p)
                                            <option value="{{ $p->event }}"
                                                {{ request('event') == $p->event ? 'selected' : '' }}>{{ $p->event }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5 mb-4">
                            <div class="form-group">
                                <label class="form-label">Filter Tanggal</label>
                                <div class="input-group">
                                    <input type="text" value="{{ request('start') }}" name="start" class="form-control" placeholder="Dari tanggal" onfocus="(this.type='date')" onblur="(this.type='text')">
                                    <input type="text" value="{{ request('end') }}" name="end" class="form-control" placeholder="Sampai tanggal" onfocus="(this.type='date')" onblur="(this.type='text')">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-filter"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table w-100 text-nowrap">
                        <thead>
                            <tr>
                                <th>Nama Pengguna</th>
                                <th>Jenis Aktivitas</th>
                                <th>Aktivitas</th>
                                <th class="text-center">Waktu Aktivitas</th>
                                <th class="text-center">IP Address</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $item)
                                <tr>
                                    <td>{{ $item->causer?->name ?? 'Anonymus' }}</td>
                                    <td>{{ $item->event }}</td>
                                    <td>{{ $item->description }}</td>
                                    <td class="text-center">{{ $item->created_at->format('d-m-Y H:i') }} WIB</td>
                                    <td class="text-center">{{ $item->properties['ip'] }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center" colspan="5">Tidak ada data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($data->hasPages())
                    <div class="mt-2 d-flex justify-content-center">
                        {{ $data->appends(['start' => request('start'), 'end' => request('end'), 'event' => request('event')])->links('vendor.pagination.bootstrap-4') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection