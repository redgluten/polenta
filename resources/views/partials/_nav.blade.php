<nav class="navbar navbar-fixed-top navbar-default">
    <div class="container">
        <div class="navbar-header">

            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                <span class="sr-only">Afficher le menu</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!-- Branding Image -->
            <a class="navbar-brand" href="{{ url('/') }}">Polenta !</a>
        </div>

        <div id="app-navbar-collapse" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li><a href="{{ route('issue.index') }}">Archives</a></li>
                <li><a href="{{ route('find') }}">Où nous trouver</a></li>

                @foreach ($menuPages as $url => $title)
                    <li><a href="{{ route('page.show', $url)}}">{{ $title }}</a></li>
                @endforeach
            </ul>

            @include('partials._search-form', ['route' => 'search', 'class' => 'navbar-form navbar-right'])
        </div>
    </div>
</nav>
