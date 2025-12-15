@extends('web')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card rounded-0">
                <div class="bg-dark text-white py-4 rounded-0">
                    <div class="text-center">
                        <h3 class="mb-2">Вход в аккаунт</h3>
                    </div>
                </div>

                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <div class="mb-3">
                            <img src="{{ asset('/storage/portugal_flag.png') }}" alt="Флаг Португалии" height="80">
                        </div>
                        <h4 class="text-dark">Города Португалии</h4>
                    </div>
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if (session('status'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('status') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" id="loginForm">
                        @csrf
                        <div class="mb-4">
                            <label for="email" class="form-label fw-bold text-dark">
                                Email адрес
                            </label>
                            <div class="input-group">
                                <input type="email" 
                                       class="form-control py-3 rounded-0 text-dark @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email') }}" 
                                       required 
                                       autofocus>
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="password" class="form-label fw-bold text-dark">
                                Пароль
                            </label>
                            <div class="input-group">
                                <input type="password" 
                                       class="form-control rounded-0 text-dark py-3 border-end-0 @error('password') is-invalid @enderror" 
                                       id="password" 
                                       name="password" 
                                       required 
                                       autocomplete="current-password">
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
                        <div class="d-grid gap-2 mb-4">
                            <button type="submit" class="btn btn-primary btn-lg py-3 rounded-0">
                                Войти
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
                        <a href="{{ route('register') }}" class="btn btn-outline-dark btn-lg w-100 py-3 rounded-0">
                            Зарегистрироваться
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
    toggleButtons.forEach(button => {
        button.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const passwordInput = document.getElementById(targetId);
            
            if (passwordInput) {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                const icon = this.querySelector('i');
                if (type === 'text') {
                    icon.classList.remove('bi-eye');
                    icon.classList.add('bi-eye-slash');
                } else {
                    icon.classList.remove('bi-eye-slash');
                    icon.classList.add('bi-eye');
                }
            }
        });
    });
});
</script>
@endsection