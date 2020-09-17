<?php
/**
 * Created by PhpStorm
 * User: pl
 * Date: 2020/9/17
 * Time: 11:02
 */

namespace Pl1998\ThirdpartyOauth\Api;


interface OauthLinterface
{
    public function authorization();
    public function getAccessToken();
    public function getUserInfo();
}