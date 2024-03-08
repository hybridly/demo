<?php

use Hybridly\Hybridly;
use Hybridly\Support\Configuration\Architecture;

return [
    /*
    |--------------------------------------------------------------------------
    | Default root view
    |--------------------------------------------------------------------------
    */
    'root_view' => Architecture::ROOT_VIEW,

    /*
    |--------------------------------------------------------------------------
    | Route filters
    |--------------------------------------------------------------------------
    | By default, the router does not pick vendor routes. You may change
    | that by specifying a vendor name in `router.allowed_vendors`.
    | You may also exclude routes by adding rules in `exclude`.
    */
    'router' => [
        'allowed_vendors' => [],
        'exclude' => [],
    ],

    /*
    |--------------------------------------------------------------------------
    | Architecture
    |--------------------------------------------------------------------------
    | Hybridly has presets for a default, one-level architecture, as well
    | as a module-based architecture. Optionally, you may disable the
    | presets altogether and define your own architecture.
    |
    | See: https://hybridly.dev/guide/architecture.html
    */
    'architecture' => [
        'preset' => 'default',
        'root' => 'resources',
        'application' => 'resources/application/main.ts',
        'eager_load_views' => true,
    ],

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
    'i18n' => [
        'file_name_template' => '{locale}.json',
        'file_name' => 'locales.json',
    ],

    /*
    |--------------------------------------------------------------------------
    | Testing
    |--------------------------------------------------------------------------
    | The values described here are used to locate hybrid views on the
    | filesystem. For instance, when using `assertHybrid`, the assertion
    | attempts to locate the view as a file relative to any of the
    | paths AND with any of the extensions specified here.
    */
    'testing' => [
        'ensure_pages_exist' => true,
        'view_finder' => null,
        'page_paths' => [
            resource_path('pages'),
        ],
        'page_extensions' => [
            'ts',
            'tsx',
            'vue',
        ],
    ],
];
