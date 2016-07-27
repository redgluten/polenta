@extends('layouts.public')

@section('title')
Les mots-clef
@stop

@section('content')
<div class="public-content container">
    <div class="row">
        <h1>@yield('title')</h1>

        <div class="cloud">
            @foreach ($tags as $tag)
                <span class="{{ $tag->size }}"><a href="{{ route('tag.show', $tag->id) }}">{{ $tag->name }}</a></span>
            @endforeach
        </div>
    </div>
</div>
@stop
