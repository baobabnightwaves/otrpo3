@extends('web')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-warning">
                    <h4 class="mb-0">Редактирование пользователя: {{ $user->name }}</h4>
                </div>
                <div class="card-body">
                    <!-- Форма редактирования -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection