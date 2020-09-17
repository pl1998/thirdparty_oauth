<?php
/**
 * Created by PhpStorm
 * User: pl
 * Date: 2020/9/17
 * Time: 10:29
 */

namespace Pl1998\ThirdpartyOauth;



use Pl1998\ThirdpartyOauth\Api\SocialiteApi;
use Pl1998\ThirdpartyOauth\Exceptions\InvalidArgumentException;


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

    private static $deiver = ['gitee','github','weibo','gitlab'];

    /**
     * 配置文件
     * @var array
     */
    protected $config = [];

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * 获取回调地址信息
     * @param $deiver
     * @param array $config
     * @return $this
     * @throws InvalidArgumentException
     */
    public  function driver($deiver)
    {

        $this->verified($deiver);

        $api    = new SocialiteApi($deiver,$this->config);

        $this->userJson = $api->getUserInfo();

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
    public function redirect($deiver)
    {

        $api    = new SocialiteApi($deiver,$this->config);
        $httpcCode   = $api->authorization();
        return $httpcCode ;
    }

    /**
     * 效验参数方法
     * @param $deiver
     * @throws InvalidArgumentException
     */
    private function verified($deiver)
    {
        $parameter =   ['client_id','redirect_uri','client_secret'];

        if(!in_array($deiver,self::$deiver)) {
            throw new InvalidArgumentException('目前不支持该平台');
        }

        if(Helpers::intendedEffect(array_keys($this->config),$parameter) == false) {
            throw new InvalidArgumentException('配置信息错误');
        }

        return;
    }
}