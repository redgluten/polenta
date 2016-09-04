<div class="issue-infos">
    <a href="{{ route('issue.show', $issue->id) }}">
        <figure>
            <img src="{{ asset('uploads/' . $issue->cover) }}" class="cover">
        </figure>
    </a>
    <div class="issue-buttons">
        <a href="#" class="btn btn-default" data-toggle="modal" data-target="#mapModal">@icon('map-marker') Trouver</a>

        <!-- Map modal -->
        @include('issues._map')

        <!-- PDF buttons -->
        @unless (empty($issue->print_file))
        <a href="{{ url('uploads/' . $issue->print_file) }}" class="btn btn-default" target="_blank">@icon('book') Feuilleter</a>
        <a href="{{ url('uploads/' . $issue->print_file) }}" class="btn btn-default" target="_blank">@icon('download') Télécharger</a>
        @endunless
    </div>
</div>