<?php

//通用
Route::group([
    'namespace' => 'User',
], function ()
{
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
    Route::get('/validate_email', ['uses' => 'UserBaseController@ValidateEmail', 'as' => 'ValidateEmail']);# 等待验证会员验证电子邮箱
    Route::get('/send_validate_email', ['uses' => 'UserBaseController@send_validate_email', 'as' => 'send_validate_email']);# 等待验证会员验证电子邮箱
    Route::get('/update_user_avatar', 'UserBaseController@update_user_avatar');#修改用户头像
    Route::post('/uc-do-upload-avatar', 'UserBaseController@DoUploadAvatar');#修改头像

});

Route::group([
    'namespace' => 'Forum',
], function () {

    Route::post('/post-thread', ['uses' => 'ThreadApiController@PostsThread', 'as' => 'store-posts']);#回帖

});

//App 接口(必须获取token的)
Route::group([
    'namespace' => 'App',
    'middleware' => [
        'app',
        'domain.fantuanpu'
    ]
],function () {
    Route::get('/app/test', ['uses' => 'UserController@test', 'as' => 'app-user-test']);#app测试
    Route::post('/app/user_center', ['uses' => 'UserController@user_center', 'as' => 'user_center']);#用户中心数据
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
    'middleware' => [
        'domain.fantuanpu'
    ],
],function () {
    Route::post('/app/forum_list', ['uses' => 'ForumController@forum_list', 'as' => 'forum_list']);#板块列表
    Route::post('/app/look_look', ['uses' => 'ForumController@look_look', 'as' => 'look_look']);#随便看看
    Route::post('/app/view_thread', ['uses' => 'ForumController@viewThread', 'as' => 'view_thread']);#查看帖子
    Route::post('/app/post_next_page', ['uses' => 'ForumController@post_next_page', 'as' => 'post_next_page']);#看下一页帖子
    Route::post('/app/all_forum', ['uses' => 'ForumController@all_forum', 'as' => 'all_forum']);#所有版块
    Route::post('/app/version', ['uses' => 'ForumController@version', 'as' => 'version']);#获取App最新版本号
    Route::get('/app/hitokoto', ['uses' => 'ForumController@hitokoto', 'as' => 'hitokoto']);#一句话静态
    Route::post('/app/user_report', ['uses' => 'UserController@user_report', 'as' => 'user_report']);#用户反馈
    //    Route::post('/app/test', ['uses' => 'UserController@test', 'as' => 'test']);#test
    Route::post('/app/user_view', ['uses' => 'UserController@user_view', 'as' => 'user_view']);#其它用户主页
    Route::post('/app/get_user_thread', ['uses' => 'UserController@get_user_thread', 'as' => 'user_view']);#获取用户发的帖子
    Route::post('/app/complete_action', ['uses' => 'UserController@complete_action', 'as' => 'complete_action']);#用户完成动作
    Route::post('/app/add_user_coin', ['uses' => 'UserController@add_user_coin', 'as' => 'add_user_coin']);#用户修改资金

});

//服务
Route::group([
    'namespace' => 'System',
], function () {
    Route::get('/', ['uses' => 'ServeController@index', 'as' => 'index']);#根
    Route::get('/ss', ['uses' => 'ServeController@ss', 'as' => 'ss']);#查看session
    Route::get('/info', ['uses' => 'ServeController@info', 'as' => 'info']);#phpinfo
    Route::get('/test', ['uses' => 'TestController@index', 'as' => 'test']);#test
    Route::get('/ping', ['uses' => 'TestController@ping', 'as' => 'ping']);#test
    Route::get('/avatar', ['uses' => 'PictureController@show_avatar', 'as' => 'show_avatar']);#传uid返回头像链接
    Route::get('/clock_alert', ['uses' => 'ServeController@clock_alert', 'as' => 'clock_alert']);#闹钟提醒
    Route::get('/del_thread', ['uses' => 'ServeController@del_thread', 'as' => 'del_thread']);#删除帖子
    Route::get('/del_post', ['uses' => 'ServeController@del_post', 'as' => 'del_post']);#删除回复


});

//论坛
Route::group([
    'namespace' => 'Forum',
    'middleware' => [
        'domain.fantuanpu'
    ],
], function () {
    //    Route::get('/',             ['uses' => 'ForumBaseController@ForumIndex', 'as' => 'forum']);#论坛首页
    Route::get('/forum.php',    ['uses' => 'ForumBaseController@ForumIndex', 'as' => 'forum-index']);#论坛首页
    Route::get('/index',        ['uses' => 'ForumBaseController@ForumIndex', 'as' => 'forum-index']);#论坛首页
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

    Route::get('/webim', ['uses' => 'ForumBaseController@webim', 'as' => 'webim']);#webim即时聊天
    Route::get('/fantuanpuDevelopers', ['uses' => 'ForumBaseController@fantuanpuDevelopers', 'as' => 'fantuanpuDevelopers']);#饭团扑开发者列表
    Route::get('/app_download', ['uses' => 'ForumBaseController@app_download', 'as' => 'app_download']);#下载App页面
    Route::get('/medal_shop', ['uses' => 'MedalController@medal_shop', 'as' => 'medal_shop']);#勋章商店


});
//论坛-必须登录
Route::group([
    'namespace' => 'Forum',
    'middleware' => [
        'need.login',
        'domain.fantuanpu'
    ],
], function () {
    Route::get('/set_top_thread', ['uses' => 'ThreadController@set_top_thread', 'as' => 'set_top_thread']);#设置帖子为置顶
});
//用户
Route::group([
    'namespace' => 'User',
    'middleware' => [
        'domain.fantuanpu'
    ],
], function () {

    Route::get('/live2d', ['uses' => 'UserBaseController@live2d', 'as' => 'live2d']);#live2d 测试
});
//用户-必须登录的
Route::group([
    'namespace' => 'User',
    'middleware' => [
        'need.login',
        'domain.fantuanpu'
    ],
], function () {
    Route::get('/user-center', ['uses' => 'UserBaseController@UserCenter', 'as' => 'UserCenter']);#用户中心
    Route::get('/get_my_message', 'UserBaseController@get_my_message');#获取我的消息
    Route::get('/my_thread', ['uses' => 'UserBaseController@my_thread', 'as' => 'get_my_thread']);#我发的帖子
    Route::get('/my_medal', ['uses' => 'UserBaseController@my_medal', 'as' => 'my_medal']);# 我的勋章
    Route::get('/sell_old_medal', ['uses' => 'UserBaseController@sell_old_medal', 'as' => 'my_medal']);# 卖掉旧版勋章
    Route::post('/buy_medal', ['uses' => 'UserBaseController@buy_medal', 'as' => 'buy_medal']);# 购买勋章
    Route::post('/adorn_mine', ['uses' => 'UserBaseController@adorn_mine', 'as' => 'adorn_mine']);# 佩戴勋章
    Route::post('/put_in_box', ['uses' => 'UserBaseController@put_in_box', 'as' => 'put_in_box']);# 摘下勋章
    Route::get('/sign', ['uses' => 'SignController@sign', 'as' => 'sign']);# 签到



});

//管理后台 IndexCp
Route::group([
    'namespace' => 'Admincp',
    'middleware' => [
        'admin'
    ],
], function () {
    Route::get('/admincp/', ['uses' => 'AdmincpController@IndexCp', 'as' => 'admin']);#管理后台首页
    Route::get('/admincp/user_manager', ['uses' => 'AdmincpController@userManager', 'as' => 'userManager']);#用户管理面板
    Route::get('/admincp/user-edit', ['uses' => 'AdmincpController@userEdit', 'as' => 'userManager']);#用户管理面板
    Route::get('/admincp/add_medal', ['uses' => 'OperateController@add_medal', 'as' => 'add_medal']);#添加新的勋章页面
    Route::get('/admincp/medal_list', ['uses' => 'OperateController@medal_list', 'as' => 'medal_list']);#勋章列表

    Route::post('/admincp/store_medal', ['uses' => 'OperateController@store_medal', 'as' => 'store_medal']);#添加新的勋章
    Route::get('/admincp/add_group_buying_item', ['uses' => 'GroupBuyingController@add_group_buying_item', 'as' => 'add_group_buying_item']);#添加团购商品
    Route::post('/admincp/add_group_buying_item', ['uses' => 'GroupBuyingController@add_action', 'as' => 'add_action']);#添加团购商品
    Route::get('/admincp/show_group_buying_list', ['uses' => 'GroupBuyingController@show_group_buying_list', 'as' => 'show_group_buying_list']);#团购列表
    Route::get('/admincp/review_orders', ['uses' => 'GroupBuyingController@review_orders', 'as' => 'review_orders']);#回顾订单
    Route::get('/admincp/settle_orders', ['uses' => 'GroupBuyingController@settle_orders', 'as' => 'settle_orders_get']);#清算订单
    Route::post('/admincp/settle_orders', ['uses' => 'GroupBuyingController@settle_orders', 'as' => 'settle_orders_post']);#清算订单
    Route::get('/admincp/participant', ['uses' => 'GroupBuyingController@participant', 'as' => 'participant']);#查看当期参与者
    Route::get('/admincp/order_delivers', ['uses' => 'GroupBuyingController@order_delivers', 'as' => 'order_delivers']);#查看申请发货的名单
    Route::post('/admincp/delivers_status', ['uses' => 'GroupBuyingController@delivers_status', 'as' => 'delivers_status']);#查看发货状态

    Route::get('/admincp/items_participant', ['uses' => 'GroupBuyingController@items_participant', 'as' => 'items_participant']);#商品参购者
    Route::get('/admincp/deliver', ['uses' => 'GroupBuyingController@deliver', 'as' => 'deliver']);#弹出发货菜单
    Route::post('/admincp/confirm_group_buying_user_order', ['uses' => 'GroupBuyingController@confirm_group_buying_user_order', 'as' => 'confirm_group_buying_user_order']);#
    Route::post('/admincp/do_deliver', ['uses' => 'GroupBuyingController@do_deliver', 'as' => 'do_deliver']);#发货
    Route::post('/admincp/remove_group_buying_item', ['uses' => 'GroupBuyingController@remove_group_buying_item', 'as' => 'remove_group_buying_item']);#下架
    Route::get('/admincp/remove_group_buying_item', ['uses' => 'GroupBuyingController@remove_group_buying_item', 'as' => 'get_remove_group_buying_item']);#下架
    Route::post('/admincp/skip_orders', ['uses' => 'GroupBuyingController@skip_orders', 'as' => 'skip_orders']);#跑单处理
    Route::get('/admincp/skip_orders', ['uses' => 'GroupBuyingController@skip_orders', 'as' => 'get_skip_orders']);#跑单处理


});


//SUKI的接口
//App
Route::group([
    'namespace' => 'Sukiapp',
    'middleware' => [
        'domain.lolita'
    ],
], function () {
    Route::post('/suki_home_page', ['uses' => 'SukiAppResponseController@suki_home_page', 'as' => 'suki_home_page']);#Suki的首页 homepage
    Route::post('/sukiapp_viewthread', ['uses' => 'SukiAppResponseController@sukiapp_viewThread', 'as' => 'sukiapp_viewThread']);#看suki的帖子

});

//Suki web
Route::group([
    'namespace' => 'SukiWeb',
    'middleware' => [
        'domain.lolita'
    ],
], function () {
    Route::get('/suki-thread-{tid}-{page}.html', ['uses' => 'SukiWebController@view_thread', 'as' => 'thread']);#查看帖子
    Route::get('/suki-userhome-{uid}.html', ['uses' => 'SukiWebController@suki_userhome', 'as' => 'suki_userhome']);#查看别人的suki用户空间
    Route::post('/suki_get_user_thread', ['uses' => 'SukiWebController@suki_get_user_thread', 'as' => 'suki_get_user_thread']);#获取用户的更多帖子
    Route::get('/about_suki', ['uses' => 'SukiWebController@about_suki', 'as' => 'about_suki']);#关于suki
    Route::get('/add_suki_friend_view', ['uses' => 'SukiWebController@add_suki_friend_view', 'as' => 'add_suki_friend_view']);#suki加好友页面
    Route::get('/suki_tribunal', ['uses' => 'SukiWebController@suki_tribunal', 'as' => 'suki_tribunal']);#suki法庭,公示墙
    Route::get('/suki_search', ['uses' => 'SukiWebController@suki_search', 'as' => 'suki_search']);#suki搜索
    Route::get('/suki_login', ['uses' => 'SukiWebController@suki_login', 'as' => 'suki_login']);#suki的登录页面
    Route::get('/suki_group_buying', ['uses' => 'SukiWebController@suki_group_buying', 'as' => 'suki_group_buying']);#suki团购
    Route::get('/suki_group_buying_item_info', ['uses' => 'SukiWebController@suki_group_buying_item_info', 'as' => 'suki_group_buying_item_info']);#suki团购商品详情
    Route::post('/suki_group_buying_item', ['uses' => 'SukiWebController@suki_group_buying_item', 'as' => 'suki_group_buying_item']);#suki团购购买一个商品
    Route::get('/suki_group_buying_myorders', ['uses' => 'SukiWebController@suki_group_buying_myorders', 'as' => 'suki_group_buying_myorders']);#suki团购我的商品
    Route::get('/suki_group_buying_cancel_orders', ['uses' => 'SukiWebController@suki_group_buying_cancel_orders', 'as' => 'suki_group_buying_cancel_orders']);#suki取消我的订单
    Route::get('/suki_group_buying_paying', ['uses' => 'SukiWebController@suki_group_buying_paying', 'as' => 'suki_group_buying_paying']);#suki提交付款证明
    Route::get('/suki_group_buying_deliver', ['uses' => 'SukiWebController@suki_group_buying_deliver', 'as' => 'suki_group_buying_deliver']);#suki发货页面
    Route::post('/suki_group_buying_do_deliver', ['uses' => 'SukiWebController@suki_group_buying_do_deliver', 'as' => 'suki_group_buying_do_deliver']);#申请发货

    Route::post('/suki_group_buying_confirm_orders', ['uses' => 'SukiWebController@suki_group_buying_confirm_orders', 'as' => 'suki_group_buying_confirm_orders']);#suki确认订单号
    Route::post('/suki_group_buying_create_order', ['uses' => 'SukiWebController@suki_group_buying_create_order', 'as' => 'suki_group_buying_create_order']);#创建suki团购订单


    Route::post('/suki-thread', ['uses' => 'SukiWebApiController@get_thread', 'as' => 'get_thread']);#获取suki的帖子
    Route::post('/suki-new-thread', ['uses' => 'SukiWebApiController@suki_new_thread', 'as' => 'suki-new-thread']);#suki发帖子
    Route::post('/suki_next_page', ['uses' => 'SukiWebApiController@suki_next_page', 'as' => 'suki_next_page']);#看下一页帖子 suki
    Route::post('/set_qq', ['uses' => 'SukiWebApiController@set_qq', 'as' => 'set_qq']);#设置联系QQ




});
//Suki web 必须登录的
Route::group([
    'namespace' => 'SukiWeb',
    'middleware' => [
        'domain.lolita',
        'need.login'

    ],
], function () {


    Route::get('/suki-myfollow', ['uses' => 'SukiWebController@suki_myfollow', 'as' => 'suki_myfollow']);#查看我的关注者
    Route::post('/suki_get_user_thread', ['uses' => 'SukiWebController@suki_get_user_thread', 'as' => 'suki_get_user_thread']);#获取用户的更多帖子
    Route::get('/suki_notice', ['uses' => 'SukiWebController@suki_notice', 'as' => 'suki_notice']);#suki的站内提醒
    Route::get('/suki_relationship', ['uses' => 'SukiWebController@suki_relationship', 'as' => 'suki_relationship']);#suki的用户关系 关注 粉丝 好友
    Route::get('/suki_alarm_clock', ['uses' => 'SukiWebController@suki_alarm_clock', 'as' => 'suki_alarm_clock']);#suki的补款闹钟页面
    Route::get('/suki_clock_setting', ['uses' => 'SukiWebController@suki_clock_setting', 'as' => 'suki_clock_setting']);#suki新建一个闹钟
    Route::get('/suki_user_info', ['uses' => 'SukiWebController@suki_user_info', 'as' => 'suki_user_info']);#suki我的信息
    Route::get('/suki_editor_post_view', ['uses' => 'SukiWebController@suki_editor_post_view', 'as' => 'suki_editor_post_view']);#编辑帖子页面
    Route::get('/suki_report', ['uses' => 'SukiWebController@suki_report', 'as' => 'suki_report']);#suki举报
    Route::get('/suki_collection', ['uses' => 'SukiWebController@suki_collection', 'as' => 'suki_collection']);#suki收藏


    Route::post('/suki_reply_board', ['uses' => 'SukiWebApiController@suki_reply_board', 'as' => 'suki_reply_board']);#用户空间留言
    Route::post('/suki_follow_user', ['uses' => 'SukiWebApiController@suki_follow_user', 'as' => 'suki_follow_user']);#suki关注和取关
    Route::post('/suki_reply_thread', ['uses' => 'SukiWebApiController@suki_reply_thread', 'as' => 'suki_reply_thread_api']);#suki回复帖子api
    Route::post('/add_suki_friend', ['uses' => 'SukiWebApiController@add_suki_friend', 'as' => 'add_suki_friend']);#suki加好友
    Route::post('/add_suki_like', ['uses' => 'SukiWebApiController@add_suki_like', 'as' => 'add_suki_like']);#suki收藏帖子
    Route::post('/apply_suki_friends', ['uses' => 'SukiWebApiController@apply_suki_friends', 'as' => 'apply_suki_friends']);#批准suki好友申请

    Route::post('/setting_clock', ['uses' => 'SukiWebApiController@setting_clock', 'as' => 'setting_clock']);#闹钟增删改查
    Route::get('/setting_clock_alert', ['uses' => 'SukiWebApiController@setting_clock_alert', 'as' => 'setting_clock_alert']);#闹钟提醒方式修改
    Route::post('/update_suki_user_info', ['uses' => 'SukiWebApiController@update_suki_user_info', 'as' => 'update_suki_user_info']);#修改suki的用户信息
    Route::post('/update_suki_thread', ['uses' => 'SukiWebApiController@update_suki_thread', 'as' => 'update_suki_thread']);#重新编辑suki的帖子
    Route::post('/suki_post_report', ['uses' => 'SukiWebApiController@suki_post_report', 'as' => 'suki_post_report']);#suki发起举报
    Route::get('/suki_set_top_thread', ['uses' => 'SukiWebApiController@suki_set_top_thread', 'as' => 'suki_set_top_thread']);#suki把帖子设置为置顶


});