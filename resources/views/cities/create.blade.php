@extends('web')
@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card text-dark rounded-0">
                <div class="card-header bg-primary text-white rounded-0">
                    <h4>Создание города</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('cities.store') }}" method="POST" enctype="multipart/form-data">
                        @include('cities.form')
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection