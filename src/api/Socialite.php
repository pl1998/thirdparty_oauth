<?php
/**
 * Created by PhpStorm
 * User: pl
 * Date: 2020/9/15
 * Time: 9:55
 */

namespace Thirdparty\Src\Api;


/**
 * 必须实现的两个方法
 * Interface Socialite
 * @package src\api
 */
interface Socialite
{

    public function driver($deiver);

    public function user();


    public function redirect($deiver);
}