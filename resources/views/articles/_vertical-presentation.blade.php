<div class="article-vertical-presentation col-md-3">
    <div class="article-vp-logo">
        <a href="{{ route('article.show', $article->url) }}">
            <img src="{{ asset('uploads/thumb_' . $article->logo_or_placeholder) }}" alt="{{ $article->title }}" class="small-thumb">
        </a>
    </div>
    <div class="article-vp-text">
        <h3 class="article-vp-heading">
            <a href="{{ route('article.show', $article->id) }}">{{ $article->title }}</a>
        </h3>

        <small class="small-article-infos">Publié le {{ $article->created_at_as_string }}</small>

        <p>{{ $article->excerpt }}</p>
    </div>
</div>
