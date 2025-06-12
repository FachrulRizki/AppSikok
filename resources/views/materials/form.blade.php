<form action="{{ $route }}" method="POST" onsubmit="return syncQuillContent()" enctype="multipart/form-data">
    @csrf
    @if ($method === 'PUT')
        @method('PUT')
    @endif
    <div class="card">
        <div class="card-body">
            <div class="mb-3">
                <label class="form-label">Judul Materi</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title', $material->title ?? '') }}">
                @error('title')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tipe Materi</label>
                    <select name="type" class="form-select @error('type') is-invalid @enderror" id="type-select" {{ $method === 'PUT' ? 'disabled' : '' }}>
                        <option value="youtube" {{ old('type', $material->type ?? '') == 'youtube' ? 'selected' : '' }}>Video YouTube</option>
                        <option value="pdf" {{ old('type', $material->type ?? '') == 'pdf' ? 'selected' : '' }}>PDF</option>
                    </select>
                    @error('type')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Link Youtube/File PDF</label>
                    <div class="input-group">
                        <input type="text" id="source-input" class="form-control @error('source') is-invalid @enderror" name="source" value="{{ $material->source ?? '' }}">
                        @if ($method === 'PUT')
                            <a href="/storage/{{ $material->source }}" target="_blank" class="btn btn-primary">
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-file-type-pdf"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M5 12v-7a2 2 0 0 1 2 -2h7l5 5v4" /><path d="M5 18h1.5a1.5 1.5 0 0 0 0 -3h-1.5v6" /><path d="M17 18h2" /><path d="M20 15h-3v6" /><path d="M11 15v6h1a2 2 0 0 0 2 -2v-2a2 2 0 0 0 -2 -2h-1z" /></svg>
                            </a>
                        @endif
                    </div>
                    @error('source')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Isi Materi</label>
                <div id="quill-editor">{{ old('content', isset($material) && $material->content ?? '' ) }}</div>
                <input type="hidden" name="content" id="quill-content">
            </div>
            <div class="d-flex gap-3 mt-4">
                <button class="btn btn-primary" type="submit">Simpan</button>
                <a href="{{ route('materi.index') }}" class="btn bg-primary-subtle text-primary">Kembali</a>
            </div>
        </div>
    </div>
</form>
