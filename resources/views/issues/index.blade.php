@extends('layouts.public')

@section('title')
Les archives de Polenta !
@stop

@section('content')
<div class="public-content container">
    <div class="row">
        <h1 class="title">@yield('title')</h1>

        <h2 class="subtitle">Numéros</h2>
        <div class="issues">
            @each ('issues._presentation', $issues, 'issue')
        </div>
    </div>

    <div class="row">
        <h2 class="subtitle">Mots-clefs</h2>

        <div class="cloud">
            @foreach ($tags as $tag)
                <span class="{{ $tag->size }}"><a href="{{ route('tag.show', $tag->id) }}">{{ $tag->name }}</a></span>
            @endforeach
        </div>
    </div>
</div>
@stop
