<form action="{{ $route }}" method="POST" id="app">
    @csrf
    @if ($method === 'PUT')
        @method('PUT')
    @endif
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-6 mb-3">
                    <label class="form-label">Tanggal & Waktu</label>
                    <input type="datetime-local" name="waktu" class="form-control @error('waktu') is-invalid @enderror"
                        value="{{ old('waktu', isset($cuci_tangan) ? $cuci_tangan->waktu->format('Y-m-d\TH:i') : '') }}">
                    @error('waktu')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col-lg-6 mb-3">
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
                <table class="table w-100">
                    <thead>
                        <tr class="text-nowrap">
                            <th>Aktivitas</th>
                            <th>Detail Aktivitas</th>
                            <th>Catatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($activities as $activity)
                            <tr>
                                <td class="align-top">
                                    {{ $activity['id'] }}. {{ $activity['nama'] }}
                                </td>
                                <td>
                                    @foreach ($activity['details'] ?? [] as $detail)
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="details[]"
                                                value="{{ $detail['id'] }}" id="detail_{{ $detail['id'] }}"
                                                {{ in_array($detail['id'], old('details', $selectedDetails ?? [])) ? 'checked' : '' }}>
                                            <label class="form-check-label"
                                                for="detail_{{ $detail['id'] }}">
                                                {{ $detail['id'] }}. {{ $detail['nama'] }}
                                            </label>
                                        </div>
                                        @if (!empty($detail['tasks']))
                                            @php
                                                $grouped = collect($detail['tasks'])->groupBy('tipe');
                                            @endphp
                                            @foreach ($grouped as $tipe => $tasks)
                                                <div class="ms-2 mb-3">
                                                    @foreach ($tasks as $task)
                                                        <div class="form-check ms-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="tasks[{{ $detail['id'] }}][]"
                                                                value="{{ $task['id'] }}"
                                                                id="task_{{ $task['id'] }}"
                                                                {{ in_array($task['id'], old('tasks.' . $detail['id'], $selectedTasks[$detail['id']] ?? [])) ? 'checked' : '' }}>
                                                            <label class="form-check-label"
                                                                for="task_{{ $task['id'] }}">
                                                                {{ $task['id'] }}. {{ $task['nama'] }}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endforeach
                                        @endif
                                    @endforeach
                                </td>
                                <td class="align-top">
                                    <div class="mb-3">
                                        <label class="form-label">Catatan untuk {{ $activity['nama'] }}</label>
                                        <textarea class="form-control" name="notes[{{ $activity['id'] }}]" rows="5">{{ old('notes.' . $activity['id'], $notes[$activity['id']] ?? '') }}</textarea>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="d-flex gap-3 mt-4">
                    <button class="btn btn-primary" type="submit">Simpan</button>
                    <a href="{{ route('cuci_tangan.index') }}" class="btn bg-primary-subtle text-primary">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</form>
