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

class XiaomiOauth implements Handle
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
        $url = 'https://account.xiaomi.com/oauth2/authorize';
        $query = array_filter([
            'response_type' => 'code',
            'client_id' => $this->config['client_id'],
            'redirect_uri' => $this->config['redirect_uri'],
            'scope' => "1 3",
            'state' => '',
        ]);

        $url = $url.'?'.http_build_query($query);

       header('Location:'.$url);
        exit();
    }

    public function getAccessToken()
    {
        $url = 'https://account.xiaomi.com/oauth2/token';

        $query = array_filter([
            'client_id' => $this->config['client_id'],
            'code' => $_GET['code'],
            'grant_type' => 'authorization_code',
            'client_secret' => $this->config['client_secret'],
            'redirect_uri' => $this->config['redirect_uri'],
        ]);

        //return
        $ss=$this->client->request('get', $url, [
            'query' => $query,
        ])->getBody()->getContents();
    return  $res=  str_replace("&&&START&&&","",$ss);
        dump($res);
        exit;
    }

    public function getUserInfo($access_token)
    {
        $url = 'https://open.account.xiaomi.com/user/profile';

       
    
        $query = array_filter([
           
            'client_id' => $this->config['client_id'],
            'token' => $access_token,
        ]);
$this->getUnionid($access_token);
$userinfo=json_decode($this->client->request('GET', $url, [
            'query' => $query,
        ])->getBody()->getContents())->data;
      
        return $userinfo  ;
    }

private function getUnionid($access_token){
     $url = 'https://graph.qq.com/oauth2.0/me?access_token='.$access_token.'&unionid=1&fmt=json';
        $str = $this->client->get($url)->getBody()->getContents();
 return json_decode($str);
}
    public function getUid($access_token)
    {
       
    }
}
