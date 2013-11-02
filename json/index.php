<?php require_once '../CMS/GobalConnection.php'?>
<?php
if($_SERVER['REQUEST_METHOD']==='GET'){
/***************************************************define variables*************************************************/
//GetImageType: The default parameter is All.If you want to get different return values, you can use paramters.
//For example:?GetAllResAndCuis='yes' (Get all images and its info without condition)
//
    if($_GET['GetAllCuis']==='yes'){
      echo $JsonReturnOrDealclass->ReturnCuisine(); //this will reutrn json that contains cuisines' info including cuisine ID, name .... and its ResName, id
    }















}








?>