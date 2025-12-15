@extends('web')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-0">
                <div class="card-header bg-dark text-white py-4 rounded-0">
                    <div class="text-center">
                        <h3 class="mb-2">
                            Регистрация аккаунта
                        </h3>
                    </div>
                </div>
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <div class="mb-3">
                            <img src="{{ asset('/storage/portugal_flag.png') }}" alt="Флаг Португалии" height="80">
                        </div>
                        <h4 class="text-dark">Создайте свой аккаунт</h4>
                    </div>
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    <form method="POST" action="{{ route('register') }}" id="registerForm">
                        @csrf
                        <div class="mb-4">
                            <label for="name" class="form-label fw-bold text-dark">
                                Ваше имя
                            </label>
                            <div class="input-group">
                                <input type="text" 
                                       class="form-control py-3 text-dark rounded-0 @error('name') is-invalid @enderror" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name') }}" 
                                       required 
                                       autofocus>
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="email" class="form-label fw-bold text-dark">
                                Email адрес
                            </label>
                            <div class="input-group">
                                <input type="email" 
                                       class="form-control py-3 text-dark rounded-0 @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email') }}" 
                                       required>
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="password" class="form-label fw-bold text-dark">
                                    Пароль
                                </label>
                                <div class="input-group">
                                    <input type="password" 
                                           class="form-control py-3 text-dark rounded-0 border-end-0 @error('password') is-invalid @enderror" 
                                           id="password" 
                                           name="password" 
                                           required>
                                    <div class="input-group-append">
                                        <button type="button" 
                                                class="btn btn-outline-secondary rounded-0 toggle-password" 
                                                data-target="password"
                                                style="height: 100%;">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                    @error('password')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label fw-bold text-dark">
                                    Подтверждение пароля
                                </label>
                                <div class="input-group">
                                    <input type="password" 
                                           class="form-control py-3 text-dark rounded-0" 
                                           id="password_confirmation" 
                                           name="password_confirmation" 
                                           required>
                                    <div class="input-group-append">
                                        <button type="button" 
                                                class="btn btn-outline-secondary rounded-0 toggle-password" 
                                                data-target="password_confirmation"
                                                style="height: 100%;">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-grid gap-2 mb-4">
                            <button type="submit" class="btn btn-primary btn-lg py-3 rounded-0">
                                Зарегистрироваться
                            </button>
                        </div>
                    </form>
                    <div class="my-4 position-relative">
                        <hr>
                        <span class="position-absolute top-50 start-50 translate-middle bg-white px-3 text-dark">
                            или
                        </span>
                    </div>
                    <div class="text-center">
                        <a href="{{ route('login') }}" class="btn btn-outline-dark btn-lg w-100 py-3 rounded-0">
                            Войти в существующий аккаунт
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

<script>
document.addEventListener('DOMContentLoaded', function() {
    const toggleButtons = document.querySelectorAll('.toggle-password');    
    let isPasswordVisible = false;
    
    function updateAllPasswordFields() {
        const newType = isPasswordVisible ? 'password' : 'text';
        
        const passwordFields = ['password', 'password_confirmation'];
        passwordFields.forEach(fieldId => {
            const field = document.getElementById(fieldId);
            if (field) {
                field.setAttribute('type', newType);
            }
        });
        
        toggleButtons.forEach(button => {
            const icon = button.querySelector('i');
            if (icon) {
                if (isPasswordVisible) {
                    icon.classList.remove('bi-eye-slash');
                    icon.classList.add('bi-eye');
                } else {
                    icon.classList.remove('bi-eye');
                    icon.classList.add('bi-eye-slash');
                }
            }
        });
    }
    toggleButtons.forEach(button => {
        button.addEventListener('click', function() {
            isPasswordVisible = !isPasswordVisible;
            updateAllPasswordFields();
        });
    });    
    updateAllPasswordFields();
});
</script>
@endsection