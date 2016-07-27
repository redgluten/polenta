<div class="issue-infos">
    <a href="{{ route('issue.show', $issue->id) }}">
        <figure>
            <img src="{{ asset('uploads/' . $issue->cover) }}" class="cover">
        </figure>
    </a>
    <div class="issue-buttons">
        <a href="#" class="btn btn-default" data-toggle="modal" data-target="#mapModal"><i class="fa fa-map-marker"></i> Trouver</a>

        <!-- Map modal -->
        @include('issues._map')

        <!-- PDF buttons -->
        @unless (empty($issue->print_file))
        <a href="{{ url('uploads/' . $issue->print_file) }}" class="btn btn-default" target="_blank"><i class="fa fa-book"></i> Feuilleter</a>
        <a href="{{ url('uploads/' . $issue->print_file) }}" class="btn btn-default" target="_blank"><i class="fa fa-download"></i> Télécharger</a>
        @endunless
    </div>
</div>