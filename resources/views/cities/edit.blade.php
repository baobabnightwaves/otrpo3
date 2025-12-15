@extends('web')
@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header bg-warning text-dark">
                    Редактирование города: {{ $city->name }}</h4>
                </div>
                <div class="card-body text-dark">
                    <form action="{{ route('cities.update', $city) }}" method="POST" enctype="multipart/form-data">
                        @include('cities.form')
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection