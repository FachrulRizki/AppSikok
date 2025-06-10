@extends('layouts.main')

@section('title', 'Beranda')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 d-flex align-items-stretch">
                <div class="card w-100 bg-primary-subtle overflow-hidden shadow-none">
                    <div class="card-body position-relative">
                        <div class="row">
                            <div class="col-sm-7">
                                <div class="mb-4">
                                    <p class="fw-semibold mb-2 fs-3">{{ getGreeting() }},</p>
                                    <h3 class="fw-semibold mb-0">{{ Auth::user()->name }}</h3>
                                </div>
                                <div class="d-flex align-items-center">
                                    <div class="border-end pe-4 border-muted border-opacity-10">
                                        @php
                                            $indikatorAktivitas = '';
                                            if ($avgPersenAktivitas < 50) {
                                                $indikatorAktivitas = 'Buruk';
                                            } elseif ($avgPersenAktivitas < 70) {
                                                $indikatorAktivitas = 'Cukup';
                                            } elseif ($avgPersenAktivitas < 90) {
                                                $indikatorAktivitas = 'Baik';
                                            } else {
                                                $indikatorAktivitas = 'Sangat Baik';
                                            }
                                        @endphp
                                        <h3 class="mb-1 fw-semibold fs-8">{{ $avgPersenAktivitas }}<sub class="fs-1">{{ $indikatorAktivitas }}</sub></h3>
                                        <p class="mb-0 text-dark fs-2">Capaian SOP Keperawatan</p>
                                    </div>
                                    <div class="ps-4">
                                        @php
                                            $indikatorRefleksi = '';
                                            if ($avgPersenRefleksi < 50) {
                                                $indikatorRefleksi = 'Buruk';
                                            } elseif ($avgPersenRefleksi < 70) {
                                                $indikatorRefleksi = 'Cukup';
                                            } elseif ($avgPersenRefleksi < 90) {
                                                $indikatorRefleksi = 'Baik';
                                            } else {
                                                $indikatorRefleksi = 'Sangat Baik';
                                            }
                                        @endphp
                                        <h3 class="mb-1 fw-semibold fs-8">{{ $avgPersenRefleksi }}<sub class="fs-1">{{ $indikatorRefleksi }}</sub></h3>
                                        <p class="mb-0 text-dark fs-2">Capaian Refleksi Keperawatan</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <div class="welcome-bg-img mb-n7 text-end">
                                    <img src="{{ asset('assets/images/backgrounds/welcome-doctors.svg') }}" alt="doctor-img"
                                        class="w-100">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-lg-7 d-flex align-items-stretch">
                <div class="card w-100">
                    <div class="card-body">
                        <h4 class="card-title fw-semibold">Leaderboard Kinerja Perawat</h4>
                        <p class="card-subtitle">Top 5 perawat dengan skor kinerja tertinggi</p>
                        <div class="table-responsive mt-4">
                            <table class="table w-100 text-nowrap">
                                <thead>
                                    <tr>
                                        <th class="text-center"><i class="fs-4 ti ti-trophy text-primary"></i></th>
                                        <th>Perawat</th>
                                        <th>Unit Kerja</th>
                                        <th class="text-center">Skor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($topPerawat as $data)
                                        <tr>
                                            <td class="text-center @if ($loop->index < 3) fw-semibold text-primary @endif">{{ $loop->iteration }}</td>
                                            <td class="@if ($loop->index < 3) fw-semibold text-primary @endif">{{ $data['user']->name }}</td>
                                            <td class="@if ($loop->index < 3) fw-semibold text-primary @endif">{{ $data['user']->unit }}</td>
                                            <td class="text-center">
                                                <span class="badge bg-primary-subtle text-primary">{{ $data['score'] }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-5 d-flex align-items-stretch">
                <div class="card w-100">
                    <div class="card-body">
                        <h4 class="card-title fw-semibold">Data Mutu Insiden Keselamatan Pasien</h4>
                        <p class="card-subtitle">Jumlah masing-masing kategori insiden</p>
                        <div id="data-mutu" class="revenue-chart mx-n3 mt-4"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card w-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="card-title fw-semibold">Tren Kepuasan Pasien Per Hari ini</h4>
                        <p class="card-subtitle">Indeks kepuasan masyarakan per unsur pertanyaan per hari ini</p>
                    </div>
                    <div class="d-flex">
                        <span class="mt-1">IKM</span>
                        <div class="d-flex align-items-end">
                            <h1 class="mb-0">{{ $kepuasanPelanggan['ikm'] }}</h1>
                            <p class="mb-1">/100</p>
                        </div>
                    </div>
                </div>
                <div id="kepuasan-pasien" class="revenue-chart mx-n3 mt-4"></div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
    <script>
        const dataMutu = @json($chartInsidenData);

        var options = {
            series: [{
                name: "Jumlah",
                data: dataMutu.data,
            }],
            chart: {
                toolbar: {
                    show: false,
                },
                type: "bar",
                fontFamily: "inherit",
                foreColor: "#adb0bb",
                height: 350,
            },
            colors: ["var(--bs-primary)"],
            plotOptions: {
                bar: {
                    columnWidth: "40%",
                    borderRadius: [6],
                    borderRadiusApplication: "end",
                },
            },
            stroke: {
                width: 5,
                curve: 'smooth',
                dashArray: [0],
            },
            dataLabels: {
                enabled: true,
            },
            legend: {
                show: false,
            },
            grid: {
                borderColor: "rgba(0,0,0,0.1)",
                strokeDashArray: 3,
                xaxis: {
                    lines: {
                    show: false,
                    },
                },
            },
            yaxis: {
                min: 0,
                tickAmount: 5,
            },
            xaxis: {
                categories: dataMutu.labels,
                show: false,
                axisTicks: {
                    show: false,
                },
                axisBorder: {
                    show: false,
                }
            },
            tooltip: {
                theme: "dark",
            },
        };

        var chart = new ApexCharts(document.querySelector("#data-mutu"), options);
        chart.render();

        const kepuasan = @json($kepuasanPelanggan);

        var options = {
            series: [{
                name: "NRR Tertimbang",
                data: kepuasan.series,
            }],
            chart: {
                toolbar: {
                    show: false,
                },
                type: "area",
                fontFamily: "inherit",
                foreColor: "#adb0bb",
                height: 350,
            },
            colors: ["var(--bs-primary)"],
            fill: {
                type: "gradient",
                gradient: {
                    shade: 'light',
                    type: "vertical",
                    shadeIntensity: 0.4,
                    gradientToColors: ["#ffffff"],
                    inverseColors: false,
                    opacityFrom: 0.7,
                    opacityTo: 0,
                    stops: [0, 100],
                },
            },
            stroke: {
                width: 5,
                curve: 'smooth',
                dashArray: [0],
            },
            dataLabels: {
                enabled: true,
            },
            legend: {
                show: false,
            },
            grid: {
                borderColor: "rgba(0,0,0,0.1)",
                strokeDashArray: 3,
                xaxis: {
                    lines: {
                    show: false,
                    },
                },
            },
            yaxis: {
                min: 0,
                tickAmount: 5,
            },
            xaxis: {
                categories: kepuasan.categories,
                show: false,
                axisTicks: {
                    show: false,
                },
                axisBorder: {
                    show: false,
                }
            },
            tooltip: {
                theme: "dark",
            },
        };

        var chart = new ApexCharts(document.querySelector("#kepuasan-pasien"), options);
        chart.render();
    </script>
@endpush
