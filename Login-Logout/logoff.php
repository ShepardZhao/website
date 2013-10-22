<?php
require_once '../cms/GobalConnection.php';

session_start();
$_SESSION = array();


unset($_SESSION['LoginedUserID']);
unset($_SESSION['LoginedUserName']);
unset($_SESSION['LoginedUserPhoto']);


$facebook = new Facebook(array(
    'appId'  => '422446111188481',
    'secret' => '2bd1f1a4a93855a30c661f52b39a01c9',
));

setcookie('fbs_'.$facebook->getAppId(),'', time()-100, '/', 'www.b2c.com.au');
session_destroy();
header('Location: ../');



?>