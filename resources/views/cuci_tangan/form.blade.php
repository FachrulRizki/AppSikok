<form action="{{ $route }}" method="POST">
    @csrf
    @if ($method === 'PUT')
        @method('PUT')
    @endif
    <div class="card">
        <div class="card-body">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col">
                            <label class="form-label">Tanggal & Waktu</label>
                            <input type="datetime-local" name="waktu"
                                class="form-control @error('waktu') is-invalid @enderror"
                                value="{{ old('waktu', isset($cuci_tangan) ? $cuci_tangan->waktu->format('Y-m-d\TH:i') : '') }}">
                            @error('waktu')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col">
                            <label class="form-label">Shift</label>
                            <select name="shift" class="form-select @error('shift') is-invalid @enderror">
                                <option value="">Pilih Shift</option>
                                @foreach (['Pagi', 'Sore', 'Malam'] as $s)
                                    <option value="{{ $s }}"
                                        {{ old('shift', $cuci_tangan->shift ?? '') == $s ? 'selected' : '' }}>
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
                        <form action="{{ route('cuci_tangan.store') }}" method="POST">
                            @csrf
                            <table class="table w-100">
                                <thead>
                                    <tr class="text-nowrap">
                                        <th>Momen Cuci Tangan</th>
                                        <th>Sudah Dilaksanakan</th>
                                        <th>Catatan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $cuciTangan = [
                                            'Sebelum Menyentuh Pasien',
                                            'Sebelum Tindakan Aseptik',
                                            'Setelah Terpapar Cairan Tubuh Pasien',
                                            'Setelah Menyentuh Pasien',
                                            'Setelah Menyentuh Lingkungan Sekitar Pasien',
                                        ];
                                    @endphp

                                    @foreach ($cuciTangan as $i => $momen)
                                        <tr>
                                            <td>{{ $momen }}</td>
                                            <td>
                                                <div class="form-check form-check-inline">
                                                    <input type="radio" class="form-check-input"
                                                        name="dilaksanakan[{{ $i }}]"
                                                        id="ya{{ $i }}" value="Ya">
                                                    <label class="form-check-label"
                                                        for="ya{{ $i }}">Ya</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input type="radio" class="form-check-input"
                                                        name="dilaksanakan[{{ $i }}]"
                                                        id="tidak{{ $i }}" value="Tidak">
                                                    <label class="form-check-label"
                                                        for="tidak{{ $i }}">Tidak</label>
                                                </div>
                                            </td>
                                            <td>
                                                <textarea name="catatan[{{ $i }}]" rows="3" class="form-control" placeholder="Tulis catatan..."></textarea>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="d-flex gap-3 mt-4">
                                <button class="btn btn-primary" type="submit">Simpan</button>
                                <a href="{{ route('cuci_tangan.index') }}"
                                    class="btn bg-primary-subtle text-primary">Kembali</a>
                            </div>
                        </form>
                    </div>


                </div>
            </div>
        </div>
    </div>
</form>
