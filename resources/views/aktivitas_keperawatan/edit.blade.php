@extends('layouts.main')

@section('content')
<div class="container">
    <h1>Edit Aktivitas Keperawatan</h1>

    @include('aktivitas_keperawatan.form', [
        'route' => route('aktivitas_keperawatan.update', $aktivitas_keperawatan->id),
        'method' => 'PUT',
        'aktivitas_keperawatan' => $aktivitas_keperawatan
    ])
</div>
@endsection
