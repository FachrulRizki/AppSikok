@extends('layouts.main')

@section('title', 'Beranda')

@section('page-title', 'Dashboard Penilaian')

@section('content')
    <!-- Masukkan isi konten halaman di sini -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white p-4 rounded shadow">
            <div class="text-gray-500">Capaian SLK</div>
            <div class="text-2xl font-bold" id="slki-score">85%</div>
            <div class="text-sm text-green-600">Baik</div>
        </div>
        <div class="bg-white p-4 rounded shadow">
            <div class="text-gray-500">Dokumentasi SIKI/SDKI</div>
            <div class="text-2xl font-bold" id="siki-score">78%</div>
            <div class="text-sm text-yellow-600">Cukup</div>
        </div>
        <div class="bg-white p-4 rounded shadow">
            <div class="text-gray-500">Jam Visite Perawat</div>
            <div class="text-2xl font-bold" id="visite-score">95%</div>
            <div class="text-sm text-green-700">Sangat Baik</div>
        </div>
        <div class="bg-white p-4 rounded shadow">
            <div class="text-gray-500">Kepatuhan SOP</div>
            <div class="text-2xl font-bold" id="sop-score">82%</div>
            <div class="text-sm text-blue-600">Baik</div>
        </div>
    </div>

    <!-- Contoh Chart -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
        <div class="bg-white p-4 rounded shadow">
            <h2 class="font-semibold mb-2">Tren Kinerja Perawat per Bulan</h2>
            <canvas id="performanceChart"></canvas>
        </div>
        <div class="bg-white p-4 rounded shadow">
            <h2 class="font-semibold mb-2">Distribusi Diagnosa Keperawatan</h2>
            <canvas id="diagnosaChart"></canvas>
        </div>
    </div>

    <script>
        const ctx1 = document.getElementById('performanceChart').getContext('2d');
        new Chart(ctx1, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr'],
                datasets: [{
                    label: 'Kinerja',
                    data: [45, 60, 75, 90],
                    backgroundColor: 'rgba(16, 185, 129, 0.2)',
                    borderColor: 'rgba(16, 185, 129, 1)',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });

        const ctx2 = document.getElementById('diagnosaChart').getContext('2d');
        new Chart(ctx2, {
            type: 'pie',
            data: {
                labels: ['Nyeri Akut', 'Risiko Infeksi', 'Gangguan Mobilitas', 'Jalan Napas Tdk Efektif'],
                datasets: [{
                    data: [40, 25, 20, 15],
                    backgroundColor: ['#4ade80', '#60a5fa', '#facc15', '#f87171']
                }]
            },
            options: {
                responsive: true
            }
        });
    </script>
@endsection
