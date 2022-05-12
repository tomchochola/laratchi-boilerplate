<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

resolveRouter()->get('api/v1/spec', Tomchochola\Laratchi\Swagger\Http\Controllers\SwaggerUiController::class)->defaults('file', resolveApp()->basePath('docs/openapi_v1.json'))->name('api.v1.spec');
