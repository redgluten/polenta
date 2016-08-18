@extends('layouts.admin')

@section('title')
Les copain-ines
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
            @include('admin.partials._add-resource', ['url' => route('admin.friend.create'), 'text' => 'Nouveau copain'])
        </aside>

        <div class="col-md-10 main">
            <h1 class="subtitle">Copains</h1>

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>URL</th>
                            <th>Modifier</th>
                            <th>Corbeille</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($friends as $friend)
                        <tr>
                            <td>{{ $friend->name }}</td>

                            <td><a href="{{ $friend->url }}">{{ $friend->url }}</a></td>

                            <td class="text-center">
                                @include('admin.partials._edit-button', ['url' => route('admin.friend.edit', $friend->id)])
                            </td>

                            <td class="text-center">
                                @include('admin.partials._delete-button', ['text' => 'Êtes-vous sur de vouloir supprimer ' . $friend->name . ' ?', 'url' => route('admin.friend.destroy', $friend->id), 'id' => $friend->id])
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {!! $friends->links() !!}
        </div>
    </div>
</div>
@stop
