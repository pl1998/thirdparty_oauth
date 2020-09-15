<?php
/**
 * Created by PhpStorm
 * User: pl
 * Date: 2020/9/15
 * Time: 9:53
 */

namespace Thirdparty\Src\Api;


use GuzzleHttp\Client;
use Thirdparty\Src\Helpers;
use Thirdparty\src\ParameterException;



class SocialiteApi
{

    use Oauth;


    private $deiver;

    /**
     * 授权的api
     * @var array
     */
    protected $config;

    /**
     * 客户端
     * @var object
     */
    protected $client;


    /**
     * 实例化请求api
     * SocialiteApi constructor.
     * @param $client_id
     * @param $client_secret
     * @param $callback_url
     */
    public function __construct(array $config,$deiver)
    {

        $this->config = $config;
        $this->client = new Client();
        $this->deiver = $deiver;

        if(in_array(strtolower($deiver),self::$api)) {
            throw new ParameterException();
        }

    }

    private function getAccessToken()
    {
       $url = $this->getRelevantUrl($this->deiver,$this->config,'access_token');

       switch ($this->deiver) {
           case 'gitee':
               return $this->client->request('POST',$url,[
                   'form_params' => [
                       'client_secret'=>$this->config['client_secret']
                   ]
               ]);
               break;
           case 'weibo':
               return $this->client->post($url);
               break;
       }
    }


    public function getUserInfo()
    {
        $aouth        =  $this->getAccessToken()->getBody()->getContents();

        $access_token =  Helpers::getAccessToken($this->deiver,$aouth,'access_token');

        switch ($this->deiver) {
            case 'gitee':
                $url          =  sprintf(self::$api[$this->deiver]['user'],$access_token);
                break;
            case 'weibo':
                $uid = $this->getUid($access_token);
                $url = $this->getUserInfoUrl($access_token,$uid);
                break;
        }

        return $this->client->request('GET',$url);

    }

    /**
     * 可能需要用到的方法
     */
    public function getUid($access_token)
    {
        $result = $this->client->post($this->getUidUrl($access_token));
        $result = json_decode($result->getBody()->getContents(),true);
        return $result['uid'];
    }
}