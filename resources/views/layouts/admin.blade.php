<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title') | Polenta</title>

    <!-- Alegreya font -->
    <link href='https://fonts.googleapis.com/css?family=Alegreya:400,700,400italic|Alegreya+Sans:400,400italic,500' rel='stylesheet' type='text/css'>

    <!-- Custom styles -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/admin.css') }}">
</head>
<body id="admin-layout" class="admin-layout">

    <!-- Main navigation -->
    @include('admin.partials._nav')

    {{-- Messages --}}
    @include('partials._messages')

    <!-- Breadcrumb -->
    @hasSection('breadcrumb')
        <div class="breadcrumb-container">
            <div class="container">
                <ol class="breadcrumb">
                    @yield('breadcrumb')
                </ol>
            </div>
        </div>
    @else
        <!-- No breacrumb -->
    @endif

    <!-- Content -->
    @yield('content')

    <!-- Main footer -->
    @include('admin.partials._footer')
    @include('partials/_up-button')

    <!-- Javascript libs -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/admin.js') }}"></script>

    {{-- Per-page scripts --}}
    @stack('scripts')
</body>
</html>
