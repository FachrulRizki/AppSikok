@extends('layouts.main')

@section('title', 'Insiden Keselamatan Pasien')

@section('content')
    <div class="container-fluid">
        {{-- Header Card --}}
        <div class="card bg-primary-subtle shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-md-9">
                        <h4 class="fw-semibold mb-2">Insiden Keselamatan Pasien</h4>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a class="text-muted text-decoration-none" href="{{ route('dashboard') }}">Beranda</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Insiden Keselamatan Pasien</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-md-3 d-none d-md-block">
                        <div class="text-center">
                            <img src="{{ asset('assets/images/backgrounds/welcome-doctors.svg') }}" alt="welcome"
                                class="img-fluid" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-4xl mx-auto p-6">
    <h1 class="text-2xl md:text-3xl font-bold text-center text-blue-800 mb-8">Jenis Insiden Keselamatan Pasien</h1>

    <div class="space-y-8">
      <!-- KPC -->
      <section class="bg-white p-6 rounded-xl shadow-md">
        <h2 class="text-xl font-semibold text-blue-600 mb-2">1. KPC (Kejadian Potensial Cedera)</h2>
        <p class="mb-4">Semua kondisi yang berpotensi atau memungkinkan terjadinya cedera. Dalam hal ini belum terjadi insiden tetapi memiliki risiko menimbulkan cedera.</p>
        <h3 class="font-semibold mb-2 text-gray-700">Contoh:</h3>
        <ul class="list-disc list-inside space-y-1">
          <li>Alkes yang rusak/tidak berfungsi</li>
          <li>Keramik lantai yang pecah</li>
          <li>Kabel listrik yang terbuka</li>
          <li>Tidak menuliskan SBAR dengan benar</li>
          <li>Tidak melakukan hand over dengan benar</li>
          <li>Tidak dilakukan TTV pasien dengan benar</li>
          <li>Tidak membuat discharge planning</li>
          <li>Tidak melakukan edukasi pasien dengan benar</li>
        </ul>
      </section>

      <!-- KNC -->
      <section class="bg-white p-6 rounded-xl shadow-md">
        <h2 class="text-xl font-semibold text-blue-600 mb-2">2. KNC (Kejadian Nyaris Cedera)</h2>
        <p class="mb-4">Semua kesalahan/error yang sudah terjadi tetapi belum mengenai atau terpapar kepada pasien.</p>
        <h3 class="font-semibold mb-2 text-gray-700">Contoh:</h3>
        <ul class="list-disc list-inside space-y-1">
          <li>Salah obat tetapi belum diberikan ke pasien</li>
        </ul>
      </section>

      <!-- KTC -->
      <section class="bg-white p-6 rounded-xl shadow-md">
        <h2 class="text-xl font-semibold text-blue-600 mb-2">3. KTC (Kejadian Tidak Cedera)</h2>
        <p class="mb-4">Semua kesalahan yang sudah terjadi dan sudah terpapar kepada pasien, tetapi tidak menimbulkan cedera.</p>
        <h3 class="font-semibold mb-2 text-gray-700">Contoh:</h3>
        <ul class="list-disc list-inside space-y-1">
          <li>Salah pemberian obat dan sudah diberikan kepada pasien tetapi tidak menimbulkan reaksi obat yang tidak diinginkan</li>
        </ul>
      </section>

      <!-- KTD -->
      <section class="bg-white p-6 rounded-xl shadow-md">
        <h2 class="text-xl font-semibold text-blue-600 mb-2">4. KTD (Kejadian Tidak Diinginkan)</h2>
        <p class="mb-4">Semua kesalahan/error yang sudah terjadi dan sudah terpapar kepada pasien dan menimbulkan dampak atau cedera.</p>
        <h3 class="font-semibold mb-2 text-gray-700">Contoh:</h3>
        <ul class="list-disc list-inside space-y-1">
          <li>Salah pemberian obat dan sudah diberikan kepada pasien dan menimbulkan reaksi obat yang tidak diinginkan</li>
        </ul>
      </section>

      <!-- Sentinel -->
      <section class="bg-white p-6 rounded-xl shadow-md">
        <h2 class="text-xl font-semibold text-red-600 mb-2">5. Kejadian Sentinel</h2>
        <p>Semua kejadian KTD yang menimbulkan cedera permanen hingga kematian.</p>
      </section>
    </div>
  </div>

        {{-- Cards for Each Insiden --}}
        @php
            $insidenTypes = ['kpc', 'knc', 'ktc', 'ktd', 'sentinel'];
        @endphp

        <div class="row row-cols-1 row-cols-md-5 g-4 mb-4">
            @foreach ($insidenTypes as $type)
                @php
                    $routeName = 'insiden.' . $type . '.create';
                    $label = strtoupper($type);
                @endphp
                @if (Route::has($routeName))
                    <div class="col">
                        <a href="{{ route($routeName) }}" class="text-decoration-none text-dark">
                            <div class="card border-primary shadow-sm h-100 hover-shadow" style="cursor: pointer;">
                                <div class="card-body text-center">
                                    <h5 class="card-title text-primary">{{ $label }}</h5>
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
