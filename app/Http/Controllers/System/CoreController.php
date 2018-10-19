<?php

namespace App\Http\Controllers\System;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

/**
 * Class CoreController
 * @package App\Http\Controllers\System
 *          提供缓存关键字,time为缓存的分钟数,不足1分钟的请手动设置
 */
class CoreController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 板块列表缓存key
     */
    const NODES = ['key'=>'nodes_array_','time'=>3600];
    /**
     * 板块信息
     */
    const NODES_INFO = ['key'=>'nodes_info_','time'=>3600000];
    /**
     * 帖子详情缓存
     */
    const THREAD_VIEW = ['key'=>'thread_view_','time'=>60*24];
    /**
     * 帖子的回帖缓存 ,回帖不经常修改,缓存1个月
     */
    const POSTS_VIEW = ['key'=>'post_view_','time'=>60*24*30];
    /**
     * 取得老用户查询缓存
     */
    const OLD_USER = ['key'=>'old_user_key_','time'=>1000];
    /**
     * 60秒内有没有给某邮箱发送过邮件
     */
    const HAS_POST_MAIL_TO = ['key' => 'has_post_mail_to_','time'=>1];
    /**
     * 60秒内有没有发送过任意邮件
     */
    const HAS_POST_MAIL = ['key' => 'has_post_mail_', 'time'=>1];
    /**
     * 用户组信息
     */
    const USER_GROUP = ['key' => 'group_', 'time'=>36000];
    /**
     * 用户积分信息
     */
    const USER_COUNT = ['key' => 'user_count_', 'time'=>360];
    /**
     *  用户token信息,储存一年
     */
    const USER_TOKEN = ['key' => 'user_token_','time'=>1008084812];
    /**
     * 用户论坛信息(签名档、自定义头衔、勋章)
     */
    const USER_FIELD  = ['key' => 'user_field_','time'=>360];
    /**
     * 最热帖子
     */
    const HOT_THREAD = ['key' => 'hot_thread','time'=>360];
    /**
     * 最新回复
     */
    const NEW_REPLY = ['key' => 'new_reply','time'=>15];
    /**
     * 最新主题
     */
    const NEW_THREAD = ['key' => 'new_thread','time'=>15];
    /**
     * 帖子回帖分页数量
     */
    const THREAD_REPLY_PAGE = 20;
    /**
     * 用户佩戴的勋章
     */
    const USER_MEDAL = ['key' => 'user_medal_','time'=>360];
    /**
     * 勋章信息,存储一年
     */
    const MEDAL_INFO = ['key' => 'medal_info' , 'time' => 1008084812];
}
