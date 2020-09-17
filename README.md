<h1 align="center"> thirdparty_oauth </h1>

<p align="center"> 这是一个社会 目前支持 github gitee 微博 gitlab 登录.</p>


## Installing

```shell
$ composer require pl1998/thirdparty_oauth -vvv
```

## Usage

TODO

## Contributing

You can contribute in one of three ways:

1. File bug reports using the [issue tracker](https://github.com/pl1998/thirdparty_oauth/issues).
2. Answer questions or fix bugs on the [issue tracker](https://github.com/pl1998/thirdparty_oauth/issues).
3. Contribute new features or update the wiki.

_The code contribution process is not very formal. You just need to make sure that you follow the PSR-0, PSR-1, and PSR-2 coding guidelines. Any new code contributions must be accompanied by unit tests where applicable._

## License

MIT

    
##### 参数说明 

> `redirect_url`   回调地址将使用方法写到回调接口即可 获取到用户的一些基础信息
> `client_id`     应用授权id
> `client_secret` 应用授权key

##### 如何申请应用授权
    
   * [github应用创建地址](https://github.com/settings/developers)
   * [gitee应用创建地址](https://gitee.com/oauth/applications)
   * [gitlab应用创建地址](https://gitlab.com/oauth/applications)
   * [微博应用创建地址](https://open.weibo.com/)
   
   
   
##### 建议

> 建议前端页面取请求 授权接口 后端做回调接口保存用户信息到mysql\session 即可


##### php项目如何使用？


    
## 授权方法

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
    
## 回调接口方法

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



##### 在 Thinkphp5中如何使用?

##### 注册两条路由

```php
//在路由文件新建两天路由
Route::get('authorization','api/TestController/authorization')->name('请求授权');
Route::get('gitee/callback','api/TestController/giteeCallback')->name('授权回调接口');

```

##### 配置文件
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


##### 返回的信息

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