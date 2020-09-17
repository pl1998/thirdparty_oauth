<?php
/**
 * Created by PhpStorm
 * User: pl
 * Date: 2020/9/17
 * Time: 11:26.
 */

namespace Pl1998\ThirdpartyOauth\Handle;

use GuzzleHttp\Client;

class GitlabOauth
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
        $url = 'https://gitlab.example.com/oauth/authorize';

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
        $url = 'https://gitlab.example.com/oauth/token';

        return $this->client->request('POST', $url, [
            'form_params' => [
                'client_secret'=> $this->config['client_secret'],
                'code'         => $_GET['code'],
                'client_id'    => $this->config['client_id'],
                'redirect_uri' => $this->config['redirect_uri'],
            ],
        ])->getBody()->getContents();
    }

    public function getUserInfo($access_token)
    {
        $url = 'https://gitlab.example.com/api/v4/user';

        return $this->client->request('POST', $url, [
            'headers' => [
                'Authorization'=> $access_token,
            ],
        ])->getBody()->getContents();
    }
}
