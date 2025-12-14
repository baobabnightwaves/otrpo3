@extends('web')

@section('content')
<div class="container my-5 rounded-0">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($cities->isEmpty())
        <div class="alert alert-info">
            <i class="fas fa-info-circle me-2"></i>Города не найдены. 
            <a href="{{ route('cities.create') }}" class="alert-link">Добавьте первый город</a>.
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-striped table-hover border">
                <thead class="table table-primary">
                    <tr>
                        <th>ID</th>
                        <th>Название</th>
                        <th>Дата создания</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cities as $city)
                    <tr>
                        <td>{{ $city->id }}</td>
                        <td>{{ $city->name }}</td>
                        <td>{{ $city->created_at->format('d.m.Y H:i') }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('cities.show', $city) }}" class="btn btn-info rounded-0 py-2 px-3" title="Просмотр">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('cities.edit', $city) }}" class="btn btn-warning rounded-0 py-2 px-3" title="Редактировать">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('cities.destroy', $city) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm({{ json_encode('Вы уверены, что хотите удалить город "' . $city->name . '"?') }})">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger rounded-0 py-2 px-3" title="Удалить">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
    <div class="mt-4">
        <a href="{{ route('home') }}" class="btn btn-light rounded-0 btn-outline-dark">
            На главную
        </a>
    </div>
</div>
@endsection