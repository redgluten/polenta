<?php $id = empty($id) ? rand() : $id; ?>

<!-- Button trigger delete modal -->
<a id="modal-delete-{{ $id }}" class="{{ $class or 'btn btn-danger remove' }}" data-toggle="modal" data-target="#delete-modal-{{ $id }}">
    <i class="fa fa-trash"></i> <span class="sr-only">Supprimer</span>
</a>

<div class="modal fade" id="delete-modal-{{ $id }}" tabindex="-1" role="dialog" aria-labelledby="delete-modal-label">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Fermer"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="delete-modal-label">Confirmation de la suppression</h4>
            </div>

            <div class="modal-body">
                <p>{{ $text }}</p>
            </div>

            <div class="modal-footer">
                {!! Form::open(['url' => $url]) !!}
                    {!! Form::hidden('_method', 'DELETE') !!}
                    <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                    <button type="submit" name="delete-resource-{{ $id }}" class="btn btn-danger">
                        <span aria-hidden="true"><i class="fa fa-remove"></i></span>
                        Supprimer
                    </button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
