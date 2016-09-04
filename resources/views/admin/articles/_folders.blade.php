<h3>Dossiers</h3>

<ul class="nav nav-pills nav-stacked">
    <li role="presentation" class="{{ $active == 'index' ? 'active' : '' }}">
        <a href="{{ route('admin.article.index') }}">
            @icon('file-text-o') Tous les articles
        </a>
    </li>

    <li role="presentation" class="{{ $active == 'drafts' ? 'active' : '' }}">
        <a href="{{ route('admin.article.drafts') }}">
            @icon('file-o') Brouillons <span class="badge">{{ $draftsCount }}</span>
        </a>
    </li>

    <li role="presentation" class="{{ $active == 'trash' ? 'active' : '' }}">
        <a href="{{ route('admin.article.trash') }}">
            @icon('trash') Corbeille <span class="badge">{{ $trashArticlesCount }}</span>
        </a>
    </li>
</ul>
