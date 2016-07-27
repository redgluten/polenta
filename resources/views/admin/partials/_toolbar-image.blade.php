<div class="modal fade" id="upload-modal-{{ $id }}" tabindex="-1" role="dialog" aria-labelledby="upload-modal-label">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Fermer"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="upload-modal-label">Ajouter une image</h4>
            </div>

            {!! Form::open(['class' => 'form-horizontal', 'id' => 'form-image-picker-' . $id, 'files' => true]) !!}

                <div class="modal-body">
                    <div class="form-group @if($errors->first('image')) has-error @endif">
                        {!! Form::label('image', 'Image', ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-9">
                            {!! Form::file('image', ['required' => 'required']) !!}
                            <small class="text-danger">{{ $errors->first('image') }}</small>
                        </div>
                    </div>

                    <div class="form-group @if($errors->first('position')) has-error @endif">
                        {!! Form::label('position', 'Position', ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-9">
                            {!! Form::select(
                                'position',
                                ['left' => 'Gauche', 'right' => 'Droite', 'center' => 'Centre'],
                                null,
                                ['id' => 'position', 'class' => 'form-control', 'required' => 'required']
                            ) !!}
                            <small class="text-danger">{{ $errors->first('position') }}</small>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-success">
                        <span aria-hidden="true"><i class="fa fa-upload"></i></span>
                        Envoyer
                    </button>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
