@extends('layouts.admin')

@section('title')
Modifier le lieu «&#xA0;{{ $location->name }}&#xA0;»
@stop

@section('breadcrumb')
    <li><a href="{{ route('admin.index') }}">Tableau de bord</a></li>
    <li><a href="{{ route('admin.location.index') }}">Les lieux de distributions</a></li>
    <li class="active">@yield('title')</li>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <aside class="col-sm-3 sidebar">

        </aside>

        <div class="col-md-8 col-md-offset-3 main">
            <h1>@yield('title')</h1>

            {!! Form::model($location, [
                'route'  => ['admin.location.update', $location->id],
                'method' => 'PUT',
            ]) !!}

                @include('admin.locations._form')

                {!! Form::submit('Enregistrer', ['class' => 'btn btn-info']) !!}

            {!! Form::close() !!}
        </div>
    </div>
</div>
@stop
