<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Города Португалии</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=B612:wght@400;700&family=Rubik:wght@400;700&display=swap" rel="stylesheet">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    @stack('styles')
</head>

<body>
    @include('partials.header')
    
    <main>
        @yield('content')
    </main>
    
    @include('partials.footer')
    @include('partials.toast')
    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>