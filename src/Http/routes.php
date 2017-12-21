<?php

Route::group(['prefix' => 'admin', 'middleware' => ['web', 'radmin', 'role:superadmin', 'role:admin']], function () {
    Route::get('/', function () {
        return view('radmin::dashboard');
    });

    // Authentication Routes...
    Route::get('login', [
        'as' => 'admin.login',
        'uses' => 'RonAppleton\Radmin\Http\Controllers\Auth\LoginController@showLoginForm'
    ]);
    Route::post('login', [
        'as' => '',
        'uses' => 'RonAppleton\Radmin\Http\Controllers\Auth\LoginController@login'
    ]);
    Route::post('logout', [
        'as' => 'admin.logout',
        'uses' => 'RonAppleton\Radmin\Http\Controllers\Auth\LoginController@logout'
    ]);

// Password Reset Routes...
    Route::post('password/email', [
        'as' => 'admin.password.email',
        'uses' => 'RonAppleton\Radmin\Http\Controllers\Auth\ForgotPasswordController@sendResetLinkEmail'
    ]);
    Route::get('password/reset', [
        'as' => 'admin.password.request',
        'uses' => 'RonAppleton\Radmin\Http\Controllers\Auth\ForgotPasswordController@showLinkRequestForm'
    ]);
    Route::post('password/reset', [
        'as' => '',
        'uses' => 'RonAppleton\Radmin\Http\Controllers\Auth\ResetPasswordController@reset'
    ]);
    Route::get('password/reset/{token}', [
        'as' => 'admin.password.reset',
        'uses' => 'RonAppleton\Radmin\Http\Controllers\Auth\ResetPasswordController@showResetForm'
    ]);
});