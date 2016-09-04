{!! Form::open([
    'method' => 'POST',
    'route'  => 'admin.search',
    'role'   => 'search',
    'class'  => 'clearfix',
]) !!}

    <h3>Recherche</h3>

    <div class="form-group{{ $errors->has('issue_list') ? ' has-error' : '' }}">
        {!! Form::label('issue_list', 'Numéro(s)') !!}
        {!! Form::select('issue_list[]', $issues, null, ['id' => 'issue_list', 'class' => 'form-control', 'required' => 'required', 'multiple']) !!}
        <small class="text-danger">{{ $errors->first('issue_list') }}</small>
    </div>

    <div class="form-group{{ $errors->has('search') ? ' has-error' : '' }}">
        {!! Form::label('search', 'Contenu') !!}
        {!! Form::text('search', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'Ex : sasson']) !!}
        <small class="text-danger">{{ $errors->first('search') }}</small>
    </div>

    <button type="submit" class="btn btn-info">@icon('search') Rechercher</button>

{!! Form::close() !!}

@push('scripts')
    <script type="text/javascript">
        $('#issue_list').select2({
            placeholder: 'Lesquel(s) ?',
            allowClear: true
        });
    </script>
@endpush
