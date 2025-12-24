<nav class="navbar navbar-expand-lg bg-dark text-white py-3">
    <div class="container d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <a href="{{ route('cities.index') }}" class="text-decoration-none text-white">
                <img src="{{ asset('/storage/portugal_flag.png') }}" alt="Флаг Португалии" height="60" class="me-3">
            </a>
            <a href="{{ route('cities.index') }}" class="text-decoration-none text-white">
                <h1 class="h3 mb-0">Главные города Португалии</h1>
            </a>
        </div>
        <div class="collapse navbar-collapse" id="navbarContent">
            <div class="navbar-nav ms-auto align-items-center">
                <a href="{{ route('users.index') }}" class="btn btn-light rounded-0 me-2 mb-2 mb-lg-0">Список пользователей</a>
                @auth
                    <a href="{{ route('cities.create') }}" class="btn btn-success rounded-0 me-2 mb-2 mb-lg-0">Добавить город</a>
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
                            <a class="dropdown-item text-dark" href="{{ route('users.cities', ['user' => Auth::user()->name]) }}">
                                Мои города
                            </a>
                            <a class="dropdown-item text-dark" href="{{ route('users.feed', ['user' => Auth::user()->name]) }}">
                                Лента друзей
                            </a>
                            <div class="dropdown-divider"></div>
                            <form method="POST" action="{{ route('logout') }}" class="dropdown-item px-3">
                                @csrf
                                <button type="submit" class="btn btn-link text-dark w-100 text-start p-0">
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