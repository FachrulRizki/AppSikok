@extends('layouts.main')

@section('content')
    <div class="max-w-4xl mx-auto p-6 bg-white shadow-md rounded">
        <h2 class="text-2xl font-bold mb-6">Detail Laporan KNC</h2>

        <table class="table-auto w-full mb-6 border border-gray-300">
            <tbody>
                <tr>
                    <th class="border px-4 py-2 text-left">No. RM</th>
                    <td class="border px-4 py-2">{{ $knc->no_rm }}</td>
                </tr>
                <tr>
                    <th class="border px-4 py-2 text-left">Nama Pasien</th>
                    <td class="border px-4 py-2">{{ $knc->nama_pasien }}</td>
                </tr>
                <tr>
                    <th class="border px-4 py-2 text-left">Umur</th>
                    <td class="border px-4 py-2">{{ $knc->umur }}</td>
                </tr>
                <tr>
                    <th class="border px-4 py-2 text-left">Jenis Kelamin</th>
                    <td class="border px-4 py-2">{{ $knc->jk }}</td>
                </tr>
                <tr>
                    <th class="border px-4 py-2 text-left">Waktu Masuk RS</th>
                    <td class="border px-4 py-2">{{ $knc->waktu_mskrs ? $knc->waktu_mskrs->format('d-m-Y H:i') : '-' }}</td>
                </tr>
                <tr>
                    <th class="border px-4 py-2 text-left">Waktu Insiden</th>
                    <td class="border px-4 py-2">{{ $knc->waktu_insiden ? $knc->waktu_insiden->format('d-m-Y H:i') : '-' }}
                    </td>
                </tr>
                <tr>
                    <th class="border px-4 py-2 text-left">Temuan</th>
                    <td class="border px-4 py-2">{{ $knc->temuan }}</td>
                </tr>
                <tr>
                    <th class="border px-4 py-2 text-left">Kronologis</th>
                    <td class="border px-4 py-2 whitespace-pre-line">{{ $knc->kronologis }}</td>
                </tr>
                <tr>
                    <th class="border px-4 py-2 text-left">Unit Terkait</th>
                    <td class="border px-4 py-2">{{ $knc->unit_terkait }}</td>
                </tr>
                <tr>
                    <th class="border px-4 py-2 text-left">Sumber</th>
                    <td class="border px-4 py-2">{{ $knc->sumber }}</td>
                </tr>
                <tr>
                    <th class="border px-4 py-2 text-left">Rawat</th>
                    <td class="border px-4 py-2">{{ $knc->rawat }}</td>
                </tr>
                <tr>
                    <th class="border px-4 py-2 text-left">Poli</th>
                    <td class="border px-4 py-2">{{ $knc->poli }}</td>
                </tr>
                <tr>
                    <th class="border px-4 py-2 text-left">Pelaksana</th>
                    <td class="border px-4 py-2">{{ $knc->pelaksana }}</td>
                </tr>
                <tr>
                    <th class="border px-4 py-2 text-left">Nama Inisial</th>
                    <td class="border px-4 py-2">{{ $knc->nama_inisial }}</td>
                </tr>
                <tr>
                    <th class="border px-4 py-2 text-left">Ruangan Pelapor</th>
                    <td class="border px-4 py-2">{{ $knc->ruangan_pelapor }}</td>
                </tr>
                <tr>
                    <th class="border px-4 py-2 text-left">Foto</th>
                    <td class="border px-4 py-2">
                        @if ($knc->foto)
                            <div class="row">
                                @foreach (json_decode($knc->foto) as $img)
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

        <a href="{{ route('insiden.knc.index') }}" class="btn btn-secondary">Kembali</a>

    </div>
@endsection
