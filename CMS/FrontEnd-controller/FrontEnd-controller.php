<?php
include '../Gobal-define.php';
include 'FrontEnd-class.php';

/***************************************************This file is FrontEnd controller******************************/
/**************************************Declare database  *************/
$Mysql_Connection=new DataBase(HostName,UserName,Password,Database); //mysql_connection is the gobal variable
/*****************************Declare the RegisterUserClass **************/
$RegisterUserClass=new RegisterUser($Mysql_Connection);


if($_SERVER['REQUEST_METHOD']==='POST'){
    //registerUser class
    if(isset($_POST['RegisterUserMail']) && isset($_POST['RegisterUserPassWord']) && isset($_POST['RegisterCaptcha']) ){
       $RegisterUserID=$RegisterUserClass->GenerateRandomUserID();
       $RegisterUserType='Users';//in this case, sets current register user type is users.
       session_start();
     if ($_POST['RegisterCaptcha']===$_SESSION['6_letters_code']){
      echo $RegisterUserClass->GetUserRegisterData($RegisterUserID,$_POST['RegisterUserMail'],$_POST['RegisterUserPassWord'],$RegisterUserType);
     }
       else{
           echo 'Captcha Error';

       }

    }





}


?>