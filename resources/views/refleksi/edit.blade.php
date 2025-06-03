@extends('layouts.main')

@section('content')
<div class="container">
    <h1>Edit Aktivitas Refleksi</h1>

    @include('refleksi.form', [
        'route' => route('refleksi.update', $refleksi->id),
        'method' => 'PUT',
        'refleksi' => $refleksi
    ])
</div>
@endsection
