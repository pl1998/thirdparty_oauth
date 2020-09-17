<?php
/**
 * Created by PhpStorm
 * User: pl
 * Date: 2020/9/17
 * Time: 10:29.
 */

namespace Pl1998\ThirdpartyOauth;

interface Socialite
{
    public function driver($deiver);

    public function user();

    public function redirect($deiver);
}
