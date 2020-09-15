<?php

namespace Thirdparty\Src;
use phpDocumentor\Reflection\Types\Self_;
use Thirdparty\Src\Api\Socialite;
use Thirdparty\Src\Api\SocialiteApi;

/**
 * Created by PhpStorm
 * User: pl
 * Date: 2020/9/14
 * Time: 12:01
 */


class SocialiteAuth implements Socialite
{

    protected static $driver;

    protected  $json = [];

    private static $deiver = ['gitee','github','weibo'];

    public  function driver($deiver,array $config = [])
    {

        if(!in_array($deiver,self::$deiver)) {
            throw new \Exception("目前不支持 $deiver aouth");
        }


        if(Helpers::intendedEffect(array_keys($config)) == false) {
            throw new \Exception('参数错误');
        }

        $api    = new SocialiteApi($config,$deiver);

        $this->json = $api->getUserInfo()->getBody()->getContents();

        return $this;

    }

    /**
     * 获取用户信息
     * @return mixed
     */
    public function user()
    {
        return json_decode($this->json,true);
    }

}