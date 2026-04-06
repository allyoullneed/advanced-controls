<?php

return [
    /**
     * Component prefix.
     *
     * Run `php artisan view:clear` after changing this setting
     *
     *    prefix => 'advctrl-'
     *               <x-advctrl-button />
     *               <x-advctrl-card />
     */
    'prefix' => '',

    /**
     * Configuration of icons used throughout the package.
     */

    'icons' => 'heroicons',


    'icon-packages' => [
        'google-material-design' => [
            'info'          => 'gmdi-info-outline-r',
            'success'       => 'gmdi-check-circle-outline-r',
            'warning'       => 'gmdi-warning-amber-r',
            'error'         => 'gmdi-error-outline-r',

            'password-show' => 'gmdi-visibility-o',
            'password-hide' => 'gmdi-visibility-off-o',

            'rating'        => 'gmdi-star',
            'user'          => 'gmdi-person',
        ],
        'heroicons' => [
            'info'          => 'heroicon-o-information-circle',
            'success'       => 'heroicon-o-check-circle',
            'warning'       => 'heroicon-o-exclamation-triangle',
            'error'         => 'heroicon-o-x-circle',

            'password-show' => 'heroicon-o-eye',
            'password-hide' => 'heroicon-o-eye-slash',

            'rating'        => 'heroicon-s-star',
            'user'          => 'heroicon-s-user',
        ],
        'phosphor' => [
            'info'          => 'phosphor-info',
            'success'       => 'phosphor-check-circle',
            'warning'       => 'phosphor-warning',
            'error'         => 'phosphor-x-circle',

            'password-show' => 'phosphor-eye',
            'password-hide' => 'phosphor-eye-closed',

            'rating'        => 'phosphor-star-fill',
            'user'          => 'phosphor-user-fill',
        ],
    ],


    /**
     * Library include configuration for wrapper components.
     * Libraries can be loaded directly from the server or using a CDN.
     * 
     * If set to null, the library leaves you in charge of including the necessary scripts, usually in your layout, inside the <head>...</head> tags.
     * 
     * If you pick 'local', make sure to save a copy of the library into a path available with HTTP request, and change the local "cdn" configuration accordingly.
     * 
     * If you choose a CDN, the library will be restricted to a predefined major version to avoid breaking your website on update.
     * Different CDNs may or may not be 100% up-to-date and define the cache max age differently.
     * You must also make sure the content-security-policy of your website allows the chosen CDN to be accessed.
     */
    'include-from' => 'local',

    'cdn' => [
        'local' => [
            'chartjs' => '/chart.umd.min.js',
        ],
        /* Latest version available on cdnjs.cloudflare.com */
        'cdnjs' => [
            'chartjs' => 'https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.5.0/chart.min.js',
        ],
        /* Latest version available on jsdelivr */
         'jsdelivr' => [
            'chartjs' => 'https://cdn.jsdelivr.net/npm/chart.js@4.5.1/dist/chart.umd.min.js',
        ],
        /* Latest major version available on jsdelivr, i.e. your website will "auto-update" to new minor and patch versions, 
           but not to new major versions that could potentially break it. */
        'jsdelivr-major' => [
            'chartjs' => 'https://cdn.jsdelivr.net/npm/chart.js@4/dist/chart.umd.min.js',
        ],
    ]

];
