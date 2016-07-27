@extends('layouts.admin')

@section('title')
Ajouter une page
@stop

@section('breadcrumb')
    <li><a href="/admin">Tableau de bord</a></li>
    <li><a href="{{ route('admin.page.index') }}">Les pages</a></li>
    <li class="active">@yield('title')</li>
@endsection

@section('content')
<div class="container">
    <div class="col-md-8 col-md-offset-2">
        <h1><span aria-hidden="true"><i class="fa fa-file-o"></i></span> @yield('title')</h1>

        {!! Form::open([
            'method' => 'POST',
            'route'  => 'admin.page.store'
        ]) !!}

            @include('admin.pages._form')

            @include('partials._forms-errors')

            {!! Form::submit('Ajouter', ['class' => 'btn btn-success pull-right']) !!}

        {!! Form::close() !!}
    </div>
</div>
@stop
