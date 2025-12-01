@extends('web')

@section('content')
<div class="container my-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Главная</a></li>
            <li class="breadcrumb-item"><a href="{{ route('cities.index') }}">Города</a></li>
            <li class="breadcrumb-item"><a href="{{ route('cities.show', $city) }}">{{ $city->name }}</a></li>
            <li class="breadcrumb-item active">Редактировать</li>
        </ol>
    </nav>

    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <h4 class="mb-0"><i class="fas fa-edit me-2"></i>Редактировать город: {{ $city->name }}</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('cities.update', $city) }}" method="POST" enctype="multipart/form-data">
                        @include('cities.form')
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection