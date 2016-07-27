@extends('layouts.admin')

@section('title')
Modifier «&#xA0;{{ $friend->name }}&#xA0;»
@stop

@section('breadcrumb')
    <li><a href="{{ route('admin.index') }}">Tableau de bord</a></li>
    <li><a href="{{ route('admin.friend.index') }}">Les copains</a></li>
    <li class="active">@yield('title')</li>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <aside class="col-sm-3 sidebar">

        </aside>

        <div class="col-md-8 col-md-offset-3 main">
            <h1>@yield('title')</h1>

            {!! Form::model($friend, [
                'route'  => ['admin.friend.update', $friend->id],
                'method' => 'PUT',
            ]) !!}

                @include('admin.friends._form')

                {!! Form::submit('Enregistrer', ['class' => 'btn btn-info']) !!}

            {!! Form::close() !!}
        </div>
    </div>
</div>
@stop
