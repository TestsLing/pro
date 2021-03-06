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

Route::group(['namespace' => 'Product'], function () {
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
});



Route::group(['namespace' => 'Tag'], function () {
    // 获取平台下所有标签
    Route::post('tag/list', 'TagController@all');

    // 创建特色标签
    Route::post('product/tag/style/create', 'TagController@create');

    // 获取特色标签列表
    Route::post('product/tag/style/list', 'TagController@list');

    // 修改标签
    Route::post('product/tag/style/edit', 'TagController@edit');

    // 删除标签
    Route::post('product/tag/style/delete', 'TagController@delete');

    // 禁用标签
    Route::post('product/tag/style/prohibit', 'TagController@prohibit');

});


Route::group(['namespace' => 'Letter'], function () {
    // 给用户留言
    Route::post('leave_message', 'LetterController@leaveMessage');

    // 获取用户留言列表
    Route::post('user/leave_message/list', 'LetterController@list');

    // 获取用户留言详情
    Route::post('user/leave_message/detail', 'LetterController@detail');

    // 删除单个留言
    Route::post('user/leave_message/delete', 'LetterController@delete');

    // 一键已读所有留言
    Route::post('user/leave_message/read', 'LetterController@readAllMessage');

});


Route::group(['namespace' => 'Upload'], function () {
    // 获取七牛云Token
    Route::post('upload/get/qn_token', 'QiNiuYun\QiNiuYunController@getQiNiuYunToken');

    // 获取阿里云上传参数
    Route::post('upload/get/ali_policy', 'AliOss\AliOssController@getAliOSSPolicy');
});