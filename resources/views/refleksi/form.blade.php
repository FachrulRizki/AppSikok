<form action="{{ $route }}" method="POST">
    @csrf
    @if ($method === 'PUT')
        @method('PUT')
    @endif
    <div class="card">
        <div class="card-body">
            <div class="mb-3">
                <label class="form-label">Jenis Kegiatan</label>
                    <textarea name="jdl_kegiatan" class="form-control @error('jdl_kegiatan') is-invalid @enderror" rows="3">{{ old('jdl_kegiatan', $refleksi->jdl_kegiatan ?? '') }}</textarea>
                @error('jdl_kegiatan')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Tanggal & Waktu</label>
                <input type="datetime-local" name="waktu" class="form-control @error('waktu') is-invalid @enderror" value="{{ old('waktu', isset($refleksi) ? $refleksi->waktu->format('Y-m-d\TH:i') : '') }}">
                @error('waktu')
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
                <div class="col">
                    <label class="form-label">Evaluasi Pribadi</label>
                    <textarea name="pribadi" class="form-control @error('pribadi') is-invalid @enderror" rows="3">{{ old('pribadi', $refleksi->pribadi ?? '') }}</textarea>
                    @error('pribadi')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="col">
                    <label class="form-label">Rencana Evaluasi</label>
                    <textarea name="tindakan" class="form-control @error('tindakan') is-invalid @enderror" rows="3">{{ old('tindakan', $refleksi->tindakan ?? '') }}</textarea>
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
