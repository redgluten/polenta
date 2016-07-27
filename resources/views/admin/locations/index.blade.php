@extends('layouts.admin')

@section('title')
Tous les lieux de distribution
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
            @include('admin.partials._add-resource', ['url' => route('admin.location.create'), 'text' => 'Nouveau lieu'])
        </aside>

        <div class="col-md-10 main">
            <h1>Lieux de distributions</h1>

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Ville</th>
                            <th>Description</th>
                            <th>Longitude</a></th>
                            <th>Latitude</a></th>
                            <th>Modifier</th>
                            <th>Corbeille</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($locations as $location)
                        <tr>
                            <td>
                                {{ $location->name }}
                            </td>

                            <td>{{ $location->city }}</td>

                            <td>{{ $location->description }}</td>

                            <td class="text-center">{{ $location->longitude }}</td>

                            <td class="text-center">
                                {{ $location->latitude }}
                            </td>

                            <td class="text-center">
                                @include('admin.partials._edit-button', ['url' => route('admin.location.edit', $location->id)])
                            </td>

                            <td class="text-center">
                                @include('admin.partials._delete-button', ['text' => 'Êtes-vous sur de vouloir supprimer le lieu ' . $location->name . ' ?', 'url' => route('admin.location.destroy', $location->id), 'id' => $location->id])
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {!! $locations->links() !!}
        </div>
    </div>
</div>
@stop
