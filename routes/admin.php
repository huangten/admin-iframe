<?php

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
*/

Route::group(['middleware' => ['auth:admin']], function () {
    Route::get('/', ['uses'=>'IndexController@index', 'as'=>'admin']);

    Route::get('home', ['uses'=>'IndexController@home', 'as'=>'admin.index.home']);

    Route::resource('permission', 'PermissionsController', ['except'=>'show'])->names('admin.permission');

    Route::resource('role', 'RolesController', ['except'=>'show'])->names('admin.role');

    Route::get('user/check', ['uses'=>'UsersController@checkAdmin', 'as'=>'admin.user.check']);
    Route::resource('user', 'UsersController', ['except'=>'show'])->names('admin.user');

    Route::get('wechat/check', ['uses'=>'WechatController@checkWechat', 'as'=>'admin.wechat.check']);
    Route::get('wechat/search', ['uses'=>'WechatController@search', 'as'=>'admin.wechat.search']);
    Route::resource('wechat', 'WechatController')->names('admin.wechat');

    Route::get('wechat_users', ['uses'=>'WechatUsersController@index', 'as'=>'admin.wechat_users.index']);
});
Route::get('login', ['uses'=>'AuthController@showLoginForm', 'as'=>'admin.login', 'middleware'=>['guest:admin']]);
Route::post('login', ['uses'=>'AuthController@login', 'as'=>'admin.doLogin']);

Route::post('profile', ['uses'=>'AuthController@profile', 'as'=>'admin.profile', 'middleware'=>['auth:admin']]);
Route::get('logout', ['uses'=>'AuthController@logout', 'as'=>'admin.logout', 'middleware'=>['auth:admin']]);
