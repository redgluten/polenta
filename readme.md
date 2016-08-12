Polenta
=======

## Instructions d’installation

1. `cd polenta`
2. Installer les dépendances _back-end_ : `composer install`
3. Installer les dépendances _front-end_ : `npm install`
4. Produire les éléments _front-end_: `gulp` (Ajouter l’option `--production`  en prod)
5. Copier `.env.example` vers `.env` et remplir la configuration


## Outils de projet

- Versioning : [Git](http://git-scm.com)
- Cohérence du style de code : [Editor config](http://editorconfig.org)
- Déploiement : [Laravel Envoy](https://laravel.com/docs/5.2/envoy)
- Base de données : [MySQL](https://www.mysql.com)

## Dépendances

### Back-end

> **Note :** [Composer](https://getcomposer.org) est utilisé pour la gestion des dépendances PHP. La liste complète des dépendances doit donc se trouver dans le fichier `/.composer.json` à la racine du projet. La liste suivante devrait cependant être tenue à jour pour rappeler l’utilité de chacune d’entre elles et fournir un lien vers son éventuelle documentation.

- Framework back-end : [Laravel 5.2](http://laravel.com), [Documentation](http://laravel.com/docs/5.2)
- [Doctrine/DBAL](https://github.com/doctrine/dbal) est nécessaire pour modifier les colonnes MySQL
- [Laravel Collective HTML & Forms](http://laravelcollective.com/docs/5.2/html) pour la gestion des formulaires
- [Laravel Exceptions](https://github.com/GrahamCampbell/Laravel-Exceptions) améliore la gestion des erreurs 
- [Intervention Image](https://github.com/Intervention/image) gestion des images
- [Laravel Tagging](https://github.com/rtconner/laravel-tagging) gestion des tags
- [Mews Purifier](https://github.com/mewebstudio/Purifier) pour le nettoyage du code HTML dans les champs de formulaires
- [Laravel Feed](https://github.com/spatie/laravel-feed) flux RSS
- [Color Thief PHP](https://github.com/ksubileau/color-thief-php) permet d’extraire une couleur dominante d’une image
- [PHP Colors](https://github.com/mexitek/phpColors) petite librairie de manipulations des couleurs en PHP
- [Laravel Backup](https://github.com/spatie/laravel-backup)

#### Dev-only
- [Laravel debugbar](https://github.com/barryvdh/laravel-debugbar)
 

### Front-end

> **Note :** [NPM](https://www.npmjs.com) est utilisé pour la gestion des dépendances front-end. La liste complète des dépendances doit donc se trouver dans le fichier `/.package.json` à la racine du projet. La liste suivante devrait cependant être tenue à jour pour rappeler l’utilité de chacune d’entre elles et fournir un lien vers son éventuelle documentation.

- [Elixir](http://laravel.com/docs/5.1/elixir) qui est une surcouche de [Gulp](http://gulpjs.com) est utilisé pour traiter les assets CSS, JS et autres, notamment :
    - Le code CSS est généré à l’aide de [Sass](http://sass-lang.com) et d’Autoprefixer, concaténé et minifié le cas échéant
    - Le code JS est testé avec JSHint, concaténé et minifié le cas échéant
- [Bootstrap 3](http://getbootstrap.com) Framework CSS, version Sass
- [Select2](https://github.com/select2/select2) améliore les `<select>`
- [wysihtml](https://github.com/Voog/wysihtml) éditeur HTML
- [Font Awesome](http://fontawesome.io) icônes d’interface
- [Clipboard.js](https://clipboardjs.com) pour copier vers le presse-papier
- [Slick](https://github.com/kenwheeler/slick/) carousel

#### Fontes

La super-famille de fontes __Alegreya__ est utilisée dans ses variantes _open-source_ en cohérence avec les choix opérés pour la version papier du magazine, se reporter aux descriptions des familles concernant les versions commerciales pour plus d’informations sur l’approche générale de celles-ci :
- [Sans-serif](http://www.huertatipografica.com/en/fonts/alegreya-sans-ht)
- [Serif](http://www.huertatipografica.com/en/fonts/alegreya-ht-pro)

Les dépôts des versions open-sources utilisés ici :
- [Sans-serif](https://github.com/huertatipografica/Alegreya-Sans)
- [Serif](https://github.com/huertatipografica/Alegreya-libre)


---


## Authentication

On utilise l’authentification proposée de base par Laravel, en supprimant la possibilité de s’inscrire.


## Utilisation de WYSIHTML

Les fonctions de base sont assez simples à mettre en œuvre : se référer à la documentation en ligne du plugin référencée plus haut. Elles sont ici implémentées à l’aide d’un partial de vue (`_toolbar`) qui contient les différents boutons de l’éditeur.

Un fichier `editor.css` avec les styles nécessaires est généré pour que les modifications soient visibles dans l’éditeur lui-même, il est à renseigner dans l’activation de chaque éditeur. Voir exemple plus bas.

Pour activer un éditeur il faut inclure le partial de vue `_toolbar` juste au dessus du champ textarea en lui passant l’`id` de celui-ci et activer l’éditeur à l’aide des fonctions prévues par le plugin. 

L’upload d’image est géré différemment des autres éléments qui se contentent d’utiliser les fonctions natives du plugin : il faut préciser au partial de vue `_toolbar` que l’on souhaite utiliser une image en lui passant une variable `image` à `true` et inclure en fin de vue le partial de vue contenant la modal Boostrap permettant l’upload d’images pour chaque éditeur.


Exemple :

```php
<!-- toolbar with suitable buttons and dialogues -->
@include('admin/partials/_toolbar', ['id' => 'content-toolbar', 'image' => true])
<textarea id="content" class="form-control" required>
    {!! $page->content or null !!}
</textarea>

...


@section('modals')
    @include('partials/_toolbar-image-modal', ['id' => 'content-toolbar'])
@stop
```

_Attention_ : Le `form-model binding` de Laravel Collective ne fonctionne pas avec cet outil, d’où la nécessité de recourir à un tag HTML traditionnel pour utiliser le même formulaire dans la création et l’édition.

```javascript
// activate wysihtml editors
var editor = new wysihtml5.Editor(content, {
    toolbar: 'content-toolbar',
    stylesheets: '{{ asset('css/editor.css') }}',
    parserRules:  wysihtml5ParserRules,
});
// Insert image
$('#form-image-picker-content-toolbar').on('submit', function(event) {
    uploadImage('/admin/pages/upload-image', event, editor, $(this));
});
```
