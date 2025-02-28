<?php
Route::group(['middleware' => ['api', 'Locale', 'TransformNumbers'], 'prefix' => 'api'], function () {

});
