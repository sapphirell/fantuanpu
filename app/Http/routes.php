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

//App 接口(必须获取token的)
Route::group([
    'namespace' => 'App',
    'middleware' => [
        'app'
    ]
],function () {
    Route::get('/app/test', ['uses' => 'UserController@test', 'as' => 'app-user-test']);#app测试
    Route::post('/app/user_center', ['uses' => 'UserController@user_center', 'as' => 'app-user-test']);#用户中心数据
    Route::post('/app/user_friends', ['uses' => 'UserController@user_friends', 'as' => 'app-user_friends']);#user_friends
    Route::post('/app/new_thread', ['uses' => 'ForumController@new_thread', 'as' => 'new_thread']);#app发新帖
    Route::post('/app/reply_thread', ['uses' => 'ForumController@reply_thread', 'as' => 'reply_thread']);#app回复帖子
    Route::post('/app/get_notice', ['uses' => 'ForumController@get_notice', 'as' => 'get_notice']);#获取消息列表
    Route::post('/app/read_letter', ['uses' => 'UserController@read_letter', 'as' => 'read_letter']);#阅读消息

    Route::post('/app/send_letter', ['uses' => 'UserController@send_letter', 'as' => 'send_letter']);#发送私信
    Route::post('/app/user_view', ['uses' => 'UserController@user_view', 'as' => 'user_view']);#其它用户主页
    Route::post('/app/get_my_thread', ['uses' => 'UserController@get_my_thread', 'as' => 'get_my_thread']);#我发的帖子
    Route::post('/app/add_my_like', ['uses' => 'UserController@add_my_like', 'as' => 'add_my_like']);#添加我喜欢的帖子
    Route::post('/app/show_my_like', ['uses' => 'UserController@show_my_like', 'as' => 'show_my_like']);#显示我喜欢的帖子


});
//App 接口(非token)
Route::group([
    'namespace' => 'App',
],function () {
    Route::post('/app/forum_list', ['uses' => 'ForumController@forum_list', 'as' => 'forum_list']);#板块列表
    Route::post('/app/look_look', ['uses' => 'ForumController@look_look', 'as' => 'look_look']);#随便看看
    Route::post('/app/view_thread', ['uses' => 'ForumController@viewThread', 'as' => 'view_thread']);#查看帖子
    Route::post('/app/post_next_page', ['uses' => 'ForumController@post_next_page', 'as' => 'post_next_page']);#看下一页帖子
    Route::post('/app/all_forum', ['uses' => 'ForumController@all_forum', 'as' => 'all_forum']);#所有版块
    Route::post('/app/version', ['uses' => 'ForumController@version', 'as' => 'version']);#获取App最新版本号
    Route::get('/app/hitokoto', ['uses' => 'ForumController@hitokoto', 'as' => 'hitokoto']);#一句话静态
    Route::post('/app/user_report', ['uses' => 'UserController@user_report', 'as' => 'user_report']);#用户反馈
    Route::post('/app/test', ['uses' => 'UserController@test', 'as' => 'test']);#test
    Route::post('/app/user_view', ['uses' => 'UserController@user_view', 'as' => 'user_view']);#其它用户主页
    Route::post('/app/get_user_thread', ['uses' => 'UserController@get_user_thread', 'as' => 'user_view']);#获取用户发的帖子
});

//if( UserAgent::isMobile() ){
//    //移动端
//    Route::get('/', ['uses' => 'Controller@mobile', 'as' => 'mobile']);
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
        Route::get('/avatar', ['uses' => 'PictureController@show_avatar', 'as' => 'show_avatar']);#传uid返回头像链接


    });
    //论坛
    Route::group([
        'namespace' => 'Forum'
    ], function () {
        Route::get('/',             ['uses' => 'ForumBaseController@ForumIndex', 'as' => 'forum']);#论坛首页
        Route::get('/forum.php',    ['uses' => 'ForumBaseController@ForumIndex', 'as' => 'forum-index']);#论坛首页
        Route::get('/forum',        ['uses' => 'ForumBaseController@ForumIndex', 'as' => 'forum-index']);#论坛首页
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
        Route::get('/fantuanpuDevelopers', ['uses' => 'ForumBaseController@fantuanpuDevelopers', 'as' => 'fantuanpuDevelopers']);#饭团扑开发者列表
        Route::get('/app_download', ['uses' => 'ForumBaseController@app_download', 'as' => 'app_download']);#下载App页面
        Route::get('/medal_shop', ['uses' => 'MedalController@medal_shop', 'as' => 'medal_shop']);#勋章商店


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
        Route::get('/update_user_avatar', 'UserBaseController@update_user_avatar');#修改用户头像
        Route::get('/my_thread', ['uses' => 'UserBaseController@my_thread', 'as' => 'get_my_thread']);#我发的帖子
        Route::get('/my_medal', ['uses' => 'UserBaseController@my_medal', 'as' => 'my_medal']);# 我的勋章
        Route::get('/sell_old_medal', ['uses' => 'UserBaseController@sell_old_medal', 'as' => 'my_medal']);# 卖掉旧版勋章
    });
    //管理后台 IndexCp
    Route::group([
        'namespace' => 'Admincp',
        'namespace' => 'Admincp',
        'middleware' => [
            'admin'
        ]
    ], function () {
        Route::get('/admincp/', ['uses' => 'AdmincpController@IndexCp', 'as' => 'admin']);#管理后台首页
        Route::get('/admincp/user_manager', ['uses' => 'AdmincpController@userManager', 'as' => 'userManager']);#用户管理面板
        Route::get('/admincp/user-edit', ['uses' => 'AdmincpController@userEdit', 'as' => 'userManager']);#用户管理面板
        Route::get('/admincp/add_medal', ['uses' => 'OperateController@add_medal', 'as' => 'add_medal']);#添加新的勋章页面
        Route::get('/admincp/medal_list', ['uses' => 'OperateController@medal_list', 'as' => 'medal_list']);#勋章列表
        Route::post('/admincp/store_medal', ['uses' => 'OperateController@store_medal', 'as' => 'store_medal']);#添加新的勋章

    });
//
//}
//
//
