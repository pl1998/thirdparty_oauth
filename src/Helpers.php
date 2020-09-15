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
        $aouth = json_decode($aouth,true);
        switch ($deiver) {
            case 'gitee':
                return  $aouth['access_token'];
                break;
            case 'github':

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