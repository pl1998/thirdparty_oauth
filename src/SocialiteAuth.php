<?php

/*
 * This file is part of the pl1998/thirdparty_oauth.
 *
 * (c) pl1998<pltruenine@163.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Pl1998\ThirdpartyOauth;

use Pl1998\ThirdpartyOauth\Api\SocialiteApi;
use Pl1998\ThirdpartyOauth\Exceptions\InvalidArgumentException;

class SocialiteAuth implements Socialite
{
    /**
     * 用户json数据.
     *
     * @var
     */
    protected $userJson;

    /**
     * 目前支持的授权平台.
     *
     * @var string[]
     */
    private static $deiver = ['gitee', 'github', 'weibo', 'gitlab', 'qq', 'weixin','microsoft','alipay'];

    /**
     * 配置文件.
     *
     * @var array
     */
    protected $config = [];

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * 获取回调地址信息.
     *
     * @param $deiver
     * @param array $config
     *
     * @throws InvalidArgumentException
     *
     * @return $this
     */
    public function driver($deiver)
    {
        //兼容laravel app容器参数注入
        if (array_key_exists($deiver, $this->config)) {
            $this->config = $this->config[$deiver];
        }

        $this->verified($deiver);

        $api = new SocialiteApi($deiver, $this->config);

        $this->userJson = $api->getUserInfo();

        return $this;
    }

    /**
     * 获取用户信息.
     *
     * @return mixed
     */
    public function user()
    {
        return $this->userJson;
    }

    /**
     * 执行授权请求
     *
     * @param $deiver
     * @param array $config
     *
     * @return int
     */
    public function redirect($deiver)
    {
        //该方法兼容laravel app容器参数注入

        if (array_key_exists($deiver, $this->config)) {
            $this->config = $this->config[$deiver];
        }

        $api = new SocialiteApi($deiver, $this->config);
        $httpcCode = $api->authorization();

        return $httpcCode;
    }

    /**
     * 效验参数方法.
     *
     * @param $deiver
     *
     * @throws InvalidArgumentException
     */
    private function verified($deiver)
    {
        $parameter = ['client_id', 'redirect_uri', 'client_secret'];

        if (!in_array($deiver, self::$deiver)) {
            throw new InvalidArgumentException('目前不支持该平台');
        }
        
        if($deiver =='microsoft') array_push($parameter,'region');        
        
     
        if (false == Helpers::intendedEffect(array_keys($this->config), $parameter)) {
            throw new InvalidArgumentException('配置信息错误');
        }
    }
}
