@extends('web')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card shadow rounded-0">
                <div class="card-header bg-dark text-white rounded-0">
                    <h4 class="mb-0">
                        Панель управления
                    </h4>
                </div>
                <div class="card-body">
                    <div class="mb-4 text-dark">
                        <h5>Добро пожаловать, {{ Auth::user()->name }}!</h5>
                        <p class="text-dark">{{ Auth::user()->email }}</p>
                        @if(Auth::user()->is_admin)
                            <span class="badge bg-danger p-2 rounded-0">
                                Администратор
                            </span>
                        @endif
                    </div>
                    <div class="border-top pt-4">
                        <div class="d-flex flex-wrap gap-2">
                            <a href="{{ route('cities.create') }}" class="btn btn-primary rounded-0">
                                Добавить город
                            </a>
                            <a href="{{ route('cities.index') }}" class="btn btn-outline-dark rounded-0">
                                Все города
                            </a>
                            
                            @if(Auth::user()->is_admin)
                                <a href="{{ route('admin.cities') }}" class="btn btn-outline-danger rounded-0">
                                    Управление городами
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection