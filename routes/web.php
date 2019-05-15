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

Route::get('/', function () {
    return view('welcome');
});


// 添加产品
Route::post('product/create', 'ProductController@create');

// 获取产品详情
Route::post('product/detail', 'ProductController@detail');

// 获取产品列表
Route::post('product/list', 'ProductController@list');

// 删除产品
Route::post('product/delete', 'ProductController@delete');

// 修改产品
Route::post('product/edit', 'ProductController@edit');

// 获取用户下的所有产品
Route::post('user/product/list', 'RelUserProductController@list');

// 获取平台下所有标签
Route::post('tag/list', 'TagController@all');


// 创建特色标签
Route::post('product/tag/style/create', 'TagController@create');

// 获取特色标签列表
Route::post('product/tag/style/list', 'TagController@list');

