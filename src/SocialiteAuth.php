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

    /**
     * 用户json数据
     * @var
     */
    protected  $userJson;

    /**
     * 目前支持的授权平台
     * @var string[]
     */
    private static $deiver = ['gitee','github','weibo'];

    /**
     * 获取回调地址信息
     * @param $deiver
     * @param array $config
     * @return $this|int
     * @throws \Exception
     */
    public  function driver($deiver,array $config = [])
    {
        if(!in_array($deiver,self::$deiver)) {
            throw new \Exception("目前不支持 $deiver");
        }

        if(strtolower($deiver) == 'redirect') {
            return $this->redirect();
        }

        if(Helpers::intendedEffect(array_keys($config)) == false) {
            throw new \Exception('参数错误');
        }

        $api    = new SocialiteApi($config,$deiver);

        $this->userJson = $api->getUserInfo()->getBody()->getContents();

        return $this;
    }

    /**
     * 获取用户信息
     * @return mixed
     */
    public function user()
    {
        return $this->userJson;
    }

    /**
     * 执行授权请求
     * @param $deiver
     * @param array $config
     * @return int
     */
    public function redirect($deiver,array  $config = [])
    {
        $api        = new SocialiteApi($deiver,$config);
        $httpcCode   = $api->authorization()->getStatusCode();
        return $httpcCode ;
    }

}