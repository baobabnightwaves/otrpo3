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
    document.addEventListener('DOMContentLoaded', function() {        
        var modalElement = document.getElementById('{{ $city->id }}');
        var modal = new bootstrap.Modal(modalElement, {
            backdrop: 'static',
            keyboard: false
        });
        
        modal.show();
        
        modalElement.addEventListener('hidden.bs.modal', function () {
            console.log('Модальное окно закрыто, возвращаемся на список городов');
            window.location.href = '{{ route("cities.index") }}';
        });
        
        var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
        var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
            return new bootstrap.Popover(popoverTriggerEl, {
                trigger: 'hover focus'
            });
        });
    });
</script>
@endpush
@endsection