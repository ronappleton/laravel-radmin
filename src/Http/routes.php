<?php

Route::group(['prefix' => 'admin', 'middleware' => ['web']], function () {
    Route::get('/', function () {
        return view('admin.dashboard');
    });
});