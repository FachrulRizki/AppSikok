<form action="{{ $route }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if ($method === 'PUT')
        @method('PUT')
    @endif

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tanggal & Waktu</label>
                    <input type="datetime-local" name="waktu" class="form-control @error('waktu') is-invalid @enderror"
                        value="{{ old('waktu', isset($lima_r) ? $lima_r->waktu->format('Y-m-d\TH:i') : '') }}">
                    @error('waktu')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Shift</label>
                    <select name="shift" class="form-select @error('shift') is-invalid @enderror">
                        <option value="">Pilih Shift</option>
                        @foreach (['Pagi', 'Sore', 'Malam'] as $s)
                            <option value="{{ $s }}"
                                {{ old('shift', $lima_r->shift ?? '') == $s ? 'selected' : '' }}>
                                {{ $s }}</option>
                        @endforeach
                    </select>
                    @error('shift')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div><br>

            <div class="table-responsive border-top">
                <table class="table w-100 text-nowrap">
                    <thead>
                        <tr class="text-nowrap">
                            <th>Prinsip 5R</th>
                            <th>Kegiatan</th>
                            <th>Sudah Dilaksanakan</th>
                            <th>Catatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $prinsip5R = ['Ringkas', 'Rapi', 'Resik', 'Rawat', 'Rajin'];
                            $kegiatan = [
                                'Memilih barang yang diperlukan dan tidak',
                                'Menata alat dan perlengkapan dengan teratur',
                                'Menjaga kebersihan lingkungan kerja',
                                'Merawat dan memelihara peralatan dengan baik',
                                'Melakukan kegiatan secara konsisten dan rutin',
                            ];
                        @endphp

                        @foreach ($prinsip5R as $i => $prinsip)
                            <tr>
                                <td>{{ $prinsip }}</td>
                                <td>{{ $kegiatan[$i] ?? '' }}</td>
                                <td>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" class="form-check-input"
                                            name="dilaksanakan[{{ $i }}]" id="ya{{ $i }}"
                                            value="Ya">
                                        <label class="form-check-label" for="ya{{ $i }}">Ya</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" class="form-check-input"
                                            name="dilaksanakan[{{ $i }}]" id="tidak{{ $i }}"
                                            value="Tidak">
                                        <label class="form-check-label" for="tidak{{ $i }}">Tidak</label>
                                    </div>
                                </td>
                                <td>
                                    <textarea style="min-width: 200px" name="catatan[{{ $i }}]" rows="3" class="form-control" placeholder="Tulis catatan..."></textarea>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>

                <div class="mb-3">
                        <label class="form-label">Lampiran Foto (opsional)</label>
                        <input type="file" name="foto[]" class="form-control @error('foto') is-invalid @enderror"
                            multiple accept="image/*">
                        <div class="form-text">Maksimal 5 file. Ukuran maks 100 MB per file.</div>
                        @error('foto')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
            </div>

            <div class="d-flex gap-3 mt-4">
                <button class="btn btn-primary" type="submit">Simpan</button>
                <a href="{{ route('lima_r.index') }}" class="btn bg-primary-subtle text-primary">Kembali</a>
            </div>
        </div>
    </div>
</form>
