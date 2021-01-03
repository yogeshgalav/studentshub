<?php

return [

    /*
    |--------------------------------------------------------------------------
    | View Storage Paths
    |--------------------------------------------------------------------------
    |
    | Most templating systems load templates from disk. Here you may specify
    | an array of paths that should be checked for your views. Of course
    | the usual Laravel view path has already been registered for you.
    |
    */

    'paths' => [
        resource_path('views'),
    ],

    'theme' => [
        'color_background' => '#10069F',
        'color_foreground' => '#fff',
        'logo_url' => config('app.asset_url').'/images/actionable.png',
        'dark_logo_url' => config('app.asset_url').'/images/actionable1.png',
        'favicon_url' => config('app.asset_url').'/favicon.ico',
        'primary_button_background_color' => '#1f84c7',
        'primary_button_hover_background_color' => '#1572E8',
        'accent_color_background' => '#10069f',
        'accent_color_forground' => '#ffff',
        'alt_src' => 'Actionable',
        'hide_email_logo' => false,
        'is_white_labelled' => false,
        'menu_icon_color' => '#ffff',
    ],
    /*
    |--------------------------------------------------------------------------
    | Compiled View Path
    |--------------------------------------------------------------------------
    |
    | This option determines where all the compiled Blade templates will be
    | stored for your application. Typically, this is within the storage
    | directory. However, as usual, you are free to change this value.
    |
    */

    'compiled' => env(
        'VIEW_COMPILED_PATH',
        realpath(storage_path('framework/views'))
    ),

];
