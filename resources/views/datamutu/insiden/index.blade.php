@extends('layouts.main')

@section('title', 'Insiden Keselamatan Pasien')

@section('content')
    <div class="container-fluid">
        <div class="card bg-primary-subtle shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-8">Insiden Keselamatan Pasien</h4>
                        <nav aria-label="breadcrumb" style="--bs-breadcrumb-divider: '/'">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a class="text-muted text-decoration-none" href="{{ route('dashboard') }}">Beranda</a>
                                </li>
                                <li class="breadcrumb-item" aria-current="page">Insiden Keselamatan Pasien</li>
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
		{{-- Cards for Each Insiden --}}
        
        <div class="card">
            <div class="card-body">
				<h1 class="fs-7 fw-semibold text-center mb-4">Jenis Insiden Keselamatan Pasien</h1>

				<ul class="list-group">
					<!-- KPC -->
					<li class="list-group-item bg-primary py-3" aria-current="true">
						<h2 class="fs-5 fw-semibold mb-1 text-white">KPC (Kejadian Potensial Cedera)</h2>
						<p class="mb-0 text-white">Semua kondisi yang berpotensi atau memungkinkan terjadinya cedera. Dalam hal ini belum
							terjadi insiden tetapi memiliki risiko menimbulkan cedera.</p>
					</li>
					<li class="list-group-item py-3">
						<h3 class="fs-4 fw-semibold mb-2">Contoh:</h3>
						<ol class="">
							<li>Alkes yang rusak/tidak berfungsi</li>
							<li>Keramik lantai yang pecah</li>
							<li>Kabel listrik yang terbuka</li>
							<li>Tidak menuliskan SBAR dengan benar</li>
							<li>Tidak melakukan hand over dengan benar</li>
							<li>Tidak dilakukan TTV pasien dengan benar</li>
							<li>Tidak membuat discharge planning</li>
							<li>Tidak melakukan edukasi pasien dengan benar</li>
						</ol>
					</li>

					<!-- KNC -->
					<li class="list-group-item bg-primary py-3" aria-current="true">
						<h2 class="fs-5 fw-semibold mb-1 text-white">KNC (Kejadian Nyaris Cedera)</h2>
						<p class="mb-0 text-white">Semua kesalahan/error yang sudah terjadi tetapi belum mengenai atau terpapar kepada
							pasien.</p>
					</li>
					<li class="list-group-item py-3">
						<h3 class="fs-4 fw-semibold mb-2">Contoh:</h3>
						<ul>
							<li>Salah obat tetapi belum diberikan ke pasien</li>
						</ul>
					</li>

					<!-- KTC -->
					<li class="list-group-item bg-primary py-3" aria-current="true">
						<h2 class="fs-5 fw-semibold mb-1 text-white">KTC (Kejadian Tidak Cedera)</h2>
						<p class="mb-0 text-white">Semua kesalahan yang sudah terjadi dan sudah terpapar kepada pasien, tetapi tidak
							menimbulkan cedera.</p>
					</li>
					<ul class="list-group-item py-3">
						<h3 class="fs-4 fw-semibold mb-2">Contoh:</h3>
						<ul>
							<li>Salah pemberian obat dan sudah diberikan kepada pasien tetapi tidak menimbulkan reaksi obat yang
								tidak diinginkan</li>
						</ul>
					</ul>

					<!-- KTD -->
					<li class="list-group-item bg-primary py-3" aria-current="true">
						<h2 class="fs-5 fw-semibold mb-1 text-white">KTD (Kejadian Tidak Diinginkan)</h2>
						<p class="mb-0 text-white">Semua kesalahan/error yang sudah terjadi dan sudah terpapar kepada pasien dan
							menimbulkan dampak atau cedera.</p>
					</li>
					<ul class="list-group-item py-3">
						<h3 class="fs-4 fw-semibold mb-2">Contoh:</h3>
						<ul>
							<li>Salah pemberian obat dan sudah diberikan kepada pasien dan menimbulkan reaksi obat yang tidak
								diinginkan</li>
						</ul>
					</ul>

					<!-- Sentinel -->
					<li class="list-group-item bg-primary py-3" aria-current="true">
						<h2 class="fs-5 fw-semibold mb-1 text-white">Kejadian Sentinel</h2>
						<p class="mb-0 text-white">Semua kejadian KTD yang menimbulkan cedera permanen hingga kematian.</p>
					</li>
				</ul>
			</div>
        </div>

		@php
            $insidenTypes = ['kpc', 'knc', 'ktc', 'ktd', 'sentinel'];
        @endphp

        <div class="row mb-4">
            @foreach ($insidenTypes as $type)
                @php
                    $routeName = 'insiden.' . $type . '.create';
                    $label = strtoupper($type);
                @endphp
                @if (Route::has($routeName))
                    <div class="col">
                        <a href="{{ route($routeName) }}">
                            <div class="card bg-primary-subtle shadow-none" style="cursor: pointer;">
                                <div class="card-body text-center">
                                    <h5 class="card-title text-primary fw-semibold">{{ $label }}</h5>
                                    <p class="card-text">Input Form kategori {{ $label }}</p>
                                </div>
                            </div>
                        </a>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
@endsection
