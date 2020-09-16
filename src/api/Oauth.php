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

    /**
     * 所有api接口
     * @var \string[][]
     */
    private static  $api = [
        'github' => [
            'authorization' => 'https://github.com/login/oauth/authorize?client_id=%s&redirect_uri=%s',
            'access_token' => 'https://github.com/login/oauth/access_token',
            'user' => 'https://api.github.com/user',
        ],
        'gitee' => [
            'authorization'         => 'https://gitee.com/oauth/authorize?client_id=%s&redirect_uri=%s&response_type=code',
            'access_token' => 'https://gitee.com/oauth/token?grant_type=authorization_code&code=%s&client_id=%s&redirect_uri=%s&client_secret=%s',
            'user' => 'https://gitee.com/api/v5/user?access_token=%s',
        ],
        'weibo' => [
            'authorization' => '',
            'access_token' => 'https://api.weibo.com/oauth2/access_token?client_id=%s&client_secret=%s&grant_type=authorization_code&code=%s&redirect_uri=%s',
            'uid' => 'https://api.weibo.com/oauth2/get_token_info?access_token=%s',
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
        switch ($deiver) {
            case 'gitee':
                return sprintf(self::$api[$deiver][$filed],$_GET['code'],$config['client_id'],$config['redirect_url'],$config['client_secret']);
                break;
            case 'weibo':
                return sprintf(self::$api[$deiver][$filed],$config['client_id'],$config['client_secret'],$_GET['code'],$config['redirect_url']);
            case 'github':
                return self::$api[$deiver][$filed];
                break;
        }

    }

    /**
     * 执行授权请求
     * @return string
     */
    public function getAuthorizationUrl()
    {
        return self::$api[$this->deiver]['authorization'];
    }

    /**
     * 获取微博用户uid
     * @param $access_token
     * @return string
     */
    public function getUidUrl($access_token)
    {
        return sprintf(self::$api[$this->deiver]['uid'],$access_token);
    }

    /**
     * @param $access_token
     * @param string $uid
     * @return string
     */
    public function getUserInfoUrl($access_token='',$uid ='')
    {
        switch ($this->deiver) {
            case 'gitee':
                return sprintf(self::$api[$this->deiver]['user'],$access_token);
                break;
            case 'weibo':
                return sprintf(self::$api[$this->deiver]['user'],$uid,$access_token);
                break;
            case 'github':
                return self::$api[$this->deiver]['user'];
                break;
        }

    }
}