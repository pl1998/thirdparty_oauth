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

class QqOauth implements Handle
{
    protected $client;
    protected $config;

    public function __construct($config)
    {
        $this->config = $config;
        $this->client = new Client();
    }

    public function authorization()
    {
        $url = 'https://graph.qq.com/oauth2.0/authorize';
        $query = array_filter([
            'response_type' => 'code',
            'client_id' => $this->config['client_id'],
            'redirect_uri' => $this->config['redirect_uri'],
            'scope' => "",
            'state' => 'state',
        ]);

        $url = $url.'?'.http_build_query($query);

       header('Location:'.$url);
        exit();
    }

    public function getAccessToken()
    {
        $url = 'https://graph.qq.com/oauth2.0/token?grant_type=authorization_code';

        $query = array_filter([
            'client_id' => $this->config['client_id'],
            'code' => $_GET['code'],
            'grant_type' => 'authorization_code',
            'client_secret' => $this->config['client_secret'],
            'redirect_uri' => $this->config['redirect_uri'],
        ]);

        return $this->client->request('get', $url, [
            'query' => $query,
        ])->getBody()->getContents();
    }

    public function getUserInfo($access_token)
    {
        $url = 'https://graph.qq.com/user/get_user_info';

        $result = $this->getUid($access_token);
      
        $query = array_filter([
            'openid' => $result->openid,
            'oauth_consumer_key' => $result->client_id,
            'access_token' => $access_token,
        ]);

        return $this->client->request('GET', $url, [
            'query' => $query,
        ])->getBody()->getContents();
    }

    public function getUid($access_token)
    {
        $url = 'https://graph.qq.com/oauth2.0/me?access_token='.$access_token;
        $str = $this->client->get($url)->getBody()->getContents();
 if (strpos($str, "callback") !== false)
     {
        $lpos = strpos($str, "(");
        $rpos = strrpos($str, ")");
        $str  = substr($str, $lpos + 1, $rpos - $lpos -1);
     }
     $user = json_decode($str);
     
        return $user;
    }
}
