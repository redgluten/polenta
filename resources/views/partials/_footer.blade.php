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
        <a href="{{ url('/article-feed') }}"><i class="fa fa-btn fa-rss"></i> RSS</a> •

        <!-- Authentication Links -->
        @if (auth()->check())
            <a href="{{ route('admin.index') }}"><i class="fa fa-gears"></i> Admin</a> •
            <a href="#"><i class="fa fa-user"></i> {{ Auth::user()->name }}</a> •
            <a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i> Déconnexion</a>
        @else
            <a href="{{ url('/login') }}"><i class="fa fa-sign-in"></i> Connexion</a>
        @endif
    </nav>
</footer>
