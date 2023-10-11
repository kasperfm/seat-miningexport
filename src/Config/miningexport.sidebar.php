<?php

return [
    'miningexport' => [
        'name' => 'Export Mining',
        'icon' => 'fa fa-file-export',
        'route_segment' => 'miningexport',
        'permission' => ['miningexport.export'],
        'entries' => [
            [
                'name' => 'Export Corp Ledger',
                'icon' => 'fa fa-file-export',
                'route' => 'miningexport.index'
            ],
        ]
    ]
];