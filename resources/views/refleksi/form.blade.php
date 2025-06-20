<form action="{{ $route }}" method="POST">
    @csrf
    @if ($method === 'PUT')
        @method('PUT')
    @endif
    <div class="card">
        <div class="card-body">
            @php
                use Carbon\Carbon;

                $defaultWaktu = old(
                    'waktu',
                    isset($refleksi) ? $refleksi->waktu->format('Y-m-d\TH:i') : Carbon::now()->format('Y-m-d\TH:i'),
                );
            @endphp

            <div class="mb-3">
                <label class="form-label">Tanggal & Waktu</label>
                <input type="datetime-local" name="waktu" class="form-control @error('waktu') is-invalid @enderror"
                    value="{{ $defaultWaktu }}" readonly>
                @error('waktu')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Jenis Kegiatan</label>
                <input type="text" name="jdl_kegiatan"
                    class="form-control @error('jdl_kegiatan') is-invalid @enderror"
                    value="{{ old('jdl_kegiatan', $refleksi->jdl_kegiatan ?? '') }}"
                    placeholder="contoh:Dinas Malam, 19 Juni 2025 (Sesuaikan Jadwal Dinas)">
                @error('jdl_kegiatan')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Poin Kegiatan</label>
                <textarea name="poin_materi" class="form-control @error('poin_materi') is-invalid @enderror" rows="3">{{ old('poin_materi', $refleksi->poin_materi ?? '') }}</textarea>
                @error('poin_materi')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="row mb-3">
                {{-- Kolom Evaluasi Pribadi --}}
                <div class="col-md-6 mb-3 mb-md-0">
                    <label class="form-label d-flex justify-content-between align-items-center">
                        <span><strong>Evaluasi Pribadi</strong></span>
                        <a class="btn btn-sm btn-outline-primary d-flex align-items-center gap-1"
                            data-bs-toggle="collapse" href="#petunjukEvaluasi" role="button" aria-expanded="false"
                            aria-controls="petunjukEvaluasi">
                            <i class="bi bi-info-circle"></i> Petunjuk
                        </a>
                    </label>

                    <!-- COLLAPSIBLE PETUNJUK -->
                    <div class="collapse mb-2" id="petunjukEvaluasi">
                        <div class="alert alert-info py-2 px-3 small border border-primary rounded-3">
                            <strong class="d-block mb-1"><i class="bi bi-lightbulb"></i> Cara Mengisi Evaluasi:</strong>
                            <ul class="mb-0 ps-3">
                                <li>1. Apa yang saya lakukan hari ini?</li>
                                <li>2. Apa yang saya rasakan selama bekerja?</li>
                                <li>3. Apa yang bisa saya tingkatkan?</li>
                                <li>4. Bagaimana saya mendukung inovasi <strong>SIKOK</strong> hari ini?</li>
                                <li>5. Apa makna pekerjaan saya hari ini?</li>
                            </ul>
                        </div>
                    </div>

                    <!-- TEXTAREA -->
                    <textarea name="pribadi" class="form-control @error('pribadi') is-invalid @enderror" rows="6"
                        placeholder="Tuliskan evaluasi pribadimu di sini Sesuai Petunjuk !">{{ old('pribadi', $refleksi->pribadi ?? '') }}</textarea>
                    @error('pribadi')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                {{-- Kolom Rencana Evaluasi --}}
                <div class="col-md-6">
                    <label class="form-label">Rencana Evaluasi</label>
                    <textarea name="tindakan" class="form-control @error('tindakan') is-invalid @enderror" rows="6">{{ old('tindakan', $refleksi->tindakan ?? '') }}</textarea>
                    @error('tindakan')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>


            <div class="d-flex gap-3 mt-4">
                <button class="btn btn-primary" type="submit">Simpan</button>
                <a href="{{ route('refleksi.index') }}" class="btn bg-primary-subtle text-primary">Kembali</a>
            </div>
        </div>
    </div>
</form>
