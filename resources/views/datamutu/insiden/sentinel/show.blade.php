@extends('layouts.main')

@section('content')
    <div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">
        <h2 class="text-2xl font-bold mb-4">DETAIL LAPORAN INSIDEN KEJADIAN SENTINEL</h2>

        <table class="table-auto w-full border border-gray-300 text-sm">
            <tbody>
                <tr>
                    <th class="text-left p-2 border">No RM</th>
                    <td class="p-2 border">{{ $sentinel->no_rm }}</td>
                </tr>
                <tr>
                    <th class="text-left p-2 border">Nama Pasien</th>
                    <td class="p-2 border">{{ $sentinel->nama_pasien }}</td>
                </tr>
                <tr>
                    <th class="text-left p-2 border">Umur</th>
                    <td class="p-2 border">{{ $sentinel->umur }} tahun</td>
                </tr>
                <tr>
                    <th class="text-left p-2 border">Jenis Kelamin</th>
                    <td class="p-2 border">{{ $sentinel->jk }}</td>
                </tr>
                <tr>
                    <th class="text-left p-2 border">Waktu Masuk RS</th>
                    <td class="p-2 border">{{ $sentinel->waktu_mskrs ?? '-' }}</td>
                </tr>
                <tr>
                    <th class="text-left p-2 border">Waktu Insiden</th>
                    <td class="p-2 border">{{ $sentinel->waktu_insiden ?? '-' }}</td>
                </tr>
                <tr>
                    <th class="text-left p-2 border">Temuan</th>
                    <td class="p-2 border">{{ $sentinel->temuan }}</td>
                </tr>
                <tr>
                    <th class="text-left p-2 border">Kronologis</th>
                    <td class="p-2 border">{{ $sentinel->kronologis }}</td>
                </tr>
                <tr>
                    <th class="text-left p-2 border">Unit Terkait</th>
                    <td class="p-2 border">{{ $sentinel->unit_terkait }}</td>
                </tr>
                <tr>
                    <th class="text-left p-2 border">Sumber</th>
                    <td class="p-2 border">{{ $sentinel->sumber }}</td>
                </tr>
                <tr>
                    <th class="text-left p-2 border">Rawat</th>
                    <td class="p-2 border">{{ $sentinel->rawat }}</td>
                </tr>
                <tr>
                    <th class="text-left p-2 border">Poli</th>
                    <td class="p-2 border">{{ $sentinel->poli }}</td>
                </tr>
                <tr>
                    <th class="text-left p-2 border">Lokasi</th>
                    <td class="p-2 border">{{ $sentinel->lokasi }}</td>
                </tr>
                <tr>
                    <th class="text-left p-2 border">Tindakan Segera</th>
                    <td class="p-2 border">{{ $sentinel->tindakan_segera }}</td>
                </tr>
                <tr>
                    <th class="text-left p-2 border">Pelaksana</th>
                    <td class="p-2 border">{{ $sentinel->pelaksana }}</td>
                </tr>
                <tr>
                    <th class="text-left p-2 border">Akibat</th>
                    <td class="p-2 border">{{ $sentinel->akibat }}</td>
                </tr>
                <tr>
                    <th class="text-left p-2 border">Nama Inisial</th>
                    <td class="p-2 border">{{ $sentinel->nama_inisial }}</td>
                </tr>
                <tr>
                    <th class="text-left p-2 border">Ruangan Pelapor</th>
                    <td class="p-2 border">{{ $sentinel->ruangan_pelapor }}</td>
                </tr>

                <tr>
                    <th class="border px-4 py-2 text-left">Foto</th>
                    <td class="border px-4 py-2">
                        @if ($sentinel->foto)
                            <div class="row">
                                @foreach (json_decode($sentinel->foto) as $img)
                                    <div class="col-md-3">
                                        <a href="{{ asset('storage/' . $img) }}" target="_blank" rel="noopener">
                                            <img src="{{ asset('storage/' . $img) }}" alt="Foto"
                                                style="max-width: 150px; cursor: pointer;">
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="mt-6">
            <a href="{{ route('insiden.sentinel.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
@endsection
