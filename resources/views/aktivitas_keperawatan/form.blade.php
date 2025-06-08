<form action="{{ $route }}" method="POST" id="app">
    @csrf
    @if ($method === 'PUT')
        @method('PUT')
    @endif

    <div class="card">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col">
                    <label class="form-label">Tanggal & Waktu</label>
                    <input type="datetime-local" name="waktu" class="form-control @error('waktu') is-invalid @enderror" value="{{ old('waktu', isset($aktivitas_keperawatan) ? $aktivitas_keperawatan->waktu->format('Y-m-d\TH:i') : '') }}">
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
                                {{ old('shift', $aktivitas_keperawatan->shift ?? '') == $s ? 'selected' : '' }}>
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

            <div class="mb-4">
                <label class="form-label">Catatan Tambahan</label>
                <textarea name="catatan" class="form-control @error('catatan') is-invalid @enderror" rows="3">{{ old('catatan', $aktivitas_keperawatan->catatan ?? '') }}</textarea>
                @error('catatan')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="table-responsive border-top">
                <table class="table w-100">
                    <thead>
                        <tr class="text-nowrap">
                            <th>Aktivitas Keperawatan</th>
                            <th>Detail Aktivitas</th>
                            <th>Jenis Kegiatan</th>
                            <th>Catatan Aktivitas</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(act, actIdx) in activities" :key="act.id">
                            <td>
                                <div class="form-check">
                                    <input 
                                        type="checkbox" 
                                        :id="'activity_' + act.id" 
                                        :value="act.id" 
                                        :checked="selectedActivities.includes(act.id)"
                                        @change="toggleActivity(act)"
                                        class="form-check-input">
                                    <label :for="'activity_' + act.id" class="form-check-label">@{{ act.kode }}. @{{ act.nama }}</label>
                                </div>
                            </td>
                            <td>
                                <div v-if="selectedActivities.includes(act.id)">
                                    <div class="mb-2 fw-semibold">@{{ act.kode }}. @{{ act.nama }}</div>
                                    <div v-for="detail in act.activity_details" :key="detail.id" class="form-check">
                                        <input 
                                            type="checkbox" 
                                            :id="'detail_' + detail.id" 
                                            :value="detail.id" 
                                            :checked="selectedDetails[act.id]?.includes(detail.id)"
                                            @change="toggleDetail(detail, act.id)"
                                            class="form-check-input">
                                        <label :for="'detail_' + detail.id" class="form-check-label">@{{ detail.kode }}. @{{ detail.nama }}</label>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div v-for="detail in act.activity_details.filter(d => selectedDetails[act.id]?.includes(d.id))" :key="detail.id" class="mb-3">
                                    <div class="mb-2 fw-semibold">@{{ detail.kode }}. @{{ detail.nama }}</div>
                                    <div v-for="(groupedTasks, tipe) in groupTasks(detail.activity_tasks)" :key="tipe" class="mb-2">
                                        <div class="form-check">
                                            <input type="checkbox" :checked="isGroupChecked(detail.id, groupedTasks)" @change="toggleGroup(detail.id, groupedTasks, $event)" class="form-check-input">
                                            <label class="form-check-label fw-semibold">@{{ tipe }} :</label>
                                        </div>
                                        <div v-for="task in groupedTasks" :key="task.id" class="form-check ms-4">
                                            <input
                                                type="checkbox"
                                                :id="'task_' + task.id" 
                                                :checked="selectedTasks[detail.id]?.includes(task.id)"
                                                @change="toggleTask(detail.id, task.id, $event)"
                                                class="form-check-input">
                                            <label :for="'task_' + task.id" class="form-check-label">@{{ task.nama }}</label>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div v-for="detail in act.activity_details.filter(d => selectedDetails[act.id]?.includes(d.id))" :key="detail.id" class="mb-3">
                                    <div class="mb-2 fw-semibold">@{{ detail.kode }}. @{{ detail.nama }}</div>
                                    <textarea class="form-control" v-model="notes[detail.id]" style="width: 250px"></textarea>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="d-flex gap-3 mt-4">
                <button class="btn btn-primary" type="submit">Simpan</button>
                <a href="{{ route('aktivitas_keperawatan.index') }}" class="btn bg-primary-subtle text-primary">Kembali</a>
            </div>
        </div>

        <input type="hidden" name="selectedActivities" :value="JSON.stringify(selectedActivities)">
        <input type="hidden" name="selectedDetails" :value="JSON.stringify(selectedDetails)">
        <input type="hidden" name="selectedTasks" :value="JSON.stringify(selectedTasks)">
        <input type="hidden" name="notes" :value="JSON.stringify(notes)">
    </div>
</form>

<script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
<script>
const { createApp } = Vue;

createApp({
    data() {
        return {
            activities: @json($activities),
            selectedActivities: [],
            selectedDetails: {},
            selectedTasks: {},
            notes: {},
        }
    },
    mounted() {
        @if (isset($aktivitas_keperawatan))
            const existingDetails = @json($details ?? []);
            const existingTasks = @json($tasks ?? []);
            const existingNotes = @json($notes ?? []);

            this.selectedActivities = Object.keys(existingDetails).map(id => Number(id))

            for (const [activityId, detailIds] of Object.entries(existingDetails)) {
                this.selectedDetails[activityId] = detailIds
            }

            for (const [detailId, taskIds] of Object.entries(existingTasks)) {
                this.selectedTasks[detailId] = taskIds
            }

            this.notes = existingNotes
        @endif
    },
    methods: {
        getActivityIdByDetail(detailId) {
            for (const act of this.activities) {
                for (const detail of act.details) {
                    if (detail.id === detailId) {
                        return act.id;
                    }
                }
            }
            return null;
        },
        selectedTasksForDetail(detailId) {
            if (!Array.isArray(this.selectedTasks[detailId])) return [];
            return this.selectedTasks[detailId];
        },
        groupTasks(tasks) {
            const grouped = {};
            tasks.forEach(task => {
                if (!grouped[task.tipe]) {
                    grouped[task.tipe] = [];
                }
                grouped[task.tipe].push(task);
            });
            return grouped;
        },
        isGroupChecked(detailId, groupTasks) {
            if (!this.selectedTasks[detailId]) return false
            return groupTasks.every(task => this.selectedTasks[detailId].includes(task.id))
        },
        toggleGroup(detailId, groupTasks, event) {
            const checked = event.target.checked;
            if (!Array.isArray(this.selectedTasks[detailId])) {
                this.selectedTasks[detailId] = [];
            }

            const taskIds = groupTasks.map(task => task.id);
            if (checked) {
                // Tambahkan yang belum ada
                taskIds.forEach(id => {
                    if (!this.selectedTasks[detailId].includes(id)) {
                        this.selectedTasks[detailId].push(id);
                    }
                });
            } else {
                // Hapus semua dari grup
                this.selectedTasks[detailId] = this.selectedTasks[detailId].filter(
                    id => !taskIds.includes(id)
                );
            }
        },
        toggleTask(detailId, taskId, event) {
            if (!Array.isArray(this.selectedTasks[detailId])) {
                this.selectedTasks[detailId] = [];
            }

            const isChecked = event.target.checked;
            const index = this.selectedTasks[detailId].indexOf(taskId);

            if (isChecked && index === -1) {
                this.selectedTasks[detailId].push(taskId);
            } else if (!isChecked && index !== -1) {
                this.selectedTasks[detailId].splice(index, 1);
            }
        },
        toggleActivity(act) {
            const idx = this.selectedActivities.indexOf(act.id);

            if (idx > -1) {
                // Uncheck
                this.selectedActivities.splice(idx, 1);

                // Hapus detail dan task terkait
                if (this.selectedDetails[act.id]) {
                    this.selectedDetails[act.id].forEach(detailId => {
                        delete this.selectedTasks[detailId];
                        delete this.notes[detailId];
                    })
                    delete this.selectedDetails[act.id];
                }
            } else {
                // Check
                this.selectedActivities.push(act.id);
            }
        },
        toggleDetail(detail, activityId) {
            if (!Array.isArray(this.selectedDetails[activityId])) {
                this.selectedDetails[activityId] = [];
            }

            const idx = this.selectedDetails[activityId].indexOf(detail.id);

            if (idx === -1) {
                this.selectedDetails[activityId].push(detail.id);
            } else {
                this.selectedDetails[activityId].splice(idx, 1);
                if (this.selectedDetails[activityId].length === 0) {
                    delete this.selectedDetails[activityId];
                }
            }

            if (!this.selectedDetails[activityId] || !this.selectedDetails[activityId].includes(detail.id)) {
                delete this.selectedTasks[detail.id];
                delete this.notes[detail.id];
            }
        },

    }
}).mount('#app');
</script>