@extends('layouts.admin')

@section('title')
Modifier la page {{ $page->title }}
@stop

@section('breadcrumb')
    <li><a href="/admin">Tableau de bord</a></li>
    <li><a href="{{ route('admin.page.index') }}">Les pages</a></li>
    <li class="active">@yield('title')</li>
@endsection

@section('content')
<div class="container">
    <div class="col-sm-8 col-sm-offset-2">

        <h1><span aria-hidden="true"><i class="fa fa-pencil-square-o"></i></span> @yield('title')</h1>

        {!! Form::model($page, [
            'route'  => ['admin.page.update', $page->id],
            'method' => 'PUT',
        ]) !!}

            @include('admin.pages._form')

            @include('partials._forms-errors')

            {!! Form::submit('Enregistrer les modifications', ['class' => 'btn btn-info pull-right']) !!}

        {!! Form::close() !!}

    </div>
</div>
@stop
