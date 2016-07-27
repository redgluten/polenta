@extends('layouts.public')

@section('title')
{{ $issue->title }}
@stop

@section('content')
<div class="public-content container">
    <h1 class="title">{{ ucfirst($issue->title) }}</h1>

    @include('issues._issue', ['issue' => $issue])

    <hr>

    <div class="row issue-masthead">
        <div class="col-md-12">
            <h2 class="subtitle">Ourse</h2>

            {!! $issue->masthead !!}
        </div>
    </div>
</div>
@stop
