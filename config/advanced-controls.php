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
        'heroicons-outline' => [
            'info'          => 'heroicon-o-information-circle',
            'success'       => 'heroicon-o-check-circle',
            'warning'       => 'heroicon-o-exclamation-triangle',
            'error'         => 'heroicon-o-x-circle',

            'password-show' => 'heroicon-o-eye',
            'password-hide' => 'heroicon-o-eye-slash',

            'rating'        => 'heroicon-o-star',
            'user'          => 'heroicon-o-user',
        ],
        'heroicons-solid' => [
            'info'          => 'heroicon-s-information-circle',
            'success'       => 'heroicon-s-check-circle',
            'warning'       => 'heroicon-s-exclamation-triangle',
            'error'         => 'heroicon-s-x-circle',

            'password-show' => 'heroicon-s-eye',
            'password-hide' => 'heroicon-s-eye-slash',

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
     * If set to null, you are left in charge of including the necessary scripts, usually in your layout.
     * Otherwise, the necessary scripts will be included automatically by the components, depending on the chosen option.
     * 
     * If you pick 'local', make sure to save a copy of the library into a path available with HTTP request, and change the local "cdn" configuration accordingly.
     * 
     * If you choose a CDN, the library will be restricted to a predefined major version to avoid breaking your website on update.
     * You will need to make sure the content-security-policy of your website allows the chosen CDN to be accessed.
     */
    'include-from' => 'jsdelivr',

    'cdn' => [
        'local' => [
            'chartjs' => public_path('chart.umd.min.js'),
        ],
        /* Latest version available on cdnjs.cloudflare.com */
        'cdnjs' => [
            'chartjs' => 'https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.5.0/chart.umd.min.js',
        ],
        /* Latest version available on jsdelivr */
         'jsdelivr' => [
            'chartjs' => 'https://cdn.jsdelivr.net/npm/chart.js@4.5.1/dist/chart.umd.min.js',
        ],
        /* Latest major version available on jsdelivr, i.e. your website will "auto-update" to new minor and patch versions, 
           but not to new major versions that could potentially break it.
           This "auto-update" feature triggers once a week when the cache expires.

           The cost of this feature is:
            - Your users will download a fresh version of the library more frequently, typically once a week (to be compared to once a year for the other CDNs).
            - The "update" may take place earlier for users that visit your website for the first time, as they may not not have a cached version of the libraries yet.*/
        'jsdelivr-major' => [
            'chartjs' => 'https://cdn.jsdelivr.net/npm/chart.js@4/dist/chart.umd.min.js',
        ],
    ]

];
