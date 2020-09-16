<?php

namespace Thirdparty\Src;
use function GuzzleHttp\Promise\some;

/**
 * Created by PhpStorm
 * User: pl
 * Date: 2020/9/14
 * Time: 11:05
 */

class Helpers
{
    /**
     * @param $aouth
     * @param string $key
     * @return mixed
     */
    public static function getAccessToken($deiver,$aouth,$key='access_token')
    {

        switch ($deiver) {
            case 'gitee':
                $aouth = json_decode($aouth,true);
                return  $aouth[$key];
                break;
            case 'github':
                $params       = explode('=',$aouth);
                $access_token = $params[1];
                $access_token = explode('&',$access_token);
                $access_token = $access_token[0];
                return "Bearer ".$access_token;
                break;
            case 'weibo':
                $aouth = json_decode($aouth,true);
                return  $aouth[$key];
                break;
        }
    }

    /**
     * 判断两个数组是否相同
     * @param array $array
     * @return bool
     */

    public static function intendedEffect(array  $array)
    {
        $effect_array = ['client_id','redirect_url','client_secret'];


        if(array_diff($array,$effect_array) == []) {
            return true;
        } else{
            return false;
        }

    }

}