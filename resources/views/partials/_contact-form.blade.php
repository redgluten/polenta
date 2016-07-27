{!! Form::open(['method' => 'POST', 'route' => 'contact']) !!}

    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
        {!! Form::label('email', 'Email') !!}
        {!! Form::text('email', null, ['class' => 'form-control', 'required' => 'required']) !!}
        <small class="text-danger">{{ $errors->first('email') }}</small>
    </div>

    <div class="form-group{{ $errors->has('message') ? ' has-error' : '' }}">
        {!! Form::label('message', 'Message') !!}
        {!! Form::textarea('message', null, ['class' => 'form-control', 'required' => 'required']) !!}
        <small class="text-danger">{{ $errors->first('message') }}</small>
    </div>

    {!! Form::submit('Envoyer', ['class' => 'btn btn-info pull-right']) !!}

{!! Form::close() !!}
