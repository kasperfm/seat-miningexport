<?php

return [
    'miningexport' => [
        'name' => 'Export Mining',
        'icon' => 'fa fa-file-export',
        'route_segment' => 'miningexport',
        'permission' => ['miningexport.export'],
        'entries' => [
            'export' => [
                'name' => 'Export Data',
                'icon' => 'fa fa-file-export',
                'route' => 'miningexport.index',
                'permission' => ['miningexport.export']
            ],
            'settings' => [
                'name' => 'Tax Settings',
                'icon' => 'fa fa-cog',
                'route' => 'miningexport.settings',
                'permission' => ['miningexport.settings']
            ],
        ],
    ]
];