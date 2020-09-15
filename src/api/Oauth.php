<?php
/**
 * Created by PhpStorm
 * User: pl
 * Date: 2020/9/15
 * Time: 14:57
 */

namespace Thirdparty\Src\Api;


trait Oauth
{
    private static  $api = [
        'github' => [
            ''
        ],
        'gitee' => [
            'code'         => 'https://gitee.com/oauth/authorize?client_id=%s&redirect_uri=%s&response_type=code',
            'access_token' => 'https://gitee.com/oauth/token?grant_type=authorization_code&code=%s&client_id=%s&redirect_uri=%s&client_secret=%s',
            'user' => 'https://gitee.com/api/v5/user?access_token=%s',
        ],
        'weibo' => [
            'code' => '',
            'access_token' => 'https://api.weibo.com/oauth2/access_token?client_id=%s&client_secret=%s&grant_type=authorization_code&code=%s&redirect_uri=%s',
            'uid' => 'https://api.weibo.com/oauth2/get_token_info?access_token=',
            'user' => 'https://api.weibo.com/2/users/show.json?uid=%s&access_token=%s',
        ]
    ];


    /**
     * 获取access_token
     * @param $deiver
     * @param $config
     * @param $filed
     * @return string
     */

    public function getRelevantUrl($deiver,$config,$filed)
    {
        return sprintf(self::$api[$deiver][$filed],$_GET['code'],$config['client_id'],$config['redirect_url'],$config['client_secret']);
    }


    public function getUidUrl($access_token)
    {
        return sprintf(self::$api[$this->deiver]['uid'],$access_token);
    }

    public function getUserInfoUrl($access_token,$uid ='')
    {
        if($this->deiver == 'weibo') {
            return sprintf(self::$api[$this->deiver]['user'],$uid,$access_token);
        }
    }
}