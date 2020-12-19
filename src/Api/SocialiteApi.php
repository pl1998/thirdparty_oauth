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

use Pl1998\ThirdpartyOauth\Handle\AlipayOauth;
use Pl1998\ThirdpartyOauth\Handle\DouyinOauth;
use Pl1998\ThirdpartyOauth\Handle\GiteeOauth;
use Pl1998\ThirdpartyOauth\Handle\QqOauth;
use Pl1998\ThirdpartyOauth\Handle\GoogleOauth;
use Pl1998\ThirdpartyOauth\Handle\GithubOauth;
use Pl1998\ThirdpartyOauth\Handle\GitlabOauth;
use Pl1998\ThirdpartyOauth\Handle\WeiXinOauth;
use Pl1998\ThirdpartyOauth\Handle\WeiboOauth;
use Pl1998\ThirdpartyOauth\Handle\XiaomiOauth;
use Pl1998\ThirdpartyOauth\Handle\HuaweiOauth;
use Pl1998\ThirdpartyOauth\Handle\MicrosoftOauth;
use Pl1998\ThirdpartyOauth\Handle\line;
use Pl1998\ThirdpartyOauth\Handle\TwitterOauth;
use Pl1998\ThirdpartyOauth\Handle\FacebookOauth;

use Pl1998\ThirdpartyOauth\Helpers;

class SocialiteApi implements OauthLinterface
{
    protected $api;

    protected $deiver;

    public function __construct($deiver, array $config)
    {
        $this->deiver = $deiver;
        switch ($deiver) {
            case 'alipay':
               return $this->api = new AlipayOauth($config);
                break;
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
                 case 'xiaomi':
                return $this->api = new XiaomiOauth($config);
                break;
            case 'google':
                return $this->api = new GoogleOauth($config);
                break;
            case 'huawei':
                return $this->api = new HuaweiOauth($config);
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
        } elseif ('microsoft' == $this->deiver) {
            $access_token = Helpers::getAccessToken($this->deiver, $aouth['$access_token']);
            $userinfo = $this->api->getUserInfo($access_token);
            $userinfo->unionid = $aouth['unionid'];
            //$userinfo->openid=$aouth['sub'];
            return $userinfo;
        } else {
            $access_token = Helpers::getAccessToken($this->deiver, $aouth);

            return $this->api->getUserInfo($access_token);
        }
    }
}
