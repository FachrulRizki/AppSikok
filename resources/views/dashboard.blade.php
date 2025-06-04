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
                                    <p class="fw-semibold mb-2 fs-3">Selamat Pagi,</p>
                                    <h3 class="fw-semibold mb-0">{{ Auth::user()->name }}</h3>
                                </div>
                                <div class="d-flex align-items-center">
                                    <div class="border-end pe-4 border-muted border-opacity-10">
                                        <h3 class="mb-1 fw-semibold fs-8">85%<sub class="fs-1">Baik</sub></h3>
                                        <p class="mb-0 text-dark fs-2">Capaian SLKI</p>
                                    </div>
                                    <div class="ps-4">
                                        <h3 class="mb-1 fw-semibold fs-8">78%<sub class="fs-1">Cukup</sub></h3>
                                        <p class="mb-0 text-dark fs-2">Kepatuhan Dokumentasi SIKI/SDKI</p>
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
            <div class="col-sm-6 col-lg-6 d-flex align-items-stretch">
                <div class="card w-100 border-primary border">
                    <div class="card-body p-4">
                        <h2 class="fw-semibold">95% <sub class="fs-1">Sangat Baik</sub></h2>
                        <p class="mb-0 fs-2">Kepatuhan Jam Visite Perawat</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-6 d-flex align-items-stretch">
                <div class="card w-100 border-primary border">
                    <div class="card-body p-4">
                        <h2 class="fw-semibold">82%</h4>
                        <p class="mb-0 fs-2">Kepatuhan SOP Keperawatan</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-lg-7 d-flex align-items-stretch">
                <div class="card w-100">
                    <div class="card-body">
                        <h4 class="card-title fw-semibold">Tren Kinerja Perawat per Bulan</h4>
                        <div id="tren-chart" class="revenue-chart mx-n3"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-5 d-flex align-items-stretch">
                <div class="card w-100">
                    <div class="card-body">
                        <h4 class="card-title fw-semibold mb-4">Distribusi Diagnosa Keperawatan Terbanyak</h4>
                        <div id="distribusi"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
    <script>
        var options = {
            series: [{
                name: "Kinerja",
                data: [40, 30, 60, 75, 90],
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
            stroke: {
                width: 5,
                curve: 'smooth',
                dashArray: [0],
            },
            dataLabels: {
                enabled: false,
            },
            legend: {
                show: false,
            },
            grid: {
                show: true,
            },
            yaxis: {
                min: 0,
                max: 100,
                tickAmount: 5,
                labels: {
                    formatter: function(value) {
                        return value + '%';
                    }
                },
            },
            xaxis: {
                categories: [
                    "Jan",
                    "Feb",
                    "Mar",
                    "Apr",
                    "Mei",
                ],
                show: false,
                axisTicks: {
                    show: false,
                },
                axisBorder: {
                    show: false,
                }
            },
            fill: {
                type: "gradient",
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.7,
                    opacityTo: 0,
                    colorStops: [
                        {
                            offset: 0,
                            color: "var(--bs-primary)",
                            opacity: 0.7
                        },
                        {
                            offset: 100,
                            color: "#ffffff",
                            opacity: 0
                        }
                    ]
                }
            },
            tooltip: {
                theme: "dark",
                y: {
                    formatter: function(value) {
                        return value + '%';
                    }
                },
            },
        };

        var chart = new ApexCharts(document.querySelector("#tren-chart"), options);
        chart.render();

        var total = 0;
        var series = [40, 25, 20, 15];
        series.forEach(function(item) {
            total += item;
        });
        var options = {
            color: "#adb5bd",
            series: series,
            labels: ['Nyeri Akut', 'Risiko Infeksi', 'Gangguan Mobilitas', 'Jalan Napas Tdk Efektif'],
            chart: {
                type: "donut",
                fontFamily: "inherit",
                foreColor: "#adb0bb",
                width: '100%',
                height: 350,
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '88%',
                        background: 'transparent',
                        labels: {
                            show: true,
                            name: {
                                show: true,
                                offsetY: 7,
                            },
                            value: {
                                show: false,
                            },
                            total: {
                                show: true,
                                color: '#7C8FAC',
                                fontSize: '20px',
                                fontWeight: "600",
                                label: total + '%',
                            },
                        },
                    },
                },
            },
            stroke: {
                show: false,
            },
            dataLabels: {
                enabled: false,
            },

            legend: {
                show: true,
                position: 'bottom',
            },
            colors: ["var(--bs-primary)", "var(--bs-secondary)", "var(--bs-success)", "var(--bs-warning)"],

            tooltip: {
                theme: "dark",
                fillSeriesColor: false,
            },
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        height: 400,
                    },
                    legend: {
                        position: 'bottom',
                    },
                },
            }],
        };

        var chart = new ApexCharts(document.querySelector("#distribusi"), options);
        chart.render();
    </script>
@endpush
