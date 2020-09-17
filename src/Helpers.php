<?php
/**
 * Created by PhpStorm
 * User: pl
 * Date: 2020/9/17
 * Time: 10:16
 */

namespace Pl1998\ThirdpartyOauth;


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
            case 'github':
                $params       = explode('=',$aouth);
                $access_token = $params[1];
                $access_token = explode('&',$access_token);
                $access_token =  "Bearer ".$access_token[0];
                return $access_token;
                break;
            case 'gitlab':
                $aouth = json_decode($aouth,true);
                return "Bearer ".$aouth[$key];
                break;
            default:
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

    public static function intendedEffect(array  $array,$effect_array)
    {
        if(array_diff($array,$effect_array) == []) {
            return true;
        } else{
            return false;
        }

    }
}