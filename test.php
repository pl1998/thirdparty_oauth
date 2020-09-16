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

$user = $aouth->driver('weibo',[
    'client_id' => '1949419161',
    'redirect_url' => 'http://oauth.test/test.php',
    'client_secret' => '38ad194c8302f42d8d6c7bc7704595e7'

])->user();


$code = $aouth->redirect('github',[
    'client_id' => '74ee75f10437b4862d653a682111e5ddca1d24422f00ec884453ad232ae07ac9',
    'redirect_url' => 'http://oauth.test/test.php',
]);

//$user = $aouth->driver('github',[
//    'client_id' => '684a49aa60ce60372463',
//    'redirect_url' => 'http://oauth.test/test.php',
//    'client_secret' => 'db6509a0d4b384e9432273274b9381e1ffb90bb6'
//
//])->user();

var_dump($user);


