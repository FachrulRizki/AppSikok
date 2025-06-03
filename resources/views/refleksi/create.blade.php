@extends('layouts.main')

@section('content')
<div class="container"><br>
    <h1>Tambah Aktivitas Refleksi</h1>

    {{-- Menyisipkan form --}}
    @include('refleksi.form', [
        'route' => route('refleksi.store'),
        'method' => 'POST'
    ])
</div>
@endsection
