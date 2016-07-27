@extends('layouts.public')

@section('title')
Recherche «&#xA0;{{ $search }}&#xA0;»
@stop

@section('content')
<div class="public-content container">
    <div class="row">
        <h1>@yield('title')</h1>

    @if ($articles->isEmpty())
        <h2>Désolé votre recherche n’a produit aucun résultat, veuillez réessayer :</h2>

        @include('partials._search-form', ['route' => 'search'])

    </div><!-- .row -->
    @else
        <div class="col-md-3 col-md-offset-4">
            @include('partials._search-form', ['route' => 'search'])
        </div>

        </div><!-- .row -->
        <div class="row">
            <h2>Les articles suivants correspondent à votre recherche&#xA0;:</h2>

            <div class="articles-grid">
                @each ('articles._presentation-grid', $articles, 'article')
            </div>
        </div>
    @endif
</div>
@stop
