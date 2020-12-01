<?php

/*
 * This file is part of the pl1998/thirdparty_oauth.
 *
 * (c) pl1998<pltruenine@163.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Pl1998\ThirdpartyOauth\Api;

use Pl1998\ThirdpartyOauth\Handle\GiteeOauth;
use Pl1998\ThirdpartyOauth\Handle\GithubOauth;
use Pl1998\ThirdpartyOauth\Handle\GitlabOauth;
use Pl1998\ThirdpartyOauth\Handle\QqOauth;
use Pl1998\ThirdpartyOauth\Handle\WeiboOauth;
use Pl1998\ThirdpartyOauth\Handle\WeiXinOauth;
use Pl1998\ThirdpartyOauth\Handle\MicrosoftOauth;
use Pl1998\ThirdpartyOauth\Helpers;

class SocialiteApi implements OauthLinterface
{
    protected $api;

    protected $deiver;

    public function __construct($deiver, array $config)
    {
        $this->deiver = $deiver;
        switch ($deiver) {
            case 'github':
               return $this->api = new GithubOauth($config);
                break;
            case 'weibo':
                return $this->api = new WeiboOauth($config);
                break;
            case 'gitlab':
                return $this->api = new GitlabOauth($config);
                break;
            case 'gitee':
                return $this->api = new GiteeOauth($config);
                break;
            case 'weixin':
                return $this->api = new WeiXinOauth($config);
                break;
            case 'qq':
                return $this->api = new QqOauth($config);
                break;
            case 'microsoft':
                return $this->api = new MicrosoftOauth($config);
                break;
        }
    }

    public function authorization()
    {
        return $this->api->authorization();
    }

    public function getAccessToken()
    {
        return $this->api->getAccessToken();
    }

    public function getUserInfo()
    {
        $aouth = $this->getAccessToken();

        if ('weixin' == $this->deiver) {
            return $this->api->getUserInfo(json_decode($aouth, true));
        } else {
            $access_token = Helpers::getAccessToken($this->deiver, $aouth);

            return $this->api->getUserInfo($access_token);
        }
    }
}
