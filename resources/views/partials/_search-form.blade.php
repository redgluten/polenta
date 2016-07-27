{!! Form::open([
    'method' => 'POST',
    'route'  => $route,
    'class'  => isset($class) ? $class : 'inline-form',
    'role'   => 'search',
]) !!}

    <div class="form-group{{ $errors->has('search') ? ' has-error' : '' }}">
        {!! Form::label('search', 'Rechercher', ['class' => 'sr-only']) !!}
        <div class="input-group">
            {!! Form::text('search', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'Rechercher']) !!}
            <span class="input-group-addon"><i class="fa fa-search" aria-hidden="true"></i></span>
        </div>
        <small class="text-danger">{{ $errors->first('search') }}</small>
    </div>

{!! Form::close() !!}
