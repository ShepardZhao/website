<?php
session_start();
//Gobal session define
//Below part's function is that import all classes
require_once 'BackEnd-controller/BackEnd-class.php';
require_once 'FrontEnd-controller/FrontEnd-class.php';
//import glibal-define.php such database connection;
require_once 'Gobal-define.php';
require_once 'Facebook-API/facebook.php';


/**************************************Declare BasicSystemInfo ******************************************/
$BasicSystemInfoClass=new BasicSystemInfo();
/**************************************Declare database ******************************************/
$Mysql_Connection=new DataBase(HostName,UserName,Password,Database); //mysql_connection is the gobal variable
/**************************************Declare BasicSetting ******************************************/
$BasicSettingClass=new BasicSetting($Mysql_Connection);
/**************************************Declare Tags ******************************************/
$TagsClass=new Tags($Mysql_Connection);
/**************************************Declare Location ******************************************/
$LocationClass=new Location($Mysql_Connection);
/**************************************Declare User ******************************************/
$UserClass=new User($Mysql_Connection);
/**************************************Declare Login ******************************************/
$LoginClass=new Login($Mysql_Connection);
/**************************************Declare MailSetting*************************************/
$MailsettingClass=new Mailsetting($Mysql_Connection);
/**************************************Declare TempActivation***********************************/
$TempActivationClass=new TempActivationClass($Mysql_Connection);
/*****************************Declare RegisterUserClass **************/
$RegisterUserClass=new RegisterUser($Mysql_Connection);
/***********************************Declare LoginedIN class*************************/
$LoginedInClass=new LoginedIn($Mysql_Connection);//deal with facebook and normal user
/***********************************Declare Restaurant class************************/
$ResturantsRegClass=new ResturantsReg($Mysql_Connection);
/***********************************Declare UserAddressBook class*************************/
$MyaddressBookClass=new MyaddressBook($Mysql_Connection);
/**********************************Declare Initial location display class ************************/
$InitialLocationSelectClass=new InitialLocationSelect($Mysql_Connection);
/**********************************Declare Initial User Address Book class ************************/
$InitialUserMyaddressBookClass=new InitialUserMyaddressBook($Mysql_Connection);
/*********************************Declare Restartuant class***************************************/
$RestartuantClass=new Restartuant($Mysql_Connection);
/*********************************Declare Cuisine class******************************************/
$CuisineClass=new Cuisine($Mysql_Connection);
/*********************************Declare Selection Tags***************************************/
$OrderSelectionTagsClass= new OrderSelectionTags($Mysql_Connection);
/********************************Declare JsonReturnOrDeal**************************************/
$JsonReturnOrDealclass= new JsonReturnOrDeal($Mysql_Connection);
/*******************************Declare favourite***********************************************/
$Favoriteclass=new favourite($Mysql_Connection);
/*******************************Declare CuisineComemnt******************************************/
$CuisineComemnt=new CuisineComemnt($Mysql_Connection);
/*******************************Declare ThumbLikeOrDislike*************************************/
$ThumbLikeOrDislikeclass= new ThumbLikeOrDislike($Mysql_Connection);

/**************************************Extendedd define******************************************/
//Gobal path: this is very much important for global path setting. it contorls the global css and js
define("GlobalPath",$BasicSettingClass->pushSettingData()['WebUrl']); //http://127.0.0.1/B2C has to have changed while website has been unveiled

?>