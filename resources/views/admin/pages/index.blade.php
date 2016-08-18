@extends('layouts.admin')

@section('title')
Les pages
@stop

@section('breadcrumb')
    <li><a href="/admin">Tableau de bord</a></li>
    <li class="active">@yield('title')</li>
@endsection

@section('content')
<div class="container-fluid">

    <div class="row">
        <aside class="col-sm-2 sidebar">
            <h3>Actions</h3>
            @include('admin.partials._add-resource', ['url' => route('admin.page.create'), 'text' => 'Ajouter une page'])
        </aside>

        <div class="col-md-10">
            <h1 class="subtitle"><span aria-hidden="true"><i class="fa fa-file-o"></i></span> @yield('title')</h1>

            <!-- pages index -->
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Titre</th>
                            <th>Date</th>
                            <th>Modifier</th>
                            <th>Supprimer</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($pages as $page)
                        <tr>
                            <td>
                                <a href="{{ route('admin.page.show', $page->id) }}">{{ $page->title }}</a>
                            </td>

                            <td>{{ $page->created_at->format('d/m/Y') }}</td>

                            <td class="text-center">
                                @include('admin.partials._edit-button', ['url' => route('admin.page.edit', $page->id)])
                            </td>

                            <td class="text-center">
                                @include('admin.partials._delete-button', ['text' => 'Êtes-vous sur de vouloir supprimer la page ' . $page->title . ' ?', 'url' => route('admin.page.destroy', $page->id), 'id' => $page->id])
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {!! $pages->render() !!}
        </div>
    </div>
</div>
@stop
