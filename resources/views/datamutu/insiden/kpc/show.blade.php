@extends('layouts.main')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white shadow-md rounded">
        <h2 class="text-2xl font-bold mb-6">Detail Laporan KPC</h2>

        <table class="table-auto w-full mb-6 border border-gray-300">
            <tbody>
                <tr>
                    <th class="border px-4 py-2 text-left">Waktu Insiden</th>
                    <td class="border px-4 py-2">{{ $kpc->waktu }}
                    </td>
                </tr>
                <tr>
                    <th class="border px-4 py-2 text-left">Temuan Kejadian/Insiden</th>
                    <td class="border px-4 py-2">{{ $kpc->temuan }}</td>
                </tr>
                <tr>
                    <th class="border px-4 py-2 text-left">Kronologis Insiden</th>
                    <td class="border px-4 py-2 whitespace-pre-line">{{ $kpc->kronologis }}</td>
                </tr>
                <tr>
                    <th class="border px-4 py-2 text-left">Sumber</th>
                    <td class="border px-4 py-2">{{ $kpc->sumber }}</td>
                </tr>
                 <tr>
                    <th class="border px-4 py-2 text-left">Unit Terkait</th>
                    <td class="border px-4 py-2">{{ $kpc->unit_terkait }}</td>
                </tr>
                <tr>
                    <th class="border px-4 py-2 text-left">Ruangan Pelapor</th>
                    <td class="border px-4 py-2">{{ $kpc->ruangan }}</td>
                </tr>
                
                <tr>
                    <th class="border px-4 py-2 text-left">Tindakan Yang Dilakukanh</th>
                    <td class="border px-4 py-2">{{ $kpc->tindakan }}</td>
                </tr>
                <tr>
                    <th class="border px-4 py-2 text-left">Pelaksana</th>
                    <td class="border px-4 py-2">{{ $kpc->pelaksana }}</td>
                </tr>
                <tr>
                    <th class="border px-4 py-2 text-left">Nama Inisial</th>
                    <td class="border px-4 py-2">{{ $kpc->nama_inisial }}</td>
                </tr>
                
                <tr>
                    <th class="border px-4 py-2 text-left">Foto</th>
                    <td class="border px-4 py-2">
                        @if ($kpc->foto)
                            <div class="row">
                                @foreach (json_decode($kpc->foto) as $img)
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

        <a href="{{ route('insiden.kpc.index') }}" class="btn btn-secondary">Kembali</a>

    </div>
@endsection
