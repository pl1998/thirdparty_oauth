<?php
/**
 * Created by PhpStorm
 * User: pl
 * Date: 2020/9/17
 * Time: 11:38.
 */

namespace Pl1998\ThirdpartyOauth\Handle;

use GuzzleHttp\Client;

class GiteeOauth
{
    protected $client;
    protected $config;

    public function __construct($config)
    {
        $this->config = $config;
        $this->client = new Client();
    }

    /**
     * 执行重定向.
     */
    public function authorization()
    {
        $url = 'https://gitee.com/oauth/authorize';

        $query = array_filter([
            'client_id'      => $this->config['client_id'],
            'redirect_uri'   => $this->config['redirect_uri'],
            'response_type'  => 'code',
        ]);

        $url = $url.'?'.http_build_query($query);

        header('Location:'.$url);
        exit();
    }

    public function getAccessToken()
    {
        $url = 'https://gitee.com/oauth/token';

        $query = array_filter([
            'client_id'      => $this->config['client_id'],
            'redirect_uri'   => $this->config['redirect_uri'],
            'code'           => $_GET['code'],
            'grant_type'     => 'authorization_code',
            'client_secret'  => $this->config['client_secret'],
        ]);

        return $this->client->request('POST', $url, [
            'query'=> $query,
        ])->getBody()->getContents();
    }

    public function getUserInfo($access_token)
    {
        $url = 'https://gitee.com/api/v5/user?access_token='.$access_token;

        return $this->client->get($url)->getBody()->getContents();
    }
}
