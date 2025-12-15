@extends('web')

@section('content')
<header class="container text-center my-5">
    <h1 class="display-6 fw-bold text-dark text-start">Города Португалии</h1>
</header>

<div class="container mb-5">
    <div class="row g-4">
        @foreach($cities as $c)
            @include('partials.card', ['city' => $c])
        @endforeach
    </div>
</div>

@include('cities.modal', ['city' => $city])

@endsection