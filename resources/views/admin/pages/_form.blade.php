<div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
    {!! Form::label('title', 'Titre *', ['class' => 'control-label']) !!}
    {!! Form::text('title', null, ['class' => 'form-control', 'required' => 'required']) !!}
    <small class="text-danger">{{ $errors->first('title') }}</small>
</div>

<div class="form-group{{ $errors->has('url') ? ' has-error' : '' }}">
    {!! Form::label('url', 'URL', ['class' => 'control-label']) !!}
    {!! Form::text('url', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('url') }}</small>
</div>

<hr>

<div class="form-group{{ $errors->has('content') ? ' has-error' : '' }}">
    {!! Form::label('content', 'Contenu *', ['class' => 'control-label']) !!}
    <!-- toolbar with suitable buttons and dialogues -->
    @include('admin.partials/_toolbar', ['id' => 'content-toolbar', 'image' => true])
    <textarea id="content" name="content" class="form-control" rows="20" required>
        {!! $page->content or null !!}
    </textarea>
    <small class="text-danger">{{ $errors->first('content') }}</small>
</div>

<hr>

<div class="form-group{{ $errors->has('display_in_menu') ? ' has-error' : '' }}">
    <div class="checkbox">
        <label for="display_in_menu">
            {!! Form::checkbox('display_in_menu', '1', null, ['id' => 'display_in_menu']) !!} Afficher dans le menu
        </label>
    </div>
    <small class="text-danger">{{ $errors->first('display_in_menu') }}</small>
</div>

<div class="form-group{{ $errors->has('display_in_footer')  ? ' has-error' : '' }}">
    <div class="checkbox">
        <label for="display_in_footer">
            {!! Form::checkbox('display_in_footer', '1', null, ['id' => 'display_in_footer']) !!} Afficher dans le pied de page
        </label>
    </div>
    <small class="text-danger">{{ $errors->first('display_in_footer') }}</small>
</div>

@section('modals')
    @include('admin.partials/_toolbar-image', ['id' => 'content-toolbar'])
@stop

@push('scripts')
<script type="text/javascript">
    // activate wysihtml editors
    var editor = new wysihtml5.Editor('content', {
        toolbar: 'content-toolbar',
        stylesheets: '{{ asset('css/editor.css') }}',
        parserRules:  wysihtml5ParserRules,
    });
    // Insert image
    $('#form-image-picker-content-toolbar').on('submit', function(event) {
        uploadImage('/admin/pages/upload-image', event, editor, $(this));
    });
</script>
@endpush
