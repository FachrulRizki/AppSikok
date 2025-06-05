@extends('layouts.main')

@section('content')
    <div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">
        <h2 class="text-2xl font-bold mb-4">Detail KTD (Kejadian Tidak Diharapkan)</h2>

        <table class="table-auto w-full border border-gray-300 text-sm">
            <tbody>
                <tr>
                    <th class="text-left p-2 border">No RM</th>
                    <td class="p-2 border">{{ $ktd->no_rm }}</td>
                </tr>
                <tr>
                    <th class="text-left p-2 border">Nama Pasien</th>
                    <td class="p-2 border">{{ $ktd->nama_pasien }}</td>
                </tr>
                <tr>
                    <th class="text-left p-2 border">Umur</th>
                    <td class="p-2 border">{{ $ktd->umur }} tahun</td>
                </tr>
                <tr>
                    <th class="text-left p-2 border">Jenis Kelamin</th>
                    <td class="p-2 border">{{ $ktd->jk }}</td>
                </tr>
                <tr>
                    <th class="text-left p-2 border">Waktu Masuk RS</th>
                    <td class="p-2 border">{{ $ktd->waktu_mskrs ?? '-' }}</td>
                </tr>
                <tr>
                    <th class="text-left p-2 border">Waktu Insiden</th>
                    <td class="p-2 border">{{ $ktd->waktu_insiden ?? '-' }}</td>
                </tr>
                <tr>
                    <th class="text-left p-2 border">Temuan</th>
                    <td class="p-2 border">{{ $ktd->temuan }}</td>
                </tr>
                <tr>
                    <th class="text-left p-2 border">Kronologis</th>
                    <td class="p-2 border">{{ $ktd->kronologis }}</td>
                </tr>
                <tr>
                    <th class="text-left p-2 border">Unit Terkait</th>
                    <td class="p-2 border">{{ $ktd->unit_terkait }}</td>
                </tr>
                <tr>
                    <th class="text-left p-2 border">Sumber</th>
                    <td class="p-2 border">{{ $ktd->sumber }}</td>
                </tr>
                <tr>
                    <th class="text-left p-2 border">Rawat</th>
                    <td class="p-2 border">{{ $ktd->rawat }}</td>
                </tr>
                <tr>
                    <th class="text-left p-2 border">Poli</th>
                    <td class="p-2 border">{{ $ktd->poli }}</td>
                </tr>
                <tr>
                    <th class="text-left p-2 border">Lokasi</th>
                    <td class="p-2 border">{{ $ktd->lokasi }}</td>
                </tr>
                <tr>
                    <th class="text-left p-2 border">Tindakan Segera</th>
                    <td class="p-2 border">{{ $ktd->tindakan_segera }}</td>
                </tr>
                <tr>
                    <th class="text-left p-2 border">Pelaksana</th>
                    <td class="p-2 border">{{ $ktd->pelaksana }}</td>
                </tr>
                <tr>
                    <th class="text-left p-2 border">Akibat</th>
                    <td class="p-2 border">{{ $ktd->akibat }}</td>
                </tr>
                <tr>
                    <th class="text-left p-2 border">Nama Inisial</th>
                    <td class="p-2 border">{{ $ktd->nama_inisial }}</td>
                </tr>
                <tr>
                    <th class="text-left p-2 border">Ruangan Pelapor</th>
                    <td class="p-2 border">{{ $ktd->ruangan_pelapor }}</td>
                </tr>

                <tr>
                    <th class="border px-4 py-2 text-left">Foto</th>
                    <td class="border px-4 py-2">
                        @if ($ktd->foto)
                            <div class="row">
                                @foreach (json_decode($ktd->foto) as $img)
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
            <a href="{{ route('insiden.ktd.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
@endsection
