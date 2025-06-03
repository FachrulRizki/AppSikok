@extends('layouts.main')

@section('content')
<div class="container"><br>
    <h1>Tambah Aktivitas Supervisi</h1>

    {{-- Menyisipkan form --}}
    @include('spv_kepru.form', [
        'route' => route('spv_kepru.store'),
        'method' => 'POST'
    ])
</div>
@endsection
