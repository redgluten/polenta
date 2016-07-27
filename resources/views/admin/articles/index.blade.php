@extends('layouts.admin')

@section('title')
Tous les articles
@stop

@section('breadcrumb')
    <li><a href="{{ route('admin.index') }}">Tableau de bord</a></li>
    <li class="active">@yield('title')</li>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <aside class="col-md-2 sidebar">
            @include('admin.partials._nav-aside')

            <h3>Actions</h3>
            @include('admin.partials._add-resource', ['url' => route('admin.article.create'), 'text' => 'Nouvel article'])

            <hr>

            @include('admin.partials._search-form')
        </aside>

        <div class="col-md-10 main">
            <h1>Articles</h1>

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
                        @foreach ($articles as $article)
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
                                @include('admin.partials._delete-button', ['id' => $article->id, 'text' => 'Êtes-vous sur de vouloir supprimer l’article ' . $article->title . ' ?', 'url' => route('admin.article.destroy', $article->id)])
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {!! $articles->links() !!}
        </div>
    </div>
</div>
@stop
