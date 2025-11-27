@extends('web')

@section('content')
<div class="container mb-5">
    <div class="row g-4">
        @foreach($cities as $city)
            @include('partials.card', ['city' => $city])
        @endforeach
    </div>
</div>
@foreach($cities as $city)
    @include('partials.modal', ['city' => $city])
@endforeach
@endsection