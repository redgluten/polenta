<div class="row issue">
    <div class="col-sm-4">
        @include('issues._info')
    </div>

    <div class="col-sm-8">
        <h3 class="subtitle">Éditorial</h3>

        <div class="editorial">
            <h1>{{ $issue->editorial_title }}</h1>

            <div class="content">
                @if (strlen($issue->editorial_content) < 1400)
                    {!! $issue->editorial_content !!}
                @else
                    {!! str_limit($issue->editorial_content, 1400) !!}
                    <a href="{{ route('issue.edito', $issue->id) }}">Lire la suite @icon('arrow-right')</a>
                @endif
            </div>
        </div>
    </div>
</div>

<hr>

<div class="row articles-grid">
    <div class="col-md-12">
        <h3 class="subtitle">Les articles</h3>
    </div>

    @each ('articles._presentation-grid', $issue->articles, 'article')
</div>
