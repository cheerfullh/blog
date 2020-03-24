<?php

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



Route::group(['prefix' => 'admin','namespace'=>'Admin'], function () {
//后台登陆
    Route::get('login','LoginController@login');
//验证码
    Route::get('code','LoginController@code');
//表单登陆验证
    Route::post('store','LoginController@store');
});
Route::get('noaccess','Admin\LoginController@noaccess');
Route::middleware(['islogin','hasrole'])->group(function () {
    //后台登陆首页
    Route::get('admin/index','Admin\LoginController@index');
//后台欢迎页面
    Route::get('admin/welcome','Admin\LoginController@welcome');
//退出登陆
    Route::get('admin/logout','Admin\LoginController@logout');
//管理员路由
    Route::post('user/del','Admin\UserController@delAll');
    Route::resource('admin/user','Admin\UserController');
    //管理员角色路由
    Route::resource('admin/role','Admin\RoleController');
//管理员权限路由
    Route::resource('admin/permission','Admin\PermissionController');
//    分类路由
    Route::resource('admin/cate','Admin\CateController');
});

