<?php
/**This file is defined the gobal variables by define() method*/

//Gobal path: this is very much important for global path setting. it contorls the global css and js
define("GlobalPath", "http://b2c.com.au"); //http://127.0.0.1/B2C has to have changed while website has been unveiled
//Database options
define("HostName","127.0.0.1");//hostname for database
define("UserName",'root');//usename for datebase
define("Password",'4414463');//password for database
define("Database",'B2C');//selected database for database
//set the session time framwork
session_set_cookie_params('1000');

?>