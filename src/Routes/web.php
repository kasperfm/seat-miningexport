<?php
    Route::group([
        'namespace' => 'KasperFM\Seat\MiningExport\Http\Controllers',
        'prefix' => 'miningexport',
        'middleware' => ['web', 'auth', 'can:miningexport.export']
    ], function () {
        Route::get('/', [
            'as' => 'miningexport.index',
            'uses' => 'ExportController@index'
        ]);

        Route::get('/taxsettings', [
            'as' => 'miningexport.settings',
            'uses' => 'ExportController@taxSettings',
            'middleware' => 'can:miningexport.settings'
        ]);

        Route::post('/taxsettings/save', [
            'as' => 'miningexport.settings.save',
            'uses' => 'ExportController@saveTaxSettings',
            'middleware' => 'can:miningexport.settings'
        ]);

        Route::get('/generate', [
            'as' => 'miningexport.generate',
            'uses' => 'ExportController@requestToGenerate'
        ]);

        Route::get('/taxgenerate', [
            'as' => 'miningexport.taxgenerate',
            'uses' => 'ExportController@requestToGenerateTaxReport'
        ]);
    });