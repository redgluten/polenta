@extends('layouts.public')

@section('title')
{{ $page->title }}
@stop

@section('breadcrumb')
    <li><a href="/">Accueil</a></li>
    <li class="active">@yield('title')</li>
@stop

@section('content')
<div class="public-content container">

    <article class="row">

        <h1 class="title">{{ $page->title }}</h1>

        {!! $page->content !!}

    </article>

    <hr>

    <section class="row">

        <h2 class="subtitle">Nous contacter</h2>

        <div class="well col-sm-6">
            @include('partials._contact-form')
        </div>

    </section>
</div>
@stop
