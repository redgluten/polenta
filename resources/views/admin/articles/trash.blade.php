@extends('layouts.admin')

@section('title')
Corbeille
@stop

@section('breadcrumb')
    <li><a href="{{ route('admin.index') }}">Tableau de bord</a></li>
    <li class="active">@yield('title')</li>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <aside class="col-md-2 sidebar">
            <h3>Actions</h3>
            @include('admin.partials._add-resource', ['url' => route('admin.article.create'), 'text' => 'Nouvel article'])

            <hr>

            @include('admin.partials._search-form')

            <hr>

            @include('admin.articles._folders', ['active' => 'trash'])
        </aside>

        <div class="col-md-10 main">
            @if (! $trashedArticles->isEmpty())
                <h1 class="subtitle">@yield('title')</h1>

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Logo</th>
                                <th>Title</th>
                                <th>Numéro</a></th>
                                <th>Modifier</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($trashedArticles as $article)
                            <tr>
                                <th>
                                    <img src="{{ asset('uploads/thumb_' . $article->logo_or_placeholder) }}" class="img-thumbnail small-thumb" alt="{{ $article->title }}">
                                </th>

                                <td>{{ $article->title }}</td>

                                <td>{{ $article->issue->title }}</td>

                                <td class="text-center">
                                    {!! Form::open(['url' => route('admin.article.untrash', $article)]) !!}
                                        <button type="submit" id="untrash-{{ $article->id }}" class="btn btn-info"><i class="fa fa-file-o" aria-hidden="true"></i> Convertir en brouillon</button>
                                    {!! Form::close() !!}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {!! $trashedArticles->links() !!}
            @else
                <div class="jumbotron text-center">
                    <h1><i class="fa fa-trash" aria-hidden="true"></i> Vide</h1>
                    <p>Il n’y a actuellement aucun article à la corbeille.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@stop
