<!-- Map modal -->
<div class="modal fade" id="mapModal" tabindex="-1" role="dialog" aria-labelledby="mapModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="mapModalLabel">Où trouver Polenta</h4>
            </div>
            <div class="modal-body">
                <p class="text-center"><i>Polenta&#xA0;!</i> est aussi consultable dans les médiathèques et bibliothèques municipales de Chambéry, La-Motte-Servolex et Voglans. Et également à l’Accorderie, 305 rue du Bertillet, à Chambéry-le-Haut. Allez-y voir&#xA0;!</p>

                @include('partials._map')
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script type="text/javascript">
    $('#mapModal').on('shown.bs.modal', function () {
        loadMap();
    });
</script>
@endpush
