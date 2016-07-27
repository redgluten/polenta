<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ $polenta }}. {{ $slogan }}">

    @include('laravel-feed::feed-links')

    <title>Polenta | @yield('title')</title>

    <!-- Alegreya fonts -->
    <link href="https://fonts.googleapis.com/css?family=Alegreya+Sans:400,400i,700|Alegreya:400,400i,700" rel="stylesheet">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Per-page styles -->
    @stack('styles')
</head>
<body id="public-layout" class="public-layout">

    <!-- Main navigation -->
    @include('partials/_nav')

    <!-- Messages -->
    <div class="messages">
        @include('partials._messages')
        @stack('messages')
    </div>

    <!-- Main content -->
    @yield('content')

    <!-- Footer -->
    @include('partials/_footer')
    @include('partials/_up-button')

    <!-- JavaScripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    {{-- Per-page scripts --}}
    @stack('scripts')
</body>
</html>
