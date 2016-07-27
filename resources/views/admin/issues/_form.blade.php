<div class="form-group{{ $errors->has('published_at') ? ' has-error' : '' }}">
    {!! Form::label('published_at', 'Date de publication *') !!}
    {!! Form::date('published_at', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'ex : 19/02/1987']) !!}
    <small class="text-danger">{{ $errors->first('published_at') }}</small>
</div>

<div class="form-group{{ $errors->has('number') ? ' has-error' : '' }}">
    {!! Form::label('number', 'Numéro *') !!}
    {!! Form::number('number', null, ['class' => 'form-control', 'required' => 'required']) !!}
    <small class="text-danger">{{ $errors->first('number') }}</small>
</div>

<hr>

<div class="form-group{{ $errors->has('masthead') ? ' has-error' : '' }}">
    {!! Form::label('masthead', 'Ourse') !!}
    <!-- toolbar with suitable buttons and dialogues -->
    @include('admin/partials/_toolbar', ['id' => 'masthead-toolbar'])
    <textarea id="masthead" name="masthead" rows="10" class="form-control" required>
        {!! $issue->masthead or null !!}
    </textarea>
    <small class="text-danger">{{ $errors->first('masthead') }}</small>
</div>

<hr>

<div class="form-group{{ $errors->has('editorial_title') ? ' has-error' : '' }}">
    {!! Form::label('editorial_title', 'Titre de l’éditorial') !!}
    {!! Form::text('editorial_title', null, ['class' => 'form-control', 'required' => 'required']) !!}
    <small class="text-danger">{{ $errors->first('editorial_title') }}</small>
</div>

<div class="form-group{{ $errors->has('editorial_content') ? ' has-error' : '' }}">
    {!! Form::label('editorial_content', 'Contenu de l’éditorial') !!}
    <!-- toolbar with suitable buttons and dialogues -->
    @include('admin/partials/_toolbar', ['id' => 'editorial_content-toolbar'])
    <textarea id="editorial_content" name="editorial_content" rows="20" class="form-control" required>
        {!! $issue->editorial_content or null !!}
    </textarea>
    <small class="text-danger">{{ $errors->first('editorial_content') }}</small>
</div>

<hr>

<div class="form-group">
    {!! Form::label('cover', 'Couverture') !!}
    @if (empty($issue->cover))
        {!! Form::file('cover') !!}
        <p class="help-block">Ajouter un cover</p>
    @else
        <div class="row">
            <div class="col-md-3">
                <a href="#coverModal" data-toggle="modal" data-target="#coverModal">
                    <img src="{{ asset('uploads/small_' . $issue->cover) }}" alt="{{ $issue->title }}" class="img-thumbnail">
                </a>

                <!-- Modal -->
                <div class="modal fade" id="coverModal" tabindex="-1" role="dialog" aria-labelledby="coverModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="coverModalLabel">Couverture actuelle du numéro</h4>
                            </div>
                            <div class="modal-body">
                                <img src="{{ asset('uploads/' . $issue->cover) }}" alt="{{ $issue->title }}" class="img-responsive">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="form-group{{ $errors->has('cover') ? ' has-error' : '' }}">
                    <p class="help-block">Changer la couverture actuelle</p>
                    {!! Form::file('cover') !!}
                </div>
            </div>
        </div>
    @endif
    <small class="text-danger">{{ $errors->first('cover') }}</small>
</div>

<div class="form-group{{ $errors->has('print_file') ? ' has-error' : '' }}">
    {!! Form::label('print_file', 'Maquette au format PDF') !!}
    {!! Form::file('print_file', ['required' => 'required']) !!}
    @if (empty($issue->print_file))
        <p class="help-block"><i class="fa fa-pdf"></i> Ajouter un fichier PDF</p>
    @else
        <a href="{{ url('uploads/' . $issue->print_file) }}" target="_blank"><i class="fa fa-pdf"></i> Voir le fichier PDF actuel</a>
        <p class="help-block">Changer le fichier PDF</p>
    @endif
    <small class="text-danger">{{ $errors->first('print_file') }}</small>
</div>

@push('scripts')
<script type="text/javascript">
    // activate wysihtml editors
    var editor = new wysihtml5.Editor(masthead, {
        toolbar: 'masthead-toolbar',
        stylesheets: '{{ asset('css/editor.css') }}',
        parserRules:  wysihtml5ParserRules,
        useLineBreaks: false,
    });

    var contentEditor = new wysihtml5.Editor(editorial_content, {
        toolbar: 'editorial_content-toolbar',
        stylesheets: '{{ asset('css/editor.css') }}',
        parserRules:  wysihtml5ParserRules,
        useLineBreaks: false,
    });
</script>
@endpush
