<footer class="container-fluid main-footer">

    <h2 class="slogan">{{ $polenta }}</h2>
    <h2 class="slogan">{{ $slogan }}</h2>

    <nav class="nav nav-pills">
        @foreach ($footerPages as $url => $title)
            <a href="{!! route('page.show', $url) !!}">{{ $title }}</a> •
        @endforeach
        Réalisation&#xA0;: <a href="http://www.glutendesign.com/">Gluten Design</a>
    </nav>

    <nav class="nav nav-pills">
        <a href="{{ url('/article-feed') }}">@icon('rss') RSS</a> •

        <!-- Authentication Links -->
        @if (auth()->check())
            <a href="{{ route('admin.index') }}">@icon('gears') Admin</a> •
            <a href="#">@icon('user') {{ Auth::user()->name }}</a> •
            <a href="{{ url('/logout') }}">@icon('sign-out') Déconnexion</a>
        @else
            <a href="{{ url('/login') }}">@icon('sign-in') Connexion</a>
        @endif
    </nav>
</footer>
