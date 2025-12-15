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
                                <th>Городов</th>
                                <th>Статус</th>
                                <th>Дата регистрации</th>
                                <th>Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>
                                    {{ $user->name }}
                                    @if($user->id === auth()->id())
                                        <span class="badge bg-info ms-2 rounded-0">Вы</span>
                                    @endif
                                </td>
                                <td>
                                    {{ $user->email }}
                                </td>
                                <td>
                                    <span class="badge bg-secondary rounded-0">{{ $user->cities_count }}</span>
                                    @if($user->cities_count > 0)
                                        <a href="{{ route('admin.users.cities', $user) }}" 
                                           class="btn btn-sm btn-outline-info ms-2 rounded-0" 
                                           title="Показать города">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    @endif
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
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.users.show', $user) }}" 
                                           class="btn btn-primary rounded-0 px-3 py-2"  
                                           title="Просмотр">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.users.edit', $user) }}" 
                                           class="btn btn-warning rounded-0 px-3 py-2" 
                                           title="Редактировать">
                                            <i class="fas fa-edit"></i>
                                        </a>                                        
                                        @if($user->id !== auth()->id())
                                            <form action="{{ route('admin.users.toggle-admin', $user) }}" 
                                                  method="POST" 
                                                  class="d-inline">
                                                @csrf
                                                <button type="submit" 
                                                        class="btn rounded-0 px-3 py-2 btn-{{ $user->is_admin ? 'secondary' : 'success' }}" 
                                                        title="{{ $user->is_admin ? 'Убрать админа' : 'Сделать админом' }}">
                                                    <i class="fas fa-{{ $user->is_admin ? 'user' : 'user-shield' }}"></i>
                                                </button>
                                            </form>
                                        @endif
                                        @if($user->id !== auth()->id())
                                            <form action="{{ route('admin.users.destroy', $user) }}" 
                                                  method="POST" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('Вы уверены, что хотите удалить пользователя {{ $user->name }}? Все его города также будут удалены.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger rounded-0 px-3 py-2" title="Удалить">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
            @if($users->hasPages())
            <div class="card-footer">
                <div class="d-flex justify-content-center">
                    {{ $users->links() }}
                </div>
            </div>
            @endif
        </div>
        
        
    @endif
    <div class="mt-4">
        <a href="{{ route('dashboard') }}" class="btn btn-light btn-outline-dark rounded-0">
            Назад
        </a>
    </div>
</div>
@endsection