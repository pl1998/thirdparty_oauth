<?php
/**
 * Created by PhpStorm
 * User: pl
 * Date: 2020/9/15
 * Time: 9:46
 */

use Thirdparty\Src\SocialiteAuth;


require 'vendor/autoload.php';

require 'Autoloader.php';



$aouth = new SocialiteAuth();

//$user = $aouth->driver('gitee',[
//    'client_id' => '74ee75f10437b4862d653a682111e5ddca1d24422f00ec884453ad232ae07ac9',
//    'redirect_url' => 'http://oauth.test/test.php',
//    'client_secret' => ''
//
//])->user();

//$user = $aouth->driver('weibo',[
//    'client_id' => '1949419161',
//    'redirect_url' => 'http://oauth.test/test.php',
//    'client_secret' => ''
//
//])->user();

$user = $aouth->driver('gitlab',[
    'client_id' => '12c7e66df203caa44cf50608cec8c9ea43fe04aa1f8e02c1fc0a966784c61dcd',
    'redirect_url' => 'http://oauth.test/test.php',
    'client_secret' => ''

])->user();


$code = $aouth->redirect('github',[
    'client_id' => '74ee75f10437b4862d653a682111e5ddca1d24422f00ec884453ad232ae07ac9',
    'redirect_url' => 'http://oauth.test/test.php',
]);

//$user = $aouth->driver('github',[
//    'client_id' => '684a49aa60ce60372463',
//    'redirect_url' => 'http://oauth.test/test.php',
//    'client_secret' => ''
//
//])->user();

var_dump($user);


