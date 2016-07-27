<div class="issue">
    <a href="{{ route('issue.show', $issue->id) }}">
        <figure>
            <img src="{{ asset('uploads/' . $issue->cover) }}">
        </figure>
    </a>
    <h2 class="title">
        <a href="{{ route('issue.show', $issue->id) }}">{{ ucfirst($issue->title) }}</a>
    </h2>
</div>
