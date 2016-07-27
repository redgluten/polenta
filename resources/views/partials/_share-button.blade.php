@push('messages')
    <div id="clippy-confirmation" class="alert alert-success alert-dismissible" style="display: none" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        Fantastique ! L’adresse de la page est copiée dans votre presse-papiers. 👍
    </div>

    <div id="clippy-error" class="alert alert-warning alert-dismissible" style="display: none" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        Appuyez sur Ctrl + C ou ⌘ + C pour copier l’adresse.
    </div>
@endpush

<a tabindex="0" href="#" id="clipboard" class="clipboard" data-clipboard-text="{{ $url }}">
    <i class="fa fa-share-alt" aria-hidden="true"></i> Partager
</a>

@push('scripts')
    <script type="text/javascript">
        var clipboard = new Clipboard('#clipboard');

        clipboard.on('success', function(e) {
            $('#clippy-confirmation').show(400);
            e.clearSelection();
        });

        clipboard.on('error', function(e) {
            $('#clippy-error').show(400);
        });
    </script>
@endpush
