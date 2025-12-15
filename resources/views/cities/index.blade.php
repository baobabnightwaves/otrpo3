@extends('web')
@section('content')
<header class="container text-center my-5">
    <h1 class="display-6 fw-bold text-dark text-start">Города Португалии</h1>
</header>
<div class="container mb-5">
    <div class="row g-4">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @foreach($cities as $city)
            @include('partials.card', ['city' => $city])
        @endforeach
    </div>
</div>
@endsection