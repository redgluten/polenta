<h3>Dossiers</h3>

<ul class="nav nav-pills nav-stacked">
    <li role="presentation" class="{{ $active == 'index' ? 'active' : '' }}">
        <a href="{{ route('admin.article.index') }}">
            <i class="fa fa-file-text-o" aria-hidden="true"></i> Tous les articles
        </a>
    </li>

    <li role="presentation" class="{{ $active == 'drafts' ? 'active' : '' }}">
        <a href="{{ route('admin.article.drafts') }}">
            <i class="fa fa-file-o" aria-hidden="true"></i> Brouillons <span class="badge">{{ $draftsCount }}</span>
        </a>
    </li>

    <li role="presentation" class="{{ $active == 'trash' ? 'active' : '' }}">
        <a href="{{ route('admin.article.trash') }}">
            <i class="fa fa-trash" aria-hidden="true"></i> Corbeille <span class="badge">{{ $trashArticlesCount }}</span>
        </a>
    </li>
</ul>
