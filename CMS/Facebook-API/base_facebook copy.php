<?php
require_once("facebook.php");

$config = array();
$config['appId'] = '422446111188481';
$config['secret'] = '2bd1f1a4a93855a30c661f52b39a01c9';

$facebook = new Facebook($config);


print_r($facebook);

?>