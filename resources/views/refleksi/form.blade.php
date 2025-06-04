<form action="{{ $route }}" method="POST">
    @csrf
    @if ($method === 'PUT')
        @method('PUT')
    @endif
    <div class="card">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col">
                    <label class="form-label">Tanggal</label>
                    <input type="datetime-local" name="waktu" class="form-control"
                        value="{{ old('waktu', isset($refleksi) ? $refleksi->waktu->format('Y-m-d\TH:i') : '') }}">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <label class="form-label">Judul Kegiatan</label>
                    <input type="text" name="jdl_kegiatan" class="form-control"
                        value="{{ old('jdl_kegiatan', $refleksi->jdl_kegiatan ?? '') }}">
                </div>

                <div class="col">
                    <label class="form-label">Unit Kerja</label>
                    <input type="text" name="unit_kerja" class="form-control"
                        value="{{ old('unit_kerja', $refleksi->unit_kerja ?? '') }}">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <label class="form-label">Nama Peserta</label>
                    <input type="text" name="nm_peserta" class="form-control"
                        value="{{ old('nm_peserta', $refleksi->nm_peserta ?? '') }}">
                </div>

                <div class="col">
                    <label class="form-label">Poin Materi</label>
                    <textarea name="poin_materi" class="form-control" rows="3">{{ old('poin_materi', $refleksi->poin_materi ?? '') }}</textarea>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <label class="form-label">Refleksi Pribadi</label>
                    <textarea name="pribadi" class="form-control" rows="3">{{ old('pribadi', $refleksi->pribadi ?? '') }}</textarea>
                </div>

                <div class="col">
                    <label class="form-label">Rencana Tindakan</label>
                    <textarea name="tindakan" class="form-control" rows="3">{{ old('tindakan', $refleksi->tindakan ?? '') }}</textarea>
                </div>
            </div>

            <div class="d-flex gap-3 mt-4">
                <button class="btn btn-primary" type="submit">Simpan</button>
                <a href="{{ route('refleksi') }}" class="btn bg-primary-subtle text-primary">Kembali</a>
            </div>
        </div>
    </div>
</form>
