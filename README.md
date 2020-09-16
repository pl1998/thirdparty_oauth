## 这是一个第三方登录扩展包 目前支持 github gitee 微博 gitlab 登录
    
##### 参数说明 

> `redirect_url`回调地址将使用方法写到回调接口即可 获取到用户的一些基础信息
> `client_id` 应用授权id
> `client_secret` 应用授权key

##### 如何申请应用授权
    
   * [github应用创建地址](https://github.com/settings/developers)
   * [gitee应用创建地址](https://gitee.com/oauth/applications)
   * [gitlab应用创建地址](https://gitlab.com/oauth/applications)
   * [微博应用创建地址](https://open.weibo.com/)
   
   
   
##### 建议

> 建议前端页面取请求 授权接口 后端做回调接口保存用户信息到mysql\session 即可

    
## 授权方法
```php


use Thirdparty\Src\SocialiteAuth;

$aouth = new SocialiteAuth();

$code = $aouth->redirect('github',[
    'client_id' => '74ee75f10437b4862d653a682111e5ddca1d24422f00ec884453ad232ae07ac9',
    'redirect_url' => 'http://oauth.test/test.php',
]);


```    
    
## 回调接口方法

```php


use Thirdparty\Src\SocialiteAuth;

$aouth = new SocialiteAuth();

$user = $aouth->driver('weibo',[
    'client_id' => '1949419161',
    'redirect_url' => 'http://oauth.test/test.php',
    'client_secret' => ''

])->user();
var_dump($user);
```



##### 返回的信息

```json
{
	"id": xxxx,
	"idstr": "5878370732",
	"class": 1,
	"screen_name": "Hi叫我李荣浩",
	"name": "Hi叫我李荣浩",
	"province": "36",
	"city": "9",
	"location": "中国",
	"description": "不忆过往，不畏将来！",
	"url": "",
	"profile_image_url": "https://tvax1.sinaimg.cn/crop.0.0.996.996.50/006pP2Laly8gh2touqt7yj30ro0ro0tw.jpg?KID=imgbed,tva&Expires=1600237574&ssig=kCcCDTg4Nq",
	"cover_image_phone": "http://ww2.sinaimg.cn/crop.0.0.640.640.640/a1d3feabjw1ecasunmkncj20hs0hsq4j.jpg",
	"profile_url": "u/5878370732",
	"domain": "",
	"weihao": "",
	"gender": "m",
	"followers_count": 163,
	"friends_count": 72,
	"pagefriends_count": 2,
	"statuses_count": 82,
	"video_status_count": 0,
	"video_play_count": 0,
	"favourites_count": 15,
	"created_at": "Wed Mar 09 19:26:21 +0800 2016",
	"following": false,
	"allow_all_act_msg": false,
	"geo_enabled": true,
	"verified": false,
	"verified_type": -1,
	"remark": "",
	"email": "",
	"insecurity": {
		"sexual_content": false
	},
	"status": {
		"visible": {
			"type": 0,
			"list_id": 0
		},
		"created_at": "Thu Jun 25 20:50:59 +0800 2020",
		"id": 4519807145721924,
		"idstr": "4519807145721924",
		"mid": "4519807145721924",
		"can_edit": false,
		"show_additional_indication": 0,
		"text": "上岛",
		"textLength": 4,
		"source_allowclick": 1,
		"source_type": 1,
		"source": "HUAWEI P20",
		"favorited": false,
		"truncated": false,
		"in_reply_to_status_id": "",
		"in_reply_to_user_id": "",
		"in_reply_to_screen_name": "",
		"pic_urls": [{
			"thumbnail_pic": "http://wx2.sinaimg.cn/thumbnail/006pP2Lagy1gg4trqrbqlj33282ao4qq.jpg"
		}],
		"thumbnail_pic": "http://wx2.sinaimg.cn/thumbnail/006pP2Lagy1gg4trqrbqlj33282ao4qq.jpg",
		"bmiddle_pic": "http://wx2.sinaimg.cn/bmiddle/006pP2Lagy1gg4trqrbqlj33282ao4qq.jpg",
		"original_pic": "http://wx2.sinaimg.cn/large/006pP2Lagy1gg4trqrbqlj33282ao4qq.jpg",
		"geo": null,
		"is_paid": false,
		"mblog_vip_type": 0,
		"annotations": [{
			"client_mblogid": "daada9fc-4370-414c-88c2-805729e979b6"
		}, {
			"mapi_request": true
		}],
		"picStatus": "0:1",
		"reposts_count": 0,
		"comments_count": 0,
		"attitudes_count": 0,
		"pending_approval_count": 0,
		"isLongText": false,
		"reward_exhibition_type": 0,
		"hide_flag": 0,
		"mlevel": 0,
		"biz_feature": 4294967300,
		"hasActionTypeCard": 0,
		"darwin_tags": [],
		"hot_weibo_tags": [],
		"text_tag_tips": [],
		"mblogtype": 0,
		"rid": "0",
		"userType": 0,
		"more_info_type": 0,
		"positive_recom_flag": 0,
		"content_auth": 0,
		"gif_ids": "",
		"is_show_bulletin": 2,
		"comment_manage_info": {
			"comment_permission_type": -1,
			"approval_comment_type": 0
		},
		"pic_num": 1
	},
	"ptype": 0,
	"allow_all_comment": false,
	"avatar_large": "https://tvax1.sinaimg.cn/crop.0.0.996.996.180/006pP2Laly8gh2touqt7yj30ro0ro0tw.jpg?KID=imgbed,tva&Expires=1600237574&ssig=luZaQXGdS9",
	"avatar_hd": "https://tvax1.sinaimg.cn/crop.0.0.996.996.1024/006pP2Laly8gh2touqt7yj30ro0ro0tw.jpg?KID=imgbed,tva&Expires=1600237574&ssig=rNKgKR7Rq4",
	"verified_reason": "",
	"verified_trade": "",
	"verified_reason_url": "",
	"verified_source": "",
	"verified_source_url": "",
	"follow_me": false,
	"like": false,
	"like_me": false,
	"online_status": 0,
	"bi_followers_count": 18,
	"lang": "zh-cn",
	"star": 0,
	"mbtype": 0,
	"mbrank": 0,
	"block_word": 0,
	"block_app": 0,
	"credit_score": 80,
	"user_ability": 2360320,
	"urank": 9,
	"story_read_state": -1,
	"vclub_member": 0,
	"is_teenager": 0,
	"is_guardian": 0,
	"is_teenager_list": 0,
	"pc_new": 0,
	"special_follow": false,
	"planet_video": 0,
	"video_mark": 0,
	"live_status": 0
}

```
