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


];
