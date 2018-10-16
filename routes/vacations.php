<?php

use Humanity\Api\V1\Controllers\VacationController;

$api = app('Dingo\Api\Routing\Router');

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

$api->version('v1', function ($api) {
    $api->group([
        'middleware' => ['api', 'auth'],
        'prefix'     => 'vacations',
        'as'         => 'vacations'
    ], function ($api) {
        $api->post('', VacationController::class . '@create')
            ->name('create-vacation')
            ->middleware('permission:create-vacation');

        $api->put('{id}', VacationController::class . '@update')
            ->name('update-vacation')
            ->middleware('permission:update-vacation');

        $api->put('/approve/{id}', VacationController::class . '@approve')
            ->name('approve-vacation')
            ->middleware('permission:approve-vacation');

        $api->put('/disapprove/{id}', VacationController::class . '@disapprove')
            ->name('disapprove-vacation')
            ->middleware('permission:disapprove-vacation');

        $api->get('', VacationController::class . '@index')
            ->name('index-vacation')
            ->middleware('permission:index-vacation');

        $api->get('total', VacationController::class . '@total')
            ->name('index-vacation')
            ->middleware('permission:index-vacation');

        $api->get('{id}', VacationController::class . '@show')
            ->name('show-vacation')
            ->middleware('permission:index-vacation');
    });
});
