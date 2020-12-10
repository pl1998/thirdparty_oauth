<?php

/*
 * This file is part of the pl1998/thirdparty_oauth.
 *
 * (c) pl1998<pltruenine@163.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Pl1998\ThirdpartyOauth;

class Helpers
{
    /**
     * @param $aouth
     * @param string $key
     *
     * @return mixed
     */
    public static function getAccessToken($deiver, $aouth, $key = 'access_token')
    {
        switch ($deiver) {
            case 'github':
                $params = explode('=', $aouth);
                $access_token = $params[1];
                $access_token = explode('&', $access_token);
                $access_token = 'Bearer '.$access_token[0];
                return $access_token;
                break;
            case 'gitlab':
                $aouth = json_decode($aouth, true);
                return 'Bearer '.$aouth[$key];
                break;
            case 'qq':
                $params = [];
                parse_str($aouth, $params);
<<<<<<< HEAD
                return $params["access_token"];
=======

                return $params['access_token'];
>>>>>>> 1af42363515a78349a9765c8a4ebb10b9aa153d1
                break;
            case 'microsoft':
                return $aouth;
                break;
            case 'alipay':
                return json_decode($aouth)->alipay_system_oauth_token_response->access_token;
                break;
            default:
                $aouth = json_decode($aouth, true);
                return $aouth[$key];
                break;
        }
    }

    /**
     * 判断两个数组是否相同.
     *
     * @return bool
     */
    public static function intendedEffect(array $array, $effect_array)
    {
        if ([] == array_diff($array, $effect_array)) {
            return true;
        } else {
            return false;
        }
    }
}
