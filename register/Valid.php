<?php
    include '../CMS/GobalConnection.php';
    session_start();

    if(isset($_GET['UserID'])&& isset($_GET['a']) && isset($_GET['ust'])){
        $ComfirmedUserID=$UserClass->ValidActiveion($_GET['UserID']);
        $ComfirmedActiveCode=$TempActivationClass->ValideTemActiveCode($_GET['a']);
        if($ComfirmedUserID==='pass' && $ComfirmedActiveCode==='pass'){
           if($TempActivationClass->DeleteActiveCode($_GET['a'])===1){
            $result=$RegisterUserClass->ActiveAccount(base64_decode($_GET['UserID']),$_GET['ust']);

            echo '<script type="text/javascript">';
            echo "alert('Congratulation! You account has been $result');";
            echo 'window.location = "../index.php";';
            echo '</script>';
           }

        }
        else if ($ComfirmedUserID==='fail' || $ComfirmedActiveCode==='fail'){

            $PresentingEmail=$BasicSettingClass->pushSettingData()['EMail'];
            echo '<script type="text/javascript">';
            echo "alert('Sorry, your link is expired, please contact to Administrator with Mail: $PresentingEmail');";
            echo 'window.location = "../index.php";';
            echo '</script>';


        }


    }


?>