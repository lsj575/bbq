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
 * 客户端启动相关路由
 */
// 获取最新版本信息并记录日志
Route::get('api/:ver/index/init', 'api/:ver.index/init');
// TODO 启动图接口

/**
 * 主题相关路由
 */
//获取所有主题
Route::get('api/:ver/theme/all', 'api/:ver.theme/getAllTheme');
// 根据id获取主题基本信息
Route::get('api/:ver/theme/basic_info', 'api/:ver.theme/getThemeBasicInfoById');
// 获取用户关注的主题
Route::get('api/:ver/theme/attention/user', 'api/:ver.theme/getThemeOfUserAttention');
// 获取某主题的用户关注数量
Route::get('api/:ver/theme/beattention/count', 'api/:ver.theme/getUserNumOfAttentionTheme');

/**
 * 动态相关
 */
// 添加动态
Route::post('api/:ver/article', 'api/:ver.article/save');
// 更新动态
Route::put('api/:ver/article/:id', 'api/:ver.article/update');
// 根据id获取动态信息
Route::get('api/:ver/article/info', 'api/:ver.article/getArticleInfoById');
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
// 获取用户本人数据
Route::get('api/:ver/user', 'api/:ver.user/read');
// 更新用户信息
Route::put('api/:ver/user/:id', 'api/:ver.user/update');
// 根据id获取其他用户的基本信息
Route::get('api/:ver/user/basic_info', 'api/:ver.user/getUserBasicInfoById');
// 检查用户昵称是否唯一
Route::get('api/:ver/user/nickname/:id', 'api/:ver.user/checkUserNicknamePass');
// 获取用户关注其他用户的数量
Route::get('api/:ver/user/attention/count', 'api/:ver.user/getUserAttentionUserCount');
// 获取用户被其他关注用户关注的数量
Route::get('api/:ver/user/beattention/count', 'api/:ver.user/getUserBeAttentionCount');
// 获取用户关注的用户
Route::get('api/:ver/user/attention/user', 'api/:ver.user/getUserOfUserAttention');
// 获取用户粉丝（关注他的人）
Route::get('api/:ver/user/beattention/user', 'api/:ver.user/getUserOfUserBeAttention');
// 检查用户昵称是否合法
Route::get('api/:ver/user/checknickname/:id', 'api/:ver.user/checkUserNicknamePass');
// 获取用户关注主题的数量
Route::get('api/:ver/user/attentiontheme/count', 'api/:ver.user/getUserAttentionThemeCount');

/**
 * 图片相关路由
 */
//图片上传路由
Route::get('api/:ver/image/accesstoken','api/:ver.image/getAccessToken');

/**
 * 轮播图相关路由
 */
//获取所有轮播图路由
Route::get('api/:ver/slideimg/getimgs','api/:ver.slideImg/getImages');

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
// 给动态点赞
Route::post('api/:ver/upvote/article', 'api/:ver.upvote/saveUserArticles');
// 取消动态点赞
Route::delete('api/:ver/upvote/article', 'api/:ver.upvote/deleteUserArticles');
// 获取某动态是否被用户点赞
Route::get('api/:ver/upvote/article', 'api/:ver.upvote/readUserArticles');
// 给评论点赞
Route::post('api/:ver/upvote/article_comment', 'api/:ver.upvote/saveUserArticleComments');
// 取消评论点赞
Route::delete('api/:ver/upvote/article_comment', 'api/:ver.upvote/deleteUserArticleComments');
// 获取某评论是否被用户点赞
Route::get('api/:ver/upvote/article_comment', 'api/:ver.upvote/readUserArticleComments');
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

/**********************
 * 举报相关
 **********************/
Route::post('api/:ver/report', 'api/:ver.report/save');

/**********************
 * 收藏相关
 **********************/
// 用户收藏动态
Route::post('api/:ver/collection/article', 'api/:ver.collection/collectionArticle');
// 用户取消收藏动态
Route::delete('api/:ver/collection/article', 'api/:ver.collection/deleteCollection');
// 获取用户是否收藏某动态
Route::get('api/:ver/collection/article/bool', 'api/:ver.collection/getBoolOfCollection');
// 获取用户收藏的动态
Route::get('api/:ver/collection/article', 'api/:ver.collection/getArticleOfUserCollect');


/***************
 * 评论相关
 ***************/
// 评论
Route::post('api/:ver/article_comment/save', 'api/:ver.articleComment/save');
// 获取某动态下的评论
Route::get('api/:ver/article_comment/read', 'api/:ver.articleComment/read');

/**
 * 通知相关
 */
// 获取用户的通知
Route::get('api/:ver/advice/read', 'api/:ver.advice/read');
/**
 * 测试相关
 */
Route::get('api/test/sms', 'api/test/testSend');
Route::post('api/test/encrypt', 'api/test/encrypt');
Route::post('api/test/decrypt', 'api/test/decrypt');