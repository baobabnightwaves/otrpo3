@extends('web')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <!-- Карточка восстановления пароля -->
            <div class="card shadow-lg border-0">
                <!-- Заголовок карточки -->
                <div class="card-header bg-dark text-white py-4">
                    <div class="text-center">
                        <h3 class="mb-2">
                            <i class="fas fa-key me-2"></i>Восстановление пароля
                        </h3>
                        <p class="mb-0 text-white-50">Введите email для восстановления доступа</p>
                    </div>
                </div>

                <div class="card-body p-5">
                    <!-- Иконка -->
                    <div class="text-center mb-4">
                        <div class="mb-3">
                            <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center" 
                                 style="width: 100px; height: 100px;">
                                <i class="fas fa-lock fa-3x text-dark"></i>
                            </div>
                        </div>
                        <h4 class="text-dark">Забыли пароль?</h4>
                        <p class="text-muted">Не беспокойтесь! Мы отправим вам ссылку для сброса пароля</p>
                    </div>

                    <!-- Форма восстановления -->
                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <!-- Email -->
                        <div class="mb-4">
                            <label for="email" class="form-label fw-bold">
                                <i class="fas fa-envelope me-2"></i>Ваш Email
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-at text-muted"></i>
                                </span>
                                <input type="email" 
                                       class="form-control py-3 @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email') }}" 
                                       required 
                                       autofocus
                                       placeholder="Введите email вашего аккаунта">
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Сообщение об отправке -->
                        @if (session('status'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle me-2"></i>
                                {{ session('status') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <!-- Кнопка отправки -->
                        <div class="d-grid gap-2 mb-4">
                            <button type="submit" class="btn btn-primary btn-lg py-3">
                                <i class="fas fa-paper-plane me-2"></i>Отправить ссылку
                            </button>
                        </div>
                    </form>

                    <!-- Ссылки для возврата -->
                    <div class="text-center">
                        <a href="{{ route('login') }}" class="text-decoration-none text-muted me-3">
                            <i class="fas fa-arrow-left me-1"></i>Вернуться к входу
                        </a>
                        <a href="{{ route('register') }}" class="text-decoration-none text-primary">
                            <i class="fas fa-user-plus me-1"></i>Создать аккаунт
                        </a>
                    </div>
                </div>

                <!-- Футер карточки -->
                <div class="card-footer bg-light py-3 text-center">
                    <small class="text-muted">
                        <i class="fas fa-info-circle me-1"></i>
                        Ссылка будет действительна в течение 60 минут
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection