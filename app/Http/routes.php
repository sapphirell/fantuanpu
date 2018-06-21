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

//if( UserAgent::isMobile() ){
//    //移动端
//    Route::get('/', function () {
//        return '移动端界面还未写好…';
//    });
//    //移动端
//    Route::group([
//        'namespace' => 'User'
//    ], function () {
//
//    });
//
//}else{
    //pc端
    //服务
    Route::group([
        'namespace' => 'System'
    ], function () {
        Route::get('/ss', ['uses' => 'ServeController@ss', 'as' => 'ss']);#查看session
        Route::get('/info', ['uses' => 'ServeController@info', 'as' => 'info']);#phpinfo
        Route::get('/test', ['uses' => 'TestController@index', 'as' => 'test']);#test
        Route::get('/ping', ['uses' => 'TestController@ping', 'as' => 'test']);#test


    });
    //论坛
    Route::group([
        'namespace' => 'Forum'
    ], function () {
        Route::get('/', ['uses' => 'ForumBaseController@index', 'as' => 'forum']);#论坛首页
        Route::get('/forum.php', ['uses' => 'ForumBaseController@index', 'as' => 'forum-index']);#论坛首页
        Route::get('/forum', ['uses' => 'ForumBaseController@index', 'as' => 'forum-index']);#论坛首页
        Route::get('/about', ['uses' => 'ForumBaseController@index', 'as' => 'about']);#about
        Route::get('/talk', ['uses' => 'ForumBaseController@talk', 'as' => 'talk']);#帖子首页
        Route::get('/notice', ['uses' => 'ForumBaseController@notice', 'as' => 'notice']);#声明
        Route::post('/dopost-notice', ['uses' => 'ForumBaseController@save_notice', 'as' => 'do-notice']);#声明
        Route::get('/forum-{id}-{page}.html', ['uses' => 'ForumBaseController@ThreadList', 'as' => 'thread']);#帖子首页

        /**
         *@param tid int 帖子标题id
         *@param page int 帖子页数
         *@return App\Http\Controllers\Forum\ThreadController
         */
        Route::get('/thread-{tid}-{page}.html', ['uses' => 'ThreadController@viewThread', 'as' => 'thread']);#查看帖子
        Route::post('/new-thread', ['uses' => 'ThreadApiController@NewThread', 'as' => 'new-thread']);#发新帖
        Route::post('/post-thread', ['uses' => 'ThreadApiController@PostsThread', 'as' => 'store-posts']);#回帖
        Route::get('/webim', ['uses' => 'ForumBaseController@webim', 'as' => 'webim']);#webim即时聊天

    });
    //用户
    Route::group([
        'namespace' => 'User'
    ], function () {
        Route::get('/login', ['uses' => 'UserBaseController@LoginView', 'as' => 'login']);#登录
        Route::get('/logout', ['uses' => 'UserBaseController@LogOut', 'as' => 'LogOut']);#退出
        Route::get('/register', ['uses' => 'UserBaseController@Register', 'as' => 'register']);#注册
        Route::post('/do-reg', ['uses' => 'UserBaseController@DoRegister', 'as' => 'DoRegister']);#do注册
        Route::post('/do-login', ['uses' => 'UserBaseController@DoLogin', 'as' => 'do-login']);#登录
        Route::get('/old-user', ['uses' => 'UserBaseController@OldUser', 'as' => 'OldUser']);#老账户寻回
        Route::get('/get-email', ['uses' => 'UserBaseController@GetAccountByEmail', 'as' => 'GetAccountByEmail']);#根据邮箱找回账户
        Route::post('/get-email', ['uses' => 'UserBaseController@RetrieveMail', 'as' => 'RetrieveMail']);#根据邮箱找回账户,发送邮件
        Route::get('/new-password', ['uses' => 'UserBaseController@ResetPassword', 'as' => 'ResetPassword']);#修改密码,根据验证邮件
        Route::post('/do-repassword', ['uses' => 'UserBaseController@DoResetPassword', 'as' => 'DoResetPassword']);#post修改密码
        Route::post('/do-checkUsername', ['uses' => 'UserBaseController@checkUsername', 'as' => 'checkUsername']);#用户名是否被注册
        Route::post('/do-checkEmail', ['uses' => 'UserBaseController@checkEmail', 'as' => 'checkEmail']);#emial是否被注册
        Route::get('/live2d', ['uses' => 'UserBaseController@live2d', 'as' => 'live2d']);#live2d 测试
    });
    //用户-必须登录的
    Route::group([
        'namespace' => 'User',
        'middleware' => [
            'need.login'
        ]
    ], function () {
        Route::get('/user-center', ['uses' => 'UserBaseController@UserCenter', 'as' => 'UserCenter']);#用户中心
        Route::post('/uc-do-upload-avatar', 'UserBaseController@DoUploadAvatar');#修改头像
        Route::get('/get_my_message', 'UserBaseController@get_my_message');#获取我的消息
    });
    //管理后台 IndexCp
    Route::group([
        'namespace' => 'Admincp',
        'middleware' => [
            'admin'
        ]
    ], function () {
        Route::get('/admincp/', ['uses' => 'AdmincpController@IndexCp', 'as' => 'admin']);#管理后台首页
        Route::get('/admincp/user_manager', ['uses' => 'AdmincpController@userManager', 'as' => 'userManager']);#用户管理面板
        Route::get('/admincp/user-edit', ['uses' => 'AdmincpController@userEdit', 'as' => 'userManager']);#用户管理面板

    });
    //App 接口
    Route::group([
        'namespace' => 'App',
//        'middleware' => [
//            'app'
//        ]
    ],function () {
        Route::get('/app/test', ['uses' => 'UserController@test', 'as' => 'app-user-test']);#app测试
    });
//}


