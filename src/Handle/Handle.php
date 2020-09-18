<?php
/**
 * Created by PhpStorm
 * User: pl
 * Date: 2020/9/18
 * Time: 11:48
 */

namespace Pl1998\ThirdpartyOauth\Handle;


interface Handle
{
    public function authorization();

    public function getAccessToken();

    public function getUserInfo($access_token);
}