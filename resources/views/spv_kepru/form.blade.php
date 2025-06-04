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
                        value="{{ old('waktu', isset($spv_kepru) ? $spv_kepru->waktu->format('Y-m-d\TH:i') : '') }}">
                </div>

                <div class="col">
                    <label class="form-label">Nama Kepala Ruangan</label>
                    <input type="text" name="nm_kepru" class="form-control"
                        value="{{ old('nm_kepru', $spv_kepru->nm_kepru ?? '') }}">
                </div>
            </div>

            <div class="row mb-3">
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
                <label class="form-label">Fokus Supervisi</label>
                @php
                    $list = [
                        'Komunikasi',
                        'Prosedur klinis',
                        'Kepatuhan mutu',
                    ];
                    $selected = old('aktivitas', $spv_kepru->aktivitas ?? []);
                @endphp
                @foreach ($list as $i => $label)
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="aktivitas[]" id="{{ $label }}" value="{{ $label }}"
                            {{ in_array($label, $selected) ? 'checked' : '' }}>
                        <label class="form-check-label" for="{{ $label }}">{{ $label }}</label>
                    </div>
                @endforeach
            </div>

            <div class="row mb-3">
                <div class="col">
                    <label class="form-label">Catatan Observasi</label>
                    <textarea name="observasi" class="form-control" rows="3">{{ old('observasi', $spv_kepru->observasi ?? '') }}</textarea>
                </div>

                <div class="col">
                    <label class="form-label">Saran Perbaikan</label>
                    <textarea name="perbaikan" class="form-control" rows="3">{{ old('tindakan', $spv_kepru->tindakan ?? '') }}</textarea>
                </div>
            </div>

            <div class="d-flex gap-3 mt-4">
                <button class="btn btn-primary" type="submit">Simpan</button>
                <a href="{{ route('spv_kepru') }}" class="btn bg-primary-subtle text-primary">Kembali</a>
            </div>
        </div>
    </div>
</form>
