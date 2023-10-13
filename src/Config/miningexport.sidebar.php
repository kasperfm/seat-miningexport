<?php

return [
    'miningexport' => [
        'name' => 'Export Mining',
        'icon' => 'fa fa-file-export',
        'route_segment' => 'miningexport',
        'permission' => ['miningexport.export'],
        'route' => 'miningexport.index'
    ]
];