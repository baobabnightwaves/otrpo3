<nav class="navbar navbar-expand-lg bg-dark text-white py-3">
    <div class="container d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <a href="{{ route('home') }}" class="text-decoration-none text-white">
                <img src="{{ asset('/storage/portugal_flag.png') }}" alt="Флаг Португалии" height="60" class="me-3">
            </a>
            <a href="{{ route('home') }}" class="text-decoration-none text-white">
                <h1 class="h3 mb-0">Главные города Португалии</h1>
            </a>
        </div>
        <div>
            <a href="{{ route('cities.index') }}" class="btn btn-light me-2">
                Управление городами
            </a>
            <a href="{{ route('cities.create') }}" class="btn btn-primary">
                Добавить город
            </a>
        </div>
    </div>
</nav>