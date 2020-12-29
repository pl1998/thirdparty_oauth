<h1> thirdparty_oauth </h1>

<p> 这是一个社会第三方登录扩展包 目前支持</p>
>1. QQ(app/h5/web).
>2.微信(web扫码).
>3.微博(app/h5/web.
>4.支付宝(web/h5/app).
>5. 小米(web/h5).
>6.抖音.
>7.世纪互联(微软).
>8.微软.
>9. gitee.
>10.github.
>11.gitlab.
>12. google(有墙).
>13.facebook(有墙).
>14 line.
>15.twitter.


[![Build Status](https://travis-ci.org/pl1998/thirdparty_oauth.svg?branch=master)](https://travis-ci.org/pl1998/thirdparty_oauth)
![StyleCI build status](https://github.styleci.io/repos/295677202/shield)

## 安装

```shell
$ composer require pltrue/thirdparty_oauth 
```

<hr>

## 贡献
你可以通过以下三种方式做出贡献:

1. bug反馈   [issue tracker](https://github.com/pl1998/thirdparty_oauth/issues).
2. 回答问题或修复错误 [issue tracker](https://github.com/pl1998/thirdparty_oauth/issues).
3. 贡献新特性或更新wiki。

## 贡献者🎉、以及合并日志

| 日期   | 更新级别 | 更新内容      | 贡献者 | 当前状态 |
| ------| -------- | --------- | ---- | ---- |
| 2020-12-06|   fix 、feat   | 新增`Microsoft`登录 修复微信、QQ的bug   | [742481030](https://github.com/742481030)     | 已合并到master分支     |
| 2020-12-07|   feat         | 新增`支付宝`登录    | [742481030](https://github.com/742481030)  | 已合并到master分支     |
| 2020-12-08|   feat         | 新增`小米账户`登录    | [742481030](https://github.com/742481030)  | 已合并到master分支     |
| 2020-12-09|   feat         | 新增`google账户`登录    | [742481030](https://github.com/742481030)  | 已合并到master分支     |
| 2020-12-10|   feat         | 新增`华为账户`登录    | [742481030](https://github.com/742481030)  | 已合并到master分支     |
 2020-12-11|   fix         | qq统一使用json接口    | [742481030](https://github.com/742481030)  | 已合并到master分支     |
 | 2020-12-12|   feat         | 新增`抖音账户`登录    | [742481030](https://github.com/742481030)  | 已合并到master分支     |
  | 2020-12-13|   feat         | 新增`Line账户`登录    | [742481030](https://github.com/742481030)  | 已合并到master分支     |
   | 2020-12-16|   feat         | 新增`Facebook账户`登录    | [742481030](https://github.com/742481030)  | 已合并到master分支     |
    | 2020-12-29|   fix         | 增加兼容支付宝qq app混合应用兼容   | [742481030](https://github.com/742481030)  | 已合并到master分支     |
    | 2020-12-29|   feat         | 新增`京东账户`登录    | [742481030](https://github.com/742481030)  | 已合并到master分支     |


## 兼容
> * 支持php >=7.0 

## 如何使用

> * [php项目中如何使用?](#测试1)
> * [在Thinkphp中如何使用?](#测试2)
> * [在laravel中如何使用?](#测试3)


<hr>

## 如何申请应用授权？
    
   * [github应用创建地址](https://github.com/settings/developers)
   * [gitee应用创建地址](https://gitee.com/oauth/applications)
   * [gitlab应用创建地址](https://gitlab.com/oauth/applications)
   * [微博应用创建地址](https://open.weibo.com/)
   * [microcoft应用创建地址](https://azure.com/)
   * [QQ互联创建地址](https://connect.qq.com/index.html)
   * [支付宝应用](https://open.alipay.com/platform/home.htm?from=wwwalipay)
   * [小米应用](https://dev.mi.com/console/)
   * [google应用](https://console.developers.google.com)
   * [京东应用](https://jos.jd.com/)
   
   

##### 参数说明 

>   <kbd>redirect_url</kbd>   回调地址将使用方法写到回调接口即可 获取到用户的一些基础信息 <br/>
> <kbd>client_id</kbd>     应用授权id <br/>
>  <kbd>client_secret</kbd>  应用授权key <br/>
>  所有支持平台的类型 `github` `gitee` `gitlab` `weibo` `qq` `weixin` `alipay` `microsoft` 配置文件下标一致



##### 建议

> 前后端分离下建议前端直接请求授权接口，后端负责回调接口即可

## <a id="测试1">php项目中如何使用</a>

<hr>

<br/>
<br/>

#### 授权方法  



```php

require __DIR__ .'/vendor/autoload.php';

use Pl1998\ThirdpartyOauth\SocialiteAuth;

$api = new SocialiteAuth([
    'client_id' => '74ee75f10437b4862d653a682111e5ddca1d24422f00ec884453ad232ae07ac9',
    'redirect_uri' => 'http://oauth.test/test.php'
]);

$json = $api->redirect('weibo');

var_dump($json);
```
    
#### 回调接口方法

```php

require __DIR__ .'/vendor/autoload.php';

use Pl1998\ThirdpartyOauth\SocialiteAuth;

$api = new SocialiteAuth([
    'client_id' => '74ee75f10437b4862d653a682111e5ddca1d24422f00ec884453ad232ae07ac9',
    'redirect_uri' => 'http://oauth.test/test.php',
    'client_secret' => ''
]);

$user = $api->driver('gitee')->user();

var_dump($user);die;

```

<br/>

## <a id="测试2">在Thinkphp中如何使用?</a>


<hr>

```php

//在路由文件新建两条路由
Route::get('authorization','api/TestController/authorization')->name('请求授权');
Route::get('gitee/callback','api/TestController/giteeCallback')->name('授权回调接口');

```

## 配置文件

```php
return [
    'github' => [
            'client_id' => '2365a07a73dc25a27e5c7a968248b96beb53a1ad300de7ba6bf4ffe247a4b386',
            'redirect_uri' => 'http://test.test/gitee/callback',
            'client_secret' => ''
        ],
    'github' => [
            'client_id' => '2365a07a73dc25a27e5c7a968248b96beb53a1ad300de7ba6bf4ffe247a4b386',
            'redirect_uri' => 'http://test.test/gitee/callback',
            'client_secret' => ''
     ]
];

```



```php

<?php
/**
 * Created by PhpStorm
 * User: pl
 * Date: 2020/9/17
 * Time: 14:56
 */

namespace app\api\controller;

use Pl1998\ThirdpartyOauth\SocialiteAuth;
use think\facade\Config;

class TestController
{


    /**
     * 该方法重定向后会执行giteeCallback() 方法
     * @return int
     */
    public function authorization()
    {
        $auth = new SocialiteAuth(Config::get('aouth.github'));

        return $auth->redirect('github');

    }

    /**
     * @throws \Pl1998\ThirdpartyOauth\Exceptions\InvalidArgumentException
     */
    public function giteeCallback()
    {
        $api = new SocialiteAuth(Config::get('aouth.github'));

        $user = $api->driver('github')->user();

        var_dump($user);

        //判断用户是否存在表中 然后存入session 或者颁发token 返回给前端
    }
}

```

## <a id="测试3">在laravel中如何使用?</a>


> 在laravle的 <kbd>service.php</kbd>配置文件中加入配置

```php

   .
   .
   .
  'oauth' => [
         'github' => [
             'client_id'    => env('GITHUB_CLIENT_ID'),
             'redirect_uri' => env('GITHUB_REDIRECT_URI'),
             'client_secret'=>env('GITHUB_CLIENT_SECRET')
         ]
  ]
   .....
```

#### 在 <kbd>.env</kdb>中配置

```shell
GITHUB_CLIENT_ID=xxxx
GITHUB_REDIRECT_URI=xxx
GITHUB_CLIENT_SECRET=xxx
```

## 创建路由

```php
Route::get('auth/github','IndexController@auth')->name('github授权');
Route::get('callback/github','IndexController@callback')->name('github回调接口');
```

## 控制器方法

```php
 /**
     * 授权方法
     * @return mixed
     */
    public function auth()
    {
        //普通写法
        // $auth = new SocialiteAuth(config('services.oauth'));
        // $auth->redirect('github');

        //laravel 容器使用
         app('socialiteAuth')->redirect('github');

    }
    /**
     * 回调方法
     */
    public function callback()
    {
        //普通写法
        //$auth = new SocialiteAuth(config('services.oauth.github'));
        //$user = $auth->driver('github')->user();
        //var_dump($user);
        //laravel 容器使用
        $user = app('socialiteAuth')->driver('github')->user();
        var_dump($user);
    }
```



## 返回示例

```json
{
    "login": "pl1998",
    "id": 43993206,
    "node_id": "MDQ6VXNlcjQzOTkzMjA2",
    "avatar_url": "https://avatars1.githubusercontent.com/u/43993206?v=4",
    "gravatar_id": "",
    "url": "https://api.github.com/users/pl1998",
    "html_url": "https://github.com/pl1998",
    "followers_url": "https://api.github.com/users/pl1998/followers",
    "following_url": "https://api.github.com/users/pl1998/following{/other_user}",
    "gists_url": "https://api.github.com/users/pl1998/gists{/gist_id}",
    "starred_url": "https://api.github.com/users/pl1998/starred{/owner}{/repo}",
    "subscriptions_url": "https://api.github.com/users/pl1998/subscriptions",
    "organizations_url": "https://api.github.com/users/pl1998/orgs",
    "repos_url": "https://api.github.com/users/pl1998/repos",
    "events_url": "https://api.github.com/users/pl1998/events{/privacy}",
    "received_events_url": "https://api.github.com/users/pl1998/received_events",
    "type": "User",
    "site_admin": false,
    "name": "pltrue",
    "company": null,
    "blog": "pltrue.top",
    "location": "深圳",
    "email": null,
    "hireable": null,
    "bio": null,
    "twitter_username": null,
    "public_repos": 6,
    "public_gists": 0,
    "followers": 1,
    "following": 1,
    "created_at": "2018-10-09T12:42:14Z",
    "updated_at": "2020-09-17T04:49:23Z"
}

```
<br/>
<br/>


## License
<hr>
MIT


