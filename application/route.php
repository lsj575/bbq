<?php
use think\Route;
/**
 * 资源路由参考表
 * 标识	  请求类型	生成路由规则	     对应操作方法（默认）
 * index    GET	       blog	            index
 * create   GET	       blog/create	    create
 * save	    POST	   blog	            save
 * read	    GET	       blog/:id	        read
 * edit	    GET	       blog/:id/edit	edit
 * update	PUT	       blog/:id	        update
 * delete	DELETE	   blog/:id	        delete
 */


/**
 * 主题相关路由
 */

//获取所有主题
Route::get('api/:ver/theme/all', 'api/:ver.theme/getAllTheme');
// 获取用户关注的主题
Route::get('api/:ver/theme/attention/user', 'api/:ver.theme/getThemeOfUserAttention');


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
// 获取获赞最多的动态
Route::get('api/:ver/articles/recommend', 'api/:ver.article/getRecommendArticles');
//动态评论
Route::post('api/:ver/comment', 'api/:ver.comment/save');
Route::get('api/:ver/comment/:id', 'api/:ver.comment/read');
// 获取某用户的动态
Route::get('api/:ver/articles/user', 'api/:ver.article/getArticleOfUser');
// 获取某用户关注的主题和用户的动态
Route::get('api/:ver/articles/attention', 'api/:ver.article/getArticlesOfUserAttention');

//登录路由
Route::post('api/:ver/login', 'api/:ver.login/save');

/**
 * 用户信息相关
 */
// 获取用户数据 【资源路由】
Route::resource('api/:ver/user', 'api/:ver.user');
// 检查用户昵称是否唯一
Route::get('api/:ver/user/nickname/:id', 'api/:ver.user/checkUserNicknamePass');
// 获取用户关注其他用户的数量
Route::get('api/:ver/user/attention/count', 'api/:ver.user/getUserAttentionUserCount');
// 获取用户被其他关注用户关注的数量
Route::get('api/:ver/user/beattention/count', 'api/:ver.user/getUserBeAttentionCount');
// 获取用户关注的用户
Route::get('api/:ver/user/attention/user', 'api/:ver.user/getUserOfUserAttention');
// 检查用户昵称是否合法
Route::get('api/:ver/user/checknickname/:id', 'api/:ver.user/checkUserNicknamePass');
/**
 * 图片相关路由
 */
//图片上传路由
Route::get('api/:ver/image/accesstoken','api/:ver.image/getAccessToken');

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
// 点赞
Route::post('api/:ver/upvote', 'api/:ver.upvote/save');
// 取消点赞
Route::delete('api/:ver/upvote', 'api/:ver.upvote/delete');
// 获取某动态是否被用户点赞
Route::get('api/:ver/upvote/:id', 'api/:ver.upvote/read');
/**
 * 关注相关路由
 */
// 关注主题
Route::post('api/:ver/attention/theme', 'api/:ver.attention/attentionTheme');
// 取消关注主题
Route::delete('api/:ver/attention/theme', 'api/:ver.attention/deleteAttentionTheme');
// 获取某主题是否被用户关注
Route::get('api/:ver/attention/theme/:id', 'api/:ver.attention/readAttentionTheme');
// 关注用户
Route::post('api/:ver/attention/user', 'api/:ver.attention/attentionUser');
// 取消关注用户
Route::delete('api/:ver/attention/user', 'api/:ver.attention/deleteAttentionUser');
// 获取某用户是否被用户关注
Route::get('api/:ver/attention/user/:id', 'api/:ver.attention/readAttentionUser');

/**
 * 搜索相关
 */
// 搜索
Route::get('api/:ver/search', 'api/:ver.search/read');

/**
 * 反馈相关
 */
// 获取反馈类型
Route::get('api/:ver/feedback/type', 'api/:ver.feedback/getFeedbackType');
// 提交反馈
Route::post('api/:ver/feedback/submit', 'api/:ver.feedback/submitFeedback');

/**
 * 测试相关
 */
Route::get('api/test/sms', 'api/test/testSend');
Route::post('api/test/encrypt', 'api/test/encrypt');
Route::post('api/test/decrypt', 'api/test/decrypt');