<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
    {!! Form::label('name', 'Titre') !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required']) !!}
    <small class="text-danger">{{ $errors->first('name') }}</small>
</div>

<div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
    {!! Form::label('city', 'Ville') !!}
    {!! Form::text('city', null, ['class' => 'form-control', 'required' => 'required']) !!}
    <small class="text-danger">{{ $errors->first('city') }}</small>
</div>

<div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
    {!! Form::label('description', 'Description') !!}
    {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('description') }}</small>
</div>

<div class="form-group{{ $errors->has('longitude') ? ' has-error' : '' }}">
    {!! Form::label('longitude', 'Longitude') !!}
    {!! Form::number('longitude', null, ['class' => 'form-control', 'required' => 'required']) !!}
    <small class="text-danger">{{ $errors->first('longitude') }}</small>
</div>

<div class="form-group{{ $errors->has('latitude') ? ' has-error' : '' }}">
    {!! Form::label('latitude', 'Latitude') !!}
    {!! Form::number('latitude', null, ['class' => 'form-control', 'required' => 'required']) !!}
    <small class="text-danger">{{ $errors->first('latitude') }}</small>
</div>


@include('partials._forms-errors')