<nav class="navbar navbar-expand-lg bg-dark text-white py-3">
    <div class="container">
        <div class="d-flex align-items-center">
            <a href="{{ route('home') }}" class="text-decoration-none text-white d-flex align-items-center">
                <img src="{{ asset('/storage/portugal_flag.png') }}" alt="Флаг Португалии" height="60" class="me-3">
                <h1 class="h3 mb-0 d-none d-md-block">Главные города Португалии</h1>
                <h1 class="h4 mb-0 d-md-none">Города Португалии</h1>
            </a>
        </div>

        <div class="collapse navbar-collapse" id="navbarContent">
            <div class="navbar-nav ms-auto align-items-center">
                <a href="{{ route('cities.index') }}" class="btn btn-light rounded-0 me-2 mb-2 mb-lg-0">
                    Управление городами
                </a>

                @auth
                    <a href="{{ route('cities.create') }}" class="btn btn-primary rounded-0 me-2 mb-2 mb-lg-0">Добавить город</a>
                @endauth

                <div class="nav-item dropdown rounded-0">
                    @auth
                        <a class="nav-link dropdown-toggle text-white d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                            <div class="me-2 text-end d-none d-md-block">
                                <div class="fw-bold">{{ Auth::user()->name }}</div>
                            </div>
                        </a>
                        
                        <div class="dropdown-menu dropdown-menu-end text-dark rounded-0">
                            <div class="dropdown-header text-dark">
                                <div class="fw-bold">{{ Auth::user()->name }}</div>
                                <p>{{ Auth::user()->email }}</p>
                            </div>
                            
                            <a class="dropdown-item text-dark" href="{{ route('dashboard') }}">
                                Панель управления
                            </a>
                            
                            @if(Auth::user()->is_admin)
                                <a class="dropdown-item text-dark" href="{{ route('admin.cities') }}">
                                    Все города
                                </a>
                            @endif                            
                            <form method="POST" action="{{ route('logout') }}" class="dropdown-item">
                                @csrf
                                <button type="submit" class="btn btn-link text-dark w-100 text-start">
                                    Выйти
                                </button>
                            </form>
                        </div>
                    @else
                        <a class="nav-link dropdown-toggle text-white d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                            <div class="me-2 text-end d-none d-md-block">
                                <div class="fw-bold">Гость</div>
                            </div>
                        </a>
                        
                        <div class="dropdown-menu dropdown-menu-end rounded-0">
                            <a class="dropdown-item text-dark" href="{{ route('login') }}">
                                <i class="me-2"></i>Войти
                            </a>
                            <a class="dropdown-item text-dark" href="{{ route('register') }}">
                                <i class="me-2"></i>Регистрация
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</nav>