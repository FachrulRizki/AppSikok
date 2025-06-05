@extends('layouts.main')

@section('content')
    <div class="max-w-4xl mx-auto p-6 bg-white shadow-md rounded">
        <h2 class="text-2xl font-bold mb-6">Detail Laporan KTC</h2>

        <table class="w-full text-sm border border-gray-300">
            <tbody>
                <tr>
                    <th class="text-left bg-gray-100 p-2 w-1/3 border">No. RM</th>
                    <td class="p-2 border">{{ $ktc->no_rm }}</td>
                </tr>
                <tr>
                    <th class="text-left bg-gray-100 p-2 border">Nama Pasien</th>
                    <td class="p-2 border">{{ $ktc->nama_pasien }}</td>
                </tr>
                <tr>
                    <th class="text-left bg-gray-100 p-2 border">Umur</th>
                    <td class="p-2 border">{{ $ktc->umur }}</td>
                </tr>
                <tr>
                    <th class="text-left bg-gray-100 p-2 border">Jenis Kelamin</th>
                    <td class="p-2 border">{{ $ktc->jk }}</td>
                </tr>
                <tr>
                    <th class="text-left bg-gray-100 p-2 border">Waktu Masuk RS</th>
                    <td class="p-2 border">{{ $ktc->waktu_mskrs ?? '-' }}</td>
                </tr>
                <tr>
                    <th class="text-left bg-gray-100 p-2 border">Waktu Insiden</th>
                    <td class="p-2 border">{{ $ktc->waktu_insiden ?? '-' }}</td>
                </tr>
                <tr>
                    <th class="text-left bg-gray-100 p-2 border">Temuan</th>
                    <td class="p-2 border">{{ $ktc->temuan }}</td>
                </tr>
                <tr>
                    <th class="text-left bg-gray-100 p-2 border">Kronologis</th>
                    <td class="p-2 border whitespace-pre-line">{{ $ktc->kronologis }}</td>
                </tr>
                <tr>
                    <th class="text-left bg-gray-100 p-2 border">Unit Terkait</th>
                    <td class="p-2 border">{{ $ktc->unit_terkait }}</td>
                </tr>
                <tr>
                    <th class="text-left bg-gray-100 p-2 border">Sumber</th>
                    <td class="p-2 border">{{ $ktc->sumber }}</td>
                </tr>
                <tr>
                    <th class="text-left bg-gray-100 p-2 border">Rawat</th>
                    <td class="p-2 border">{{ $ktc->rawat }}</td>
                </tr>
                <tr>
                    <th class="text-left bg-gray-100 p-2 border">Poli</th>
                    <td class="p-2 border">{{ $ktc->poli }}</td>
                </tr>
                <tr>
                    <th class="text-left bg-gray-100 p-2 border">Lokasi</th>
                    <td class="p-2 border">{{ $ktc->lokasi }}</td>
                </tr>
                <tr>
                    <th class="text-left bg-gray-100 p-2 border">Unit</th>
                    <td class="p-2 border">{{ $ktc->unit }}</td>
                </tr>
                <tr>
                    <th class="text-left bg-gray-100 p-2 border">Tindakan Segera</th>
                    <td class="p-2 border whitespace-pre-line">{{ $ktc->tindakan_segera }}</td>
                </tr>
                <tr>
                    <th class="text-left bg-gray-100 p-2 border">Pelaksana</th>
                    <td class="p-2 border">{{ $ktc->pelaksana }}</td>
                </tr>
                <tr>
                    <th class="text-left bg-gray-100 p-2 border">Nama Inisial</th>
                    <td class="p-2 border">{{ $ktc->nama_inisial }}</td>
                </tr>
                <tr>
                    <th class="text-left bg-gray-100 p-2 border">Ruangan Pelapor</th>
                    <td class="p-2 border">{{ $ktc->ruangan_pelapor }}</td>
                </tr>

                <tr>
                    <th class="border px-4 py-2 text-left">Foto</th>
                    <td class="border px-4 py-2">
                        @if ($ktc->foto)
                            <div class="row">
                                @foreach (json_decode($ktc->foto) as $img)
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
            <a href="{{ route('insiden.ktc.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
@endsection
