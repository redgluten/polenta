<a href="{{ route('article.show', $article->url) }}" class="article" style="border-color: {{ $article->logo_color }}">
    <div class="content">
        <h3>{{ $article->title }}</h3>
        <p class="excerpt">{!! $article->excerpt !!}</p>
        <p class="infos">Environ {{ $article->length }} mn ({{ $article->words_count }} mots) ・ Polenta {{ $article->issue->title }}</p>
    </div>
    <img src="{{ asset('uploads/thumb_' . $article->logo_or_placeholder) }}" alt="{{ $article->title }}">
</a>
