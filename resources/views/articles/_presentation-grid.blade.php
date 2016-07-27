<a href="{{ route('article.show', $article->url) }}" class="article col-xs-12 col-sm-6 col-md-4">
    <img src="{{ asset('uploads/thumb_' . $article->logo_or_placeholder) }}" alt="{{ $article->title }}">
    <div class="content">
        <p class="infos">Environ {{ $article->length }} mn ({{ $article->words_count }} mots) ・ Polenta {{ $article->issue->title }}</p>
        <h3>{{ $article->title }}</h3>
        <p class="excerpt">{!! $article->excerpt !!}&#xA0;<span>→</span></p>
    </div>
</a>
