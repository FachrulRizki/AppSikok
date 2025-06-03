@extends('layouts.main')

@section('content')
<div class="container"><br>
    <h1>Tambah Aktivitas Keperawatan</h1>

    {{-- Menyisipkan form --}}
    @include('aktivitas_keperawatan.form', [
        'route' => route('aktivitas_keperawatan.store'),
        'method' => 'POST'
    ])
</div>
@endsection
