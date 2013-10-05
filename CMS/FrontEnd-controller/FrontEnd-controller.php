<?php
include '../GobalConnection.php';
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


    //Normail user logined in

    if (isset($_POST['LoginedInEmail']) && isset($_POST['LoginedInPassword'])){

        echo $LoginedInClass->ValidNormalUserLogining($_POST['LoginedInEmail'],$_POST['LoginedInPassword']);

    }

    //select sub level of location
    if(isset($_POST['RootIDSelection'])){
        echo $InitialLocationSelectClass->GetSubLoaction($_POST['RootIDSelection']);
    }


}


?>