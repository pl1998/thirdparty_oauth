<?php
/**
 * Created by PhpStorm
 * User: pl
 * Date: 2020/9/17
 * Time: 11:32.
 */

namespace Pl1998\ThirdpartyOauth\Handle;

use GuzzleHttp\Client;

class WeiboOauth
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
        $url = 'https://api.weibo.com/oauth2/authorize';

        $query = array_filter([
            'client_id'     => $this->config['client_id'],
            'redirect_uri'  => $this->config['redirect_uri'],
        ]);

        $url = $url.'?'.http_build_query($query);
        header('Location:'.$url);
        exit();
    }

    public function getAccessToken()
    {
        $url = 'https://api.weibo.com/oauth2/access_token';

        $query = array_filter([
            'client_id'     => $this->config['client_id'],
            'code'          => $_GET['code'],
            'client_secret' => $this->config['client_secret'],
            'redirect_uri'  => $this->config['redirect_uri'],
            'grant_type'    => 'authorization_code',
        ]);

        return $this->client->request('POST', $url, [
            'query' => $query,
        ])->getBody()->getContents();
    }

    public function getUserInfo($access_token)
    {
        $url = 'https://api.weibo.com/2/users/show.json?uid=%s&access_token=%s';

        $uid = $this->getUid($access_token);
        $query = array_filter([
            'uid'         => $uid,
            'access_token'=> $access_token,

        ]);

        return $this->client->request('GET', $url, [
            'query' => $query,
        ])->getBody()->getContents();
    }

    public function getUid($access_token)
    {
        $url = 'https://api.weibo.com/oauth2/get_token_info?access_token='.$access_token;
        $result = $this->client->post($url);
        $result = json_decode($result->getBody()->getContents(), true);

        return $result['uid'];
    }
}
