@extends('layouts.public')

@section('title')
{{ $slogan }}
@stop

@section('content')
<div class="public-content container">
    <h1 class="kiosques">En kiosques : <a href="{{ route('issue.show', $lastIssue) }}">{{ $lastIssue->title }}</a></h1>

    @include('issues._issue', ['issue' => $lastIssue])

    <hr>

    <div class="row">
        <div class="col-md-4">
            <h4 class="subtitle">Les copains</h4>

            <ul class="list-group">
                @foreach ($friendList as $url => $name)
                    <li class="list-group-item"><a href="{{ $url }}" target="_blank">{{ $name }}</a></li>
                @endforeach
            </ul>
        </div>

        <div class="col-md-8">
            <h4 class="subtitle">Nous contacter</h4>
            <div class="well clearfix">
                @include('partials._contact-form')
            </div>
        </div>
    </div>
</div>
@endsection
