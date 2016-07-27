@extends('layouts.admin')

@section('title')
Nouveau numéro
@stop

@section('breadcrumb')
    <li><a href="{{ route('admin.index') }}">Tableau de bord</a></li>
    <li><a href="{{ route('admin.issue.index') }}">Les numéros</a></li>
    <li class="active">@yield('title')</li>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <aside class="col-sm-3 sidebar">

        </aside>

        <div class="col-md-8 col-md-offset-3 main">
            <h1>@yield('title')</h1>

            {!! Form::open([
                'route'  => 'admin.issue.store',
                'method' => 'POST',
                'files'  => true
            ]) !!}

                @include('admin.issues._form')

                {!! Form::submit('Enregistrer', ['class' => 'btn btn-info']) !!}

            {!! Form::close() !!}
        </div>
    </div>
</div>
@stop
