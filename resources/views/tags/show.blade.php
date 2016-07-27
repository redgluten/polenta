@extends('layouts.public')

@section('title')
Recherche par mot-clef&#xA0;: «&#xA0;{{ $tag->name }}&#xA0;»
@stop

@section('content')
<div class="public-content container">

    <h1>@yield('title')</h1>

    <hr>

    <div class="row">
        @unless ($articles->isEmpty())
            <h2 class="subtitle">Articles associés</h2>

            <div class="articles-grid">
                @each ('articles._presentation-grid', $articles, 'article')
            </div>
        @endunless
    </div>
</div>
@stop
