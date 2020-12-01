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

class MicrosoftOauth implements Handle
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
        $url = 'https://login.chinacloudapi.cn/common/oauth2/v2.0/authorize';
        $query = array_filter([
            'response_type' => 'code',
            'client_id' => $this->config['client_id'],
            'redirect_uri' => $this->config['redirect_uri'],
            'scope' => "User.Read",
            'state' => 'https://6.mxin.ltd/login/mscallback',
        ]);

        $url = $url.'?'.http_build_query($query);

       header('Location:'.$url);
        exit();
    }

    public function getAccessToken()
    {
        $url = 'https://login.chinacloudapi.cn/common/oauth2/v2.0/token';

        $query = array_filter([
            'client_id' => $this->config['client_id'],
            'code' => $_GET['code'],
            'grant_type' => 'authorization_code',
            'client_secret' => $this->config['client_secret'],
            'redirect_uri' => $this->config['redirect_uri'],
        ]);

        return
         $this->client->request('POST', $url, [
            'form_params' => $query,
        ])->getBody()->getContents();
    }

    public function getUserInfo($access_token)
    {
         $url = '';
 return $this->client->request('GET', "https://microsoftgraph.chinacloudapi.cn/v1.0/me", [
            'headers' => [
                'Authorization' => $access_token,
            ],
        ])->getBody()->getContents();

    }

    public function getUid($access_token)
    {
     
    }
}
