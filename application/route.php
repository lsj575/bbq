<?php
use think\Route;


/**
 * 主题相关路由
 */

//获取所有主题
Route::get('api/:ver/theme', 'api/:ver.theme/getAllTheme');


/**
 * 推荐页相关
 */
Route::get('api/:ver/index', 'api/:ver.article/getIndexHeadNormalNews');

/**
 * 动态相关
 */
// 动态资源路由
Route::resource('api/:ver/article', 'api/:ver.article');
// 获取某主题下的所有动态
Route::get('api/:ver/articles/theme', 'api/:ver.article/getArticlesOfTheme');
//动态评论
Route::post('api/:ver/comment', 'api/:ver.comment/save');
Route::get('api/:ver/comment/:id', 'api/:ver.comment/read');


//登录路由
Route::post('api/:ver/login', 'api/:ver.login/save');

/**
 * 用户信息相关
 */
//获取用户数据 【资源路由】
/**
 * 标识	  请求类型	生成路由规则	     对应操作方法（默认）
 * index    GET	       blog	            index
 * create   GET	       blog/create	    create
 * save	    POST	   blog	            save
 * read	    GET	       blog/:id	        read
 * edit	    GET	       blog/:id/edit	edit
 * update	PUT	       blog/:id	        update
 * delete	DELETE	   blog/:id	        delete
 */
Route::resource('api/:ver/user', 'api/:ver.user');
//检查用户昵称是否唯一
Route::get('api/:ver/user/nickname/:id', 'api/:ver.user/checkUserNicknamePass');


/**
 * 图片相关路由
 */
//图片上传路由
Route::post('api/:ver/image', 'api/:ver.image/save');
Route::get('api/:ver/accesstoken','api/:ver.image/getAccessToken');

/**
 * app版本相关路由
 */
Route::get('api/:ver/init', 'api/:ver.index/init');

/**
 * 短信验证码相关
 */
Route::resource('api/:ver/identify', 'api/:ver.identify');

/**
 * 解析 zhlgd 的相关操作
 */
Route::get('api/:ver/lgdindex', 'api/:ver.parsezhlgd/parseIndex');
Route::post('api/:ver/lgdlogin', 'api/:ver.parsezhlgd/zhlgdLogin');
/**
 * 点赞相关路由
 */
Route::post('api/:ver/upvote', 'api/:ver.upvote/save');

/**
 * 测试相关
 */
Route::get('api/test/sms', 'api/test/testSend');
Route::post('api/test/encrypt', 'api/test/encrypt');
Route::post('api/test/decrypt', 'api/test/decrypt');