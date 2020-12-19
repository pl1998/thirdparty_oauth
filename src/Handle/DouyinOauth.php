<?php

/*
 * This file is part of the pl1998/thirdparty_oauth.
 *
 * (c) pl1998<pltruenine@163.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Pl1998\ThirdpartyOauth\Handle;

use GuzzleHttp\Client;

class DouyinOauth implements Handle
{
    protected $client;
    protected $config;
    protected $authorization_url = 'https://open.douyin.com/platform/oauth/connect/';
    protected $token_url         = 'https://open.douyin.com/oauth/access_token/';
    protected $userinfo_url      = 'https://open.douyin.com/oauth/userinfo/';

    public function __construct($config)
    {
        $this->config = $config;
        $this->client = new Client();
    }

    public function authorization()
    {

        $query = array_filter([
            'response_type' => 'code',
            'client_key'    => $this->config['client_id'],
            'redirect_uri'  => $this->config['redirect_uri'],
            'scope'         => '',
            'state'         => 'https://6.mxin.ltd/login/qqcallback',
        ]);

        $url = $this->authorization_url . '?' . http_build_query($query);

        header('Location:' . $url);
        exit();
    }

    public function getAccessToken()
    {

        $query = array_filter([
            'client_key'    => $this->config['client_id'],
            'code'          => $_GET['code'],
            'grant_type'    => 'authorization_code',
            'client_secret' => $this->config['client_secret'],
            'redirect_uri'  => $this->config['redirect_uri'],

        ]);


        $res = json_decode($this->client->request('get', $this->token_url, [
            'query' => $query,
        ])->getBody()->getContents())->data;
        if (isset($res->access_token)) {
            $this->openid  = $res->open_id;
            $this->unionid = $res->unionid;

            return $res->access_token;
        } else {
            exit("获取 ACCESS_TOKEN 出错：" . $res);
        }

        return $res->access_token;
        exit;


    }

    public function getUserInfo($access_token): object
    {

        $query = array_filter([
            'open_id'      => $this->openid,
            'access_token' => $access_token,
        ]);

        $userinfo = json_decode($this->client->request('GET', $this->userinfo_url, [
            'query' => $query,
        ])->getBody()->getContents())->data;
        if (isset($userinfo->>open_id)) {
            $userinfo->openid  = $userinfo->open_id;
            $userinfo->unionid = $userinfo->union_id;
        } else {
            die('获取用户信息失败');
        }


        return $userinfo;
    }


}
