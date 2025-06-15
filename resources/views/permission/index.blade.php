@extends('layouts.main')

@section('title', 'Permissions')

@section('content')
    <div class="container-fluid">
        <div class="card bg-primary-subtle shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-8">Permissions</h4>
                        <nav aria-label="breadcrumb" style="--bs-breadcrumb-divider: '/'">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a class="text-muted text-decoration-none" href="{{ route('dashboard') }}">Beranda</a>
                                </li>
                                <li class="breadcrumb-item" aria-current="page">Permissions</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-3">
                        <div class="text-center mb-n5">
                            <img src="{{ asset('assets/images/backgrounds/welcome-doctors.svg') }}" alt="modernize-img" class="img-fluid mb-n4" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <button data-bs-toggle="modal" data-bs-target="#permissionModal" data-mode="create" class="btn btn-primary mb-4">Tambah Permission</button>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table w-100 text-nowrap">
                        <thead>
                            <tr>
                                <th>Nama Permission</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $item)
                                <tr>
                                    <td>{{ $item->name }}</td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2">
                                            <button
                                                data-bs-toggle="modal"
                                                data-bs-target="#permissionModal"
                                                data-mode="edit"
                                                data-id="{{ $item->id }}"
                                                data-name="{{ $item->name }}"
                                                class="btn btn-warning btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                                <i class="ti ti-edit"></i>
                                            </button>
                                            <form action="{{ route('permissions.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin hapus?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus">
                                                    <i class="ti ti-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center" colspan="2">Tidak ada data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($data->hasPages())
                    <div class="mt-2 d-flex justify-content-center">
                        {{ $data->links('vendor.pagination.bootstrap-4') }}
                    </div>
                @endif
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="permissionModal" tabindex="-1" aria-labelledby="permissionModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form id="permissionForm" method="POST">
                    @csrf
                    <input type="hidden" name="_method" id="formMethod" value="POST">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="permissionModalLabel">Tambah Permission</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                        </div>
                        <div class="modal-body">
                            <div>
                                <label for="permissionName" class="form-label">Nama Permission</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="permissionName" required>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn bg-primary-subtle text-primary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary" id="submitBtn">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var permissionModal = document.getElementById('permissionModal');
    permissionModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var mode = button.getAttribute('data-mode');
        var modalTitle = permissionModal.querySelector('.modal-title');
        var form = permissionModal.querySelector('form');
        var nameInput = permissionModal.querySelector('#permissionName');
        var methodInput = permissionModal.querySelector('#formMethod');

        if (mode === 'create') {
            modalTitle.textContent = 'Tambah Permission';
            nameInput.value = '';
            form.setAttribute('action', '{{ route('permissions.store') }}');
            methodInput.value = 'POST';
        } else if (mode === 'edit') {
            var id = button.getAttribute('data-id');
            var name = button.getAttribute('data-name');
            modalTitle.textContent = 'Edit Permission';
            nameInput.value = name;
            form.setAttribute('action', '/permissions/' + id);
            methodInput.value = 'PUT';
        }
    });
});
</script>
@endpush