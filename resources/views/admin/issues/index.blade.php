@extends('layouts.admin')

@section('title')
Tous les numéros
@stop

@section('breadcrumb')
    <li><a href="{{ route('admin.index') }}">Tableau de bord</a></li>
    <li class="active">@yield('title')</li>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <aside class="col-sm-2 sidebar">
            <h3>Actions</h3>
            @include('admin.partials._add-resource', ['url' => route('admin.issue.create'), 'text' => 'Nouveau numéro'])
        </aside>

        <div class="col-sm-10 main">
            <h1 class="subtitle">@yield('title')</h1>

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Une</th>
                            <th>Titre</th>
                            <th>Articles</th>
                            <th>Modifier</th>
                            <th>Corbeille</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($issues as $issue)
                        <tr>
                            <td>
                                <span class="badge">{{ $issue->number }}</span>
                            </td>

                            <td>
                                <img src="{{ asset('uploads/thumb_' . $issue->cover) }}" class="img-thumbnail small-thumb" alt="{{ $issue->title }}">
                            </td>

                            <td>{{ $issue->title }}</td>

                            <td>
                                <span class="badge">{{ $issue->articles()->count() }}</span>
                            </td>

                            <td class="text-center">
                                @include('admin.partials._edit-button', ['url' => route('admin.issue.edit', $issue->id)])
                            </td>

                            <td class="text-center">
                                @include('admin.partials._delete-button', ['id' => $issue->id, 'text' => 'Êtes-vous sur de vouloir supprimer le numéro ' . $issue->title . ' ?', 'url' => route('admin.issue.destroy', $issue->id)])
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {!! $issues->links() !!}
        </div>
    </div>
</div>
@stop
