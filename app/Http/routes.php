<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
use App\Http\UserAgent;

if( UserAgent::isMobile() ){
    //移动端
    Route::group([
        'namespace' => 'User'
    ], function () {

    });

}else{
    //pc端
    //服务
    Route::group([
        'namespace' => 'System'
    ], function () {
        Route::get('/ss', ['uses' => 'ServeController@ss', 'as' => 'ss']);#查看session
        Route::get('/info', ['uses' => 'ServeController@info', 'as' => 'info']);#phpinfo
        Route::get('/test', ['uses' => 'TestController@index', 'as' => 'test']);#test


    });
    //论坛
    Route::group([
        'namespace' => 'Forum'
    ], function () {
        Route::get('/', ['uses' => 'ForumBaseController@index', 'as' => 'forum']);#论坛首页
        Route::get('/forum', ['uses' => 'ForumBaseController@index', 'as' => 'forum-index']);#论坛首页
        Route::get('/about', ['uses' => 'ForumBaseController@about', 'as' => 'about']);#about
        Route::get('/talk', ['uses' => 'ForumBaseController@talk', 'as' => 'talk']);#帖子首页
        Route::get('/forum-{id}-{page}.html', ['uses' => 'ForumBaseController@ThreadList', 'as' => 'thread']);#帖子首页
        Route::get('/thread-{tid}-{page}.html', ['uses' => 'ThreadController@ViewThread', 'as' => 'thread']);#查看帖子
        Route::get('/new-thread', ['uses' => 'ThreadController@NewThreadView', 'as' => 'new-thread']);#帖子首页
        Route::post('/post-thread', ['uses' => 'ThreadController@StorePosts', 'as' => 'store-posts']);#存储发帖

    });
    //用户
    Route::group([
        'namespace' => 'User'
    ], function () {
        Route::get('/login', ['uses' => 'UserBaseController@LoginView', 'as' => 'login']);#登录
        Route::get('/logout', ['uses' => 'UserBaseController@LogOut', 'as' => 'LogOut']);#退出
        Route::get('/register', ['uses' => 'UserBaseController@Register', 'as' => 'registe']);#注册
        Route::post('/do-login', ['uses' => 'UserBaseController@DoLogin', 'as' => 'do-login']);#登录
        Route::get('/old-user', ['uses' => 'UserBaseController@OldUser', 'as' => 'OldUser']);#老账户寻回
    });
    //管理后台 IndexCp
    Route::group([
        'namespace' => 'Admincp',
        'middleware' => [
            'admin'
        ]
    ], function () {
        Route::get('/admincp', ['uses' => 'AdmincpController@IndexCp', 'as' => 'admin']);#管理后台首页

    });
}


