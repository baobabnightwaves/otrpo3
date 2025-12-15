@extends('web')

@section('content')
<header class="container text-center my-5">
    <h1 class="display-6 fw-bold text-dark text-start">Города Португалии</h1>
</header>

<div class="container mb-5">
    <div class="row g-4">
        @foreach($cities as $c)
            @include('partials.card', ['city' => $c])
        @endforeach
    </div>
</div>

@include('cities.modal', ['city' => $city])

@push('scripts')
<script>
    console.log('=== МОДАЛЬНОЕ ОКНО DEBUG ===');
    console.log('City ID:', '{{ $city->id }}');
    console.log('Bootstrap доступен:', typeof bootstrap !== 'undefined');
    console.log('Bootstrap.Modal доступен:', typeof bootstrap.Modal !== 'undefined');
    
    // Ищем модальное окно
    const modalElement = document.getElementById('{{ $city->id }}');
    console.log('Элемент модального окна найден:', !!modalElement);
    
    if (modalElement) {
        console.log('Создаем модальное окно...');
        
        // Создаем экземпляр модального окна
        const modal = new bootstrap.Modal(modalElement);
        
        // Показываем модальное окно
        modal.show();
        console.log('Модальное окно должно быть открыто');
        
        // При закрытии возвращаемся на список
        modalElement.addEventListener('hidden.bs.modal', function () {
            window.location.href = '{{ route("cities.index") }}';
        });
        
        // Инициализация popover
        const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]');
        popoverTriggerList.forEach(popoverTriggerEl => {
            new bootstrap.Popover(popoverTriggerEl);
        });
        
    } else {
        console.error('Элемент модального окна не найден!');
        console.log('Все элементы с классом modal:', document.querySelectorAll('.modal'));
    }
</script>
@endpush
@endsection