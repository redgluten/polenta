@extends('layouts.admin')

@section('title')
Recherche
@stop

@section('breadcrumb')
    <li><a href="{{ route('admin.index') }}">Tableau de bord</a></li>
    <li class="active">@yield('title')</li>
@stop

@section('content')
<div class="public-content container">
    <div class="row">
        <h1>@yield('title')</h1>

        @if ($articles->isEmpty())
            <h2>Désolé votre recherche n’a produit aucun résultat, veuillez réessayer :</h2>

            @include('admin.partials._search-form', ['route' => 'admin.search'])
        @else
            <h2>Les articles suivants correspondent à votre recherche&#xA0;:</h2>

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Logo</th>
                            <th>Title</th>
                            <th>Numéro</th>
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
                                @include('admin.partials._delete-button', ['text' => 'Êtes-vous sur de vouloir supprimer l’article ' . $article->title . ' ?', 'url' => route('admin.article.destroy', $article->id)])
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {!! $articles->links() !!}
        @endif
    </div>
</div>
@stop
