<?php
/**
 * Created by PhpStorm
 * User: pl
 * Date: 2020/9/17
 * Time: 10:40
 */

namespace Pl1998\ThirdpartyOauth\Api;


use Pl1998\ThirdpartyOauth\Handle\GiteeOauth;
use Pl1998\ThirdpartyOauth\Handle\GithubOauth;
use Pl1998\ThirdpartyOauth\Handle\GitlabOauth;
use Pl1998\ThirdpartyOauth\Handle\WeiboOauth;
use Pl1998\ThirdpartyOauth\Helpers;

class SocialiteApi implements OauthLinterface
{

    protected $api;

    protected $deiver;

    public function __construct($deiver,array $config)
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

        $access_token = Helpers::getAccessToken($this->deiver,$aouth);

        return $this->api->getUserInfo($access_token);
    }

}