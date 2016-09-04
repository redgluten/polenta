@extends('layouts.admin')

@section('title')
Brouillons
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

            @include('admin.articles._folders', ['active' => 'drafts'])
        </aside>

        <div class="col-md-10 main">
            @if (! $drafts->isEmpty())
                <h1 class="subtitle">@yield('title')</h1>

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Logo</th>
                                <th>Title</th>
                                <th>Numéro</a></th>
                                <th>Modifier</th>
                                <th>Corbeille</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($drafts as $article)
                            <tr>
                                <th>
                                    <img src="{{ asset('uploads/thumb_' . $article->logo_or_placeholder) }}" class="img-thumbnail small-thumb" alt="{{ $article->title }}">
                                </th>

                                <td>{{ $article->title }}</td>

                                <td>{{ $article->issue->title }}</td>

                                <td class="text-center">
                                    @include('admin.partials._edit-button', ['url' => route('admin.article.edit', $article->id)])
                                </td>

                                <td class="text-center">
                                    @include('admin.partials._delete-button', ['id' => $article->id, 'text' => 'Êtes-vous sur de vouloir déplacer l’article ' . $article->title . ' vers la corbeille ?', 'url' => route('admin.article.destroy', $article->id)])
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {!! $drafts->links() !!}
            @else
            <div class="jumbotron text-center">
                <h1>@icon('file-o') Vide</h1>
                <p>
                    Il n’y a aucun brouillon pour pour le moment.<br>
                    @include('admin.partials._add-resource', ['url' => route('admin.article.create'), 'text' => 'Nouvel article'])
                </p>
            </div>
            @endif
        </div>
    </div>
</div>
@stop
