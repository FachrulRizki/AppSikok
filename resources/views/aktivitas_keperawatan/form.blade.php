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
                        value="{{ old('waktu', isset($aktivitas_keperawatan) ? $aktivitas_keperawatan->waktu->format('Y-m-d\TH:i') : '') }}">
                </div>
                <div class="col">
                    <label class="form-label">Shift</label>
                    <select name="shift" class="form-select">
                        <option value="">Pilih Shift</option>
                        @foreach (['Pagi', 'Sore', 'Malam'] as $s)
                            <option value="{{ $s }}"
                                {{ old('shift', $aktivitas_keperawatan->shift ?? '') == $s ? 'selected' : '' }}>
                                {{ $s }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Nama Perawat</label>
                <input type="text" name="nama_perawat" class="form-control"
                    value="{{ old('nama_perawat', $aktivitas_keperawatan->nama_perawat ?? '') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Unit Kerja</label>
                <input type="text" name="unit_kerja" class="form-control"
                    value="{{ old('unit_kerja', $aktivitas_keperawatan->unit_kerja ?? '') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Aktivitas</label>
                @php
                    $list = [
                        'Asesmen awal / lanjutan',
                        'Intervensi / terapi keperawatan',
                        'Edukasi pasien/keluarga',
                        'Dokumentasi SOAP/SBAR',
                        'Serah terima pasien',
                        'Kegiatan pendukung lainnya',
                    ];
                    $selected = old('aktivitas', $aktivitas_keperawatan->aktivitas ?? []);
                @endphp
                @foreach ($list as $i => $label)
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="{{ $label }}" name="aktivitas[]" value="{{ $label }}"
                            {{ in_array($label, $selected) ? 'checked' : '' }}>
                        <label class="form-check-label" for="{{ $label }}">{{ $label }}</label>
                    </div>
                @endforeach
            </div>

            <div class="mb-3">
                <label class="form-label">Catatan Tambahan</label>
                <textarea name="catatan" class="form-control" rows="3">{{ old('catatan', $aktivitas_keperawatan->catatan ?? '') }}</textarea>
            </div>

            <div class="d-flex gap-3 mt-4">
                <button class="btn btn-primary" type="submit">Simpan</button>
                <a href="{{ route('aktivitas_keperawatan') }}" class="btn bg-primary-subtle text-primary">Kembali</a>
            </div>
        </div>
    </div>
</form>
