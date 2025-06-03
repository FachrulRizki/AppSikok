@extends('layouts.main')

@section('content')
<div class="container">
    <h1>Edit Aktivitas Supervisi</h1>

    @include('spv_kepru.form', [
        'route' => route('spv_kepru.update', $spv_kepru->id),
        'method' => 'PUT',
        'spv_kepru' => $spv_kepru
    ])
</div>
@endsection
