<?php
/**
 * Created by PhpStorm
 * User: pl
 * Date: 2020/9/17
 * Time: 10:50
 */

namespace Pl1998\ThirdpartyOauth\Handle;


use GuzzleHttp\Client;


class GithubOauth
{

    protected $client;
    protected $config;

    protected $scope = 'user:email';


    public function __construct($config)
    {
        $this->config = $config;
        $this->client = new Client();

    }

    public function authorization()
    {
        $url = 'https://github.com/login/oauth/authorize';

        $query = array_filter([
            'client_id'     => $this->config['client_id'],
            'redirect_uri'  => $this->config['redirect_uri']
        ]);

        $url = $url.'?'.http_build_query($query);

        header('Location:'.$url);exit();

    }

    public function getAccessToken()
    {
        $url = 'https://github.com/login/oauth/access_token';

        return $this->client->request('POST',$url,[
            'form_params' => [
                'client_secret'=> $this->config['client_secret'],
                'code'         => $_GET['code'],
                'client_id'    => $this->config['client_id'],
                'redirect_uri' => $this->config['redirect_uri'],
            ]
        ])->getBody()->getContents();

    }

    public function getUserInfo($access_token)
    {

        $url      = 'https://api.github.com/user';
        return $this->client->request('GET',$url,[
            'headers' =>[
                'Authorization'=>$access_token
            ]
        ])->getBody()->getContents();
    }


}