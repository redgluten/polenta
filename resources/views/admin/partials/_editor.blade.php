<div class="form-group{{ $errors->has($fieldName) ? ' has-error' : '' }}">
    {!! Form::label($fieldName, $editorLabel) !!}

    {{-- Toolbar with suitable buttons and dialogues --}}
    @include('admin/partials/_toolbar', ['id' => $fieldName . '-toolbar'])

    <textarea id="{{ $fieldName }}" name="{{ $fieldName }}" rows="{{ empty($rows) ? 10 : $rows }}" class="form-control"{{ empty($required) ? '' : ' required' }}>
        {!! $content or null !!}
    </textarea>

    <small class="text-danger">{{ $errors->first('$fieldName') }}</small>
</div>

@push('scripts')
    <script type="text/javascript">
        {{-- Activate the editor --}}
        var {{ $fieldName }}Editor = new wysihtml5.Editor({{ $fieldName }}, {
            toolbar: '{{ $fieldName }}-toolbar',
            stylesheets: '{{ asset('css/editor.css') }}',
            parserRules:  wysihtml5ParserRules,
            useLineBreaks: false,
        });
    </script>
@endpush