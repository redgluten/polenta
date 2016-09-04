<nav class="navbar navbar-inverse navbar-fixed-top">
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
            <a class="navbar-brand" href="{{ url('/') }}">
                Polenta !
            </a>
        </div>

        <div class="navbar-collapse collapse" id="app-navbar-collapse">
            <ul class="nav navbar-nav">
                <li>
                    <a href="{{ route('admin.index') }}">@icon('dashboard') Tableau de bord</a>
                </li>
            </ul>

            <ul class="nav navbar navbar-nav navbar-right">
                @include('admin/_menus-admin')
            </ul>
        </div>
    </div>
</nav>
