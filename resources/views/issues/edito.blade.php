@extends('layouts.public')

@section('title')
Éditorial du numéro {{ $issue->title }}
@stop

@section('content')
<div class="public-content container">
    <div class="row issue">
        <div class="col-sm-4">
            @include('issues._info')
        </div>

        <div class="col-sm-8">
            <h3 class="subtitle">Éditorial</h3>

            <div class="editorial">
                <h1>{{ $issue->editorial_title }}</h1>

                <div class="content">
                    {!! $issue->editorial_content !!}
                </div>
            </div>
        </div>
    </div>

    <hr>

    <div class="row articles-grid">
        <div class="col-md-12">
            <h3 class="subtitle">Les articles</h3>
        </div>

        @each ('articles._presentation-grid', $issue->articles, 'article')
    </div>

</div>
@stop