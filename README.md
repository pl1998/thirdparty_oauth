<h1 align="center">ThirdpartyOauth</h1>

<p align="center">

<a href="https://packagist.org/packages/pltrue/thirdparty_oauth"><img src="https://img.shields.io/badge/license-MIT-green" /></a> 
[![Build Status](https://travis-ci.org/pl1998/thirdparty_oauth.svg?branch=master)](https://travis-ci.org/pl1998/thirdparty_oauth)
![StyleCI build status](https://github.styleci.io/repos/295677202/shield)
<a href="https://packagist.org/packages/pltrue/thirdparty_oauth"><img src="https://img.shields.io/badge/php-v7.0+-blue" /></a> 
<a href="https://packagist.org/packages/pltrue/thirdparty_oauth"><img src="https://img.shields.io/badge/downloads-37-brightgreen" /></a> 
</p>


<p>这是一个社会化登录的第三方登录扩展包 </p>

v2.0版本兼容 [Laravel-Octane](https://github.com/laravel/octane)




## 安装

使用 composer 安装: 

```shell
$ composer require pltrue/thirdparty_oauth "v1.7"
```

## 贡献
你可以通过以下三种方式做出贡献:

1. bug反馈   [issue tracker](https://github.com/pl1998/thirdparty_oauth/issues).
2. 回答问题或修复错误 [issue tracker](https://github.com/pl1998/thirdparty_oauth/issues).
3. 贡献新特性或更新wiki。

## 目前支持第三方登录

 * 1.QQ(app/h5/web)
 * 2.微信(web扫码)
 * 3.微博(app/h5/web)
 * 4.小米(web/h5)
 * 5.抖音
 * 6.世纪互联(微软)
 * 7.微软
 * 8.gitee
 * 9.github
 * 10.gitlab
 * 11.google
 * 12.line

<hr>


## 贡献者🎉、以及合并日志

| 日期   | 更新级别 | 更新内容      | 贡献者 | 当前状态 |
| ------| -------- | --------- | ---- | ---- |
| 2020-12-06|   fix 、feat   | 新增`Microsoft`登录 修复微信、QQ的bug   | [742481030](https://github.com/742481030)     | 已合并到master分支     |
| 2020-12-08|   feat         | 新增`小米账户`登录    | [742481030](https://github.com/742481030)  | 已合并到master分支     |
| 2020-12-09|   feat         | 新增`google账户`登录    | [742481030](https://github.com/742481030)  | 已合并到master分支     |
| 2020-12-10|   feat         | 新增`华为账户`登录    | [742481030](https://github.com/742481030)  | 已合并到master分支     |
| 2020-12-11|   fix         | qq统一使用json接口    | [742481030](https://github.com/742481030)  | 已合并到master分支     |
| 2020-12-12|   feat         | 新增`抖音账户`登录    | [742481030](https://github.com/742481030)  | 已合并到master分支     |
| 2020-12-13|   feat         | 新增`Line账户`登录    | [742481030](https://github.com/742481030)  | 已合并到master分支     |
| 2020-12-29|   fix         | 增加兼容支付宝qq app混合应用兼容   | [742481030](https://github.com/742481030)  | 已合并到master分支     |
| 2020-12-29|   feat         | 新增`京东账户`登录    | [742481030](https://github.com/742481030)  | 已合并到master分支     |
| 2020-12-29|   fix          | 兼容laravel7*    | [pl1998](https://github.com/pl1998)  | 已合并到master分支     |
| 2021-04-19|   feat          | 兼容laravel8* 支持laravel发布配置文件   | [pl1998](https://github.com/pl1998)  | 已合并到master分支     |
| 2021-05-15|   feat          | v2.0版本 兼容laravel8* Laravel Octane 常驻内存   | [pl1998](https://github.com/pl1998)  | 已合并到master分支     |


## 如何申请应用授权？
   * [github应用创建地址](https://github.com/settings/developers)
   * [gitee应用创建地址](https://gitee.com/oauth/applications)
   * [gitlab应用创建地址](https://gitlab.com/oauth/applications)
   * [微博应用创建地址](https://open.weibo.com/)
   * [microcoft应用创建地址](https://azure.com/)
   * [QQ互联创建地址](https://connect.qq.com/index.html)
   * [小米应用](https://dev.mi.com/console/)
   * [google应用](https://console.developers.google.com)
   * [京东应用](https://jos.jd.com/)
   

##### 参数说明 

>   <kbd>redirect_url</kbd>   回调地址将使用方法写到回调接口即可 获取到用户的一些基础信息 <br/>
>   <kbd>client_id</kbd>     应用授权id <br/>
>   <kbd>client_secret</kbd>  应用授权key <br/>
>    所有支持平台的类型 `github` `gitee` `gitlab` `weibo` `qq` `weixin` `alipay` `microsoft` 配置文件下标一致



##### 建议

> 前后端分离下建议前端直接请求授权接口，后端负责回调接口即可

#### PHP-FPM下安装
```shell script
composer require pltrue/thirdparty_oauth "v1.7"
```
#### Laravel Octane  常驻内存下安装
```shell script
composer require pltrue/thirdparty_oauth "v2.0"
```
#### 发布配置

```shell script
php artisan vendor:publish --tag=oauth 
```

### 简单使用

   * 授权方法
````php
$api = new SocialiteAuth(config('oauth.github'));
return $api->redirect('github');

````
   *回调方法

```php
public function githubCallBack()
    {
        $auth = new SocialiteAuth(config('oauth.github'));
        $user = $auth->driver('github')->user();

        $users = User::query()->where('oauth_id',$user->id)->first();

        if(!$users){
            $users= User::query()->create([
                'name'=> empty($user->name) ?? $user->login,
                'email'=>$user->email,
                'avatar'=>$user->avatar_url,
                'oauth_id'=>$user->id,
                'bound_oauth'=>1
            ]);
        }
        return $this->respondWithToken($users);
    }
```

## 返回示例

![在这里插入图片描述](https://img-blog.csdnimg.cn/20210115174351473.png?x-oss-process=image/watermark,type_ZmFuZ3poZW5naGVpdGk,shadow_10,text_aHR0cHM6Ly9ibG9nLmNzZG4ubmV0L3FxXzQyMDMyMTE3,size_16,color_FFFFFF,t_70#pic_center)

<br/>

## License
<hr>
MIT
