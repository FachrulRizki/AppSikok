@forelse ($comments as $item)
    <div class="p-4 rounded-4 text-bg-light mb-3">
        <div class="d-flex align-items-center gap-3">
            <img src="https://ui-avatars.com/api/?name={{ $item->user->name }}&background=random" alt="modernize-img" class="rounded-circle"
                width="33" height="33">
            <h6 class="mb-0 fs-4">{{ $item->user->name }}</h6>
        </div>
        <p class="my-3">
            {{ $item->comment }}
        </p>
        <small class="mb-0 text-muted">{{ $item->created_at->diffForHumans() }}</small>
    </div>
@empty
    <div class="alert alert-primary border-0 text-primary mb-0 text-center">Belum ada komentar</div>
@endforelse