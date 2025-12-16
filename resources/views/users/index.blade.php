@extends('web')

@section('content')
<div class="container my-5">
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

    @if($users->isEmpty())
        <div class="alert alert-info">
            <i class="fas fa-info-circle me-2"></i>Пользователи не найдены
        </div>
    @else
        <div class="card shadow-sm rounded-0">
            <div class="card-body p-0 rounded-0">
                <div class="table-responsive rounded-0">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Имя</th>
                                <th>Email</th>
                                <th>Статус</th>
                                <th>Дата регистрации</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>
                                    {{ $user->id }}
                                </td>
                                <td>
                                    <a href="{{ route('users.cities', ['user' => $user->name]) }}">
                                        {{ $user->name }}
                                    </a>
                                    @if($user->id === auth()->id())
                                        <span class="badge bg-info ms-2 rounded-0">Вы</span>
                                    @endif
                                </td>
                                <td>
                                    {{ $user->email }}
                                </td>
                                <td>
                                    @if($user->is_admin)
                                        <span class="badge bg-danger rounded-0">Администратор</span>
                                    @else
                                        <span class="badge bg-secondary rounded-0">Пользователь</span>
                                    @endif
                                </td>
                                <td>
                                    {{ $user->created_at->format('d.m.Y H:i') }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        
        
    @endif
    <div class="mt-4">
        <a href="{{ route('dashboard') }}" class="btn btn-light btn-outline-dark rounded-0">
            Назад
        </a>
    </div>
</div>
@endsection