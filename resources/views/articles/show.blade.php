@extends('layouts.public')

@section('title')
{{ $article->title }}
@stop

@section('content')

@unless (empty($article->logo_color))
    <style type="text/css">
        .article-title, .article-content h1, .article-content h2, .article-content h3, .article-content h4, .article-content h5, .article-content h6, .article-content p:first-of-type::first-letter, .article-content .epigraph, .aside::before, .aside h1, .aside h2 {
            color: {{ $article->logo_color }};
            border-color: {{ $article->logo_color }};
        }
    </style>
@endunless

@if ($article->logo_ratio === 'landscape')
    <style type="text/css">
        .public-content.container-fluid {
            margin-top: 5rem;
        }
    </style>
@endif

{{-- Article non-landscape logo --}}
@unless (empty($article->logo) || $article->logo_ratio != 'landscape')
<div class="public-content container-fluid">
    <figure class="article-figure {{ $article->logo_ratio or '' }}">
        <img src="{{ asset('uploads/large_' . $article->logo) }}" class="img-responsive article-logo" alt="{{ $article->logo_caption or $article->title }}">
        @unless (empty($article->logo_caption))
            <figcaption>{{ $article->logo_caption }}</figcaption>
        @endunless
    </figure>
</div>
@endunless

<div class="public-content container">

    <article class="article row">

        <h1 class="article-title">{{ $article->title }}</h1>

        @unless (empty($article->chapeau))
        <div class="article-chapeau">
            {!! $article->chapeau !!}
        </div>
        @endunless

        <div class="article-infos">
            Publication initiale : <a href="{{ route('issue.show', $article->issue_id) }}">Polenta {{ $article->issue->title }}</a> ・ Environ {{ $article->length }} mn ({{ $article->words_count }} mots)

            @include('partials._share-button', ['url' => route('article.show', $article->id)])
        </div>

        <div class="article-content">

            {{-- Article landscape logo --}}
            @unless (empty($article->logo) || $article->logo_ratio === 'landscape')
                <figure class="article-figure {{ $article->logo_ratio or '' }}">
                    <img src="{{ asset('uploads/large_' . $article->logo) }}" class="img-responsive article-logo" alt="{{ $article->logo_caption or $article->title }}">
                    @unless (empty($article->logo_caption))
                        <figcaption>{{ $article->logo_caption }}</figcaption>
                    @endunless
                </figure>
            @endunless

            {!! $article->content !!}

        </div>

            @unless (empty($article->aside1))
                <div class="aside aside1" style="border-color: {{ $article->logo_color }};">
                    {!! $article->aside1 !!}
                </div>
            @endunless

            @unless (empty($article->aside2))
                <div class="aside aside2" style="border-color: {{ $article->logo_color }};">
                    {!! $article->aside2 !!}
                </div>
            @endunless
        </div>
    </article>

</div>

<div class="same-issue-container container-fluid">

    <section class="row same-issue" id="same-issue">

        <h2 class="text-center subtitle">Également dans <a href="{{ route('issue.show', $article->issue->id) }}">Polenta {{ $article->issue->title }}</a></h2>

        <div class="articles-grid same-issue-articles">
            @each ('articles._presentation-grid', $article->issue->articles, 'article', ['class' => 'multiple-items'])
        </div>

    </section>

</div>

@stop

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/article.css') }}">
@endpush

@push('scripts')
<script type="text/javascript" src="{{ asset('js/article.js') }}"></script>

<script type="text/javascript">

$('.same-issue-articles').slick({
    dots: true,
    infinite: true,
    slidesToShow: 3,
    responsive: [
        {
            breakpoint: 1200,
            settings: {
                dots: true,
                infinite: true,
                slidesToShow: 3,
            }
        },
        {
            breakpoint: 992,
            settings: {
                dots: true,
                infinite: true,
                slidesToShow: 2,
            }
        },
        {
            breakpoint: 768,
            settings: {
                dots: true,
                arrows: false,
                infinite: true,
                slidesToShow: 1,
            }
        }
    ]
});

$(document).ready(function () {
    espaceFine($('.article'));
})

$('.footnote').each(function() {
    this.append('<i class="fa fa-sticky-note" aria-hidden="true"></i>');
});
</script>
@endpush
