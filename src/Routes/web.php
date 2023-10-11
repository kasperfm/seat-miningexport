<?php
    Route::group([
        'namespace' => 'KasperFM\Seat\MiningExport\Http\Controllers',
        'prefix' => 'miningexport',
        'middleware' => ['web', 'auth']
    ], function () {
        Route::get('/', [
            'as' => 'miningexport.index',
            'uses' => 'ExportController@index'
        ]);

        Route::get('/generate', [
            'as' => 'miningexport.generate',
            'uses' => 'ExportController@generateOutput'
        ]);
    });