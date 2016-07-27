@servers(['vps' => env('ENVOY_PROD_SSH_CMD')])

@task('deploy', ['on' => 'vps'])
    cd {{ env('ENVOY_PROD_SSH_APP_PATH') }}

    @unless (empty($noBackup))
        php artisan backup:run
    @endunless

    php artisan down

    git pull origin master --force

    if [ -f composer.json ]; then
        composer install
    fi

    if [ -f package.json ]; then
        npm install
    fi

    if [ -f gulpfile.js ]; then
        gulp --production
    fi

    @unless (empty($migrate))
        php artisan migrate --force
    @endunless

    php artisan optimize
    php artisan cache:clear
    php artisan view:clear
    php artisan config:cache

    @unless (empty($queue))
        php artisan queue:restart
    @endunless

    php artisan up
@endtask
