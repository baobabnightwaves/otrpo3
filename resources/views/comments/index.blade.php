@extends('web')

@section('content')
<div class="container my-5">
    <h2 class="h3 fw-bold mb-4">Комментарии к городу: {{ $city->name }}</h2>
    
    <div class="card shadow-sm">
        <div class="card-body">
            
            <div class="mb-4 d-flex justify-content-between align-items-center">
                <a href="{{ route('cities.index') }}" class="btn btn-outline-dark">
                    Назад к списку городов
                </a>
                @auth
                    <a href="{{ route('comments.create', $city) }}" 
                       class="btn btn-primary">
                        Добавить комментарий
                    </a>
                @endauth
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <h3 class="h5 mb-4 text-dark">Всего комментариев: {{ $comments->count() }}</h3>

            @if($comments->count() > 0)
                <div class="mb-3">
                    @foreach($comments as $comment)
                        <div class="card mb-3 {{ Auth::check() && Auth::user()->friendsWith($comment->user) ? 'border-warning bg-warning bg-opacity-10' : '' }}">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <strong class="text-dark">{{ $comment->user->name }}</strong>
                                        @if(Auth::check() && Auth::user()->friendsWith($comment->user))
                                            <span class="badge bg-warning text-dark ms-2">Друг</span>
                                        @endif
                                    </div>
                                    <small class="text-dark">{{ $comment->created_at->format('d.m.Y H:i') }}</small>
                                </div>
                                <p class="card-text mb-0 text-dark">{{ $comment->content }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>Комментариев пока нет. Будьте первым!
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
