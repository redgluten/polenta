@extends('layouts.admin')

@section('title')
Admin accueil
@stop

@section('content')
<div class="container">
    <div class="jumbotron">
        <h1 class="text-center">@icon('gears') Administration</h1>

        <ul class="menu-page">
            @include('admin._menus-admin')
        </ul>

    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">@icon('line-chart') Articles populaires</h3>
                </div>
                <ul class="list-group">
                    @foreach ($mostReadArticles as $article)
                        <li class="list-group-item">
                            <a href="{{ route('article.show', $article) }}">{{ $article->title }} <span class="pull-right badge">{{ $article->reads }}</span></a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">@icon('clock-o') Dernières modifications</h3>
                </div>
                <ul class="list-group">
                    @foreach ($lastModifications as $article)
                        <li class="list-group-item">
                            <a href="{{ route('article.show', $article) }}">{{ $article->title }} <span class="pull-right text-muted">{{ $article->updated_at->format('d/m/Y à h\hi') }}</span></a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        {{-- Backups --}}
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">@icon('download') Sauvegardes</div>

                @if ($backups->isEmpty())
                    <p class="text-muted">Aucune sauvegarde disponible pour le moment.</p>
                @else
                <ul class="list-group">
                    @foreach ($backups as $name => $size)
                        <a class="list-group-item" href="{{ route('backups.download', $name) }}">
                            <h6 class="list-group-item-heading">{{ $name }}</h6>
                            <p class="list-group-item-text">{{ $size }}</p>
                        </a>
                    @endforeach
                </ul>
                @endif

                <footer class="panel-footer clearfix">
                    {!! Form::open(['method' => 'POST', 'route' => 'backup.run', 'class' => 'form-inline']) !!}

                        <button type="submit" class="btn btn-success  pull-right">@icon('cloud-download') Sauvegarder</button>

                    {!! Form::close() !!}
                </footer>
            </div>
        </div>
    </div><!-- .row -->
</div>
@stop
