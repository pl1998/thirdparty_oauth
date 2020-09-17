<?php
/**
 * Created by PhpStorm
 * User: pl
 * Date: 2020/9/17
 * Time: 11:45
 */



$api = new \Pl1998\ThirdpartyOauth\SocialiteAuth([
    'client_id' => '12c7e66df203caa44cf50608cec8c9ea43fe04aa1f8e02c1fc0a966784c61dcd',
    'redirect_uri' => 'http://oauth.test/test.php',
    'client_secret' => '08fea056f9dc0f84eb691284bcea0520726d3f6fe25c1d525be8a25b67649420'
]);

$user = $api->driver('gitlab')->user();

var_dump($user);