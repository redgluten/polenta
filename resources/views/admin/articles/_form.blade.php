<hr>

<p class="text-muted">Les champs suivis d’une astérique (*) sont obligatoires.</p>

<hr>

<div class="form-group{{ $errors->has('url') ? ' has-error' : '' }}">
    {!! Form::label('url', 'URL') !!}
    {!! Form::text('url', null, ['class' => 'form-control']) !!}
    <p class="help-block">Changer l’adresse URL a des conséquences négatives sur le référencement</p>
    <small class="text-danger">{{ $errors->first('url') }}</small>
</div>

<hr>

<div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
    {!! Form::label('title', 'Titre *') !!}
    {!! Form::text('title', null, ['class' => 'form-control', 'required' => 'required']) !!}
    <small class="text-danger">{{ $errors->first('title') }}</small>
</div>

@include('admin.partials._editor', ['fieldName' => 'chapeau', 'editorLabel' => 'Chapeau *', 'content' => empty($article->chapeau) ? null : $article->chapeau, 'required' => true])

@include('admin.partials._editor', ['fieldName' => 'content', 'editorLabel' => 'Contenu *', 'content' => empty($article->content) ? null : $article->content, 'required' => true, 'rows' => 20])

@include('admin.partials._editor', ['fieldName' => 'aside1', 'editorLabel' => 'Encadré n°1', 'content' => empty($article->aside1) ? null : $article->aside1, 'required' => false])

@include('admin.partials._editor', ['fieldName' => 'aside2', 'editorLabel' => 'Encadré n°2', 'content' => empty($article->aside2) ? null : $article->aside2, 'required' => false])

<hr>

<div class="form-group{{ $errors->has('issue_id') ? ' has-error' : '' }}">
    {!! Form::label('issue_id', 'Numéro *') !!}
    {!! Form::select('issue_id', $issues, null, ['id' => 'issue_id', 'class' => 'form-control', 'placeholder' => '---']) !!}
    <small class="text-danger">{{ $errors->first('issue_id') }}</small>
</div>

<div class="form-group">
    {!! Form::label('logo', 'Logo') !!}
    @if (empty($article->logo))
        {!! Form::file('logo') !!}
        <p class="help-block">Ajouter un logo</p>
        <div class="form-group{{ $errors->has('logo_caption') ? ' has-error' : '' }}">
            {!! Form::label('logo_caption', 'Légende & crédits') !!}
            {!! Form::text('logo_caption', null, ['class' => 'form-control', 'placeholder' => 'ex : Iconographie Frida Kahlo']) !!}
            <small class="text-danger">{{ $errors->first('logo_caption') }}</small>
        </div>
    @else
        <div class="row">
            <div class="col-md-4">
                <a href="#logoModal" data-toggle="modal" data-target="#logoModal">
                    <img src="{{ asset('uploads/thumb_' . $article->logo) }}" alt="{{ $article->title }}" class="img-thumbnail">
                </a>

                <!-- Modal -->
                <div class="modal fade" id="logoModal" tabindex="-1" role="dialog" aria-labelledby="logoModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="logoModalLabel">Logo actuel de l’article</h4>
                            </div>
                            <div class="modal-body">
                                <img src="{{ asset('uploads/' . $article->logo) }}" alt="{{ $article->title }}" class="img-responsive">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="form-group{{ $errors->has('logo') ? ' has-error' : '' }}">
                    <p class="help-block">Changer le logo actuel</p>
                    {!! Form::file('logo') !!}
                </div>
                <div class="form-group{{ $errors->has('logo_caption') ? ' has-error' : '' }}">
                    {!! Form::label('logo_caption', 'Légende & crédits') !!}
                    {!! Form::text('logo_caption', null, ['class' => 'form-control', 'placeholder' => 'ex : Iconographie Frida Kahlo']) !!}
                    <small class="text-danger">{{ $errors->first('logo_caption') }}</small>
                </div>
            </div>
        </div>
    @endif
    <small class="text-danger">{{ $errors->first('logo') }}</small>
</div>

<div class="form-group{{ $errors->has('tag_list') ? ' has-error' : '' }}">
    {!! Form::label('tag_list', 'Tags') !!}
    {!! Form::select('tag_list[]', $tags, null, ['id' => 'tag_list', 'class' => 'form-control', 'multiple']) !!}
    <small class="text-danger">{{ $errors->first('tag_list') }}</small>
</div>

@push('scripts')
    <script type="text/javascript">
        $('#issue_id').select2({
            allowClear: true,
        });

        $('#user_list').select2({
            placeholder: 'Ajouter un ou plusieurs auteur(s)',
            allowClear: true
        });

        $('#tag_list').select2({
            placeholder: 'Ajouter un ou plusieurs tags(s)',
            allowClear: true,
            tags: true
        });
    </script>
@endpush

@include('partials._forms-errors')