<?php

use Monolikit\Monolikit;

return [
    /*
    |--------------------------------------------------------------------------
    | Default root view
    |--------------------------------------------------------------------------
    */
    'root_view' => Monolikit::DEFAULT_ROOT_VIEW,

    /*
    |--------------------------------------------------------------------------
    | Force case
    |--------------------------------------------------------------------------
    | The convention for array properties in PHP is usually `snake_case`.
    | The convention for component properties in Vue is `camelCase`.
    | For this reason, you can force the case used for properties.
    |
    | Supported: null, 'snake', 'camel'
    */
    'force_case' => [
        'input' => 'snake',
        'output' => 'camel',
    ],

    /*
    |--------------------------------------------------------------------------
    | i18n
    |--------------------------------------------------------------------------
    | You can chose where the generated internationalization JSON file
    | will be written to using this option. To generate that file,
    | you may use the `i18n:generate` artisan command.
    */
    'i18n_path' => resource_path('application/i18n.json'),
];
