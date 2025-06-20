<form action="{{ $route }}" method="POST">
    @csrf
    @if ($method === 'PUT')
        @method('PUT')
    @endif
    <div class="card">
        <div class="card-body">
            <div class="row mb-3">
                @php
                    use Carbon\Carbon;

                    $defaultWaktu = old(
                        'waktu',
                        isset($spv_kepru) && $spv_kepru->waktu
                            ? $spv_kepru->waktu->format('Y-m-d\TH:i')
                            : Carbon::now()->format('Y-m-d\TH:i'),
                    );
                @endphp

                <div class="col">
                    <label class="form-label">Tanggal & Waktu</label>
                    <input type="datetime-local" name="waktu" class="form-control @error('waktu') is-invalid @enderror"
                        value="{{ $defaultWaktu }}" readonly>
                    @error('waktu')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="col">
                    <label class="form-label">Ruangan</label>
                    <select name="ruangan" class="form-select @error('ruangan') is-invalid @enderror">
                        <option value="">Pilih Ruangan</option>
                        @foreach (['OK', 'IGD', 'ICU', 'POLI', 'RIA', 'RID', 'PAIDA', 'VIP', 'Kebidanan', 'PONEK', 'NICU', 'FARMASI', 'LABORATORIUM', 'RADIOLOGI', 'GUDANG OBAT'] as $r)
                            <option value="{{ $r }}"
                                {{ old('ruangan', $spv_kepru->ruangan ?? '') == $r ? 'selected' : '' }}>
                                {{ $r }}</option>
                        @endforeach
                    </select>
                    @error('ruangan')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <label class="form-label">Shift</label>
                    <select name="shift" class="form-select @error('shift') is-invalid @enderror">
                        <option value="">Pilih Shift</option>
                        @foreach (['Pagi', 'Sore', 'Malam'] as $s)
                            <option value="{{ $s }}"
                                {{ old('shift', $spv_kepru->shift ?? '') == $s ? 'selected' : '' }}>
                                {{ $s }}</option>
                        @endforeach
                    </select>
                    @error('shift')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Fokus Supervisi</label>
                @php
                    $list = ['Komunikasi', 'Prosedur klinis', 'Kepatuhan mutu'];
                    $selected = old('aktivitas', $spv_kepru->aktivitas ?? []);
                @endphp
                @foreach ($list as $i => $label)
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input @error('aktivitas') is-invalid @enderror"
                            name="aktivitas[]" id="{{ $label }}" value="{{ $label }}"
                            {{ in_array($label, $selected) ? 'checked' : '' }}>
                        <label class="form-check-label" for="{{ $label }}">{{ $label }}</label>
                    </div>
                @endforeach
                @error('aktivitas')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="row mb-3">
                <div class="col">
                    <label class="form-label">Catatan Observasi</label>
                    <textarea name="observasi" class="form-control @error('observasi') is-invalid @enderror" rows="3">{{ old('observasi', $spv_kepru->observasi ?? '') }}</textarea>
                    @error('observasi')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="col">
                    <label class="form-label">Saran Perbaikan</label>
                    <textarea name="perbaikan" class="form-control @error('perbaikan') is-invalid @enderror" rows="3">{{ old('perbaikan', $spv_kepru->perbaikan ?? '') }}</textarea>
                    @error('perbaikan')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="d-flex gap-3 mt-4">
                <button class="btn btn-primary" type="submit">Simpan</button>
                <a href="{{ route('spv_kepru.index') }}" class="btn bg-primary-subtle text-primary">Kembali</a>
            </div>
        </div>
    </div>
</form>
