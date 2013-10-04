<?php

include '../GobalConnection.php';

if($_SERVER['REQUEST_METHOD']==='POST'){
/**************************************BasicSetting Controller********************************************************/
 if(isset($_POST['SiteName'])&&isset($_POST['SiteDescr'])&&isset($_POST['SiteSiteUrl'])&&isset($_POST['SiteSiteEmail'])&&isset($_POST['SiteSiteStatus'])&&isset($_POST['SitePolicy'])){
   echo  $BasicSettingClass->getSettingData($_POST['SiteName'],$_POST['SiteDescr'],$_POST['SiteSiteUrl'],$_POST['SiteSiteEmail'],$_POST['SiteSiteStatus'],$_POST['SitePolicy']);
 }

 /**************************************Tags Controller***********************************************************/

    /********************************Refresh Data*************************************/
 if($_POST['RefreshTagsTableName'] && $_POST['RefreshTagsName']){
        echo $TagsClass->outPutRestaurantTags($_POST['RefreshTagsName'],$_POST['RefreshTagsTableName']);
    }
    /********************************Set Tags******************************/
 else if(isset($_POST['TagsTableName']) && isset($_POST['TagsID']) && isset($_POST['TagsValue'])&& $_POST['DeleteCondition']==='False' && isset($_POST['IndexID'])){
        echo $TagsClass->SetTags($_POST['TagsTableName'],$_POST['TagsID'],$_POST['TagsValue'],$_POST['IndexID']);
  }
    /********************************Delete Data*************************************/
 else if(isset($_POST['TagsTableName']) && isset($_POST['TagsID']) && isset($_POST['TagsValue'])&& $_POST['DeleteCondition']==='True' && isset($_POST['IndexID'])){
        echo $TagsClass->DeleteTags($_POST['TagsTableName'],$_POST['TagsID'],$_POST['TagsValue'],$_POST['IndexID']);
  }


/**************************************Location Controller********************************************************/

if((isset($_POST['RootLocationPic']) && isset($_POST['RootLocation'])) ||isset($_POST['SubLocation'])){
   $RootLocation=$_POST['RootLocation'];
   $SubLocation=$_POST['SubLocation'];
   echo $LocationClass->GetAddLocation($_POST['RootLocationPic'],serialize($RootLocation),serialize($SubLocation)); //add new Location into the database
}

if($_POST['ReFreshList']==="ReFreshLocation"){
    $LocationClass->CmsDisplay();//Display the result at the CMS Location page
}

if(isset($_POST['GetDeleteLocationID'])){//delete
    $GetDeleteLocationID=$_POST['GetDeleteLocationID'];
    echo $LocationClass->getIDToDelete($GetDeleteLocationID);

}
if(isset($_POST['GetModifyLocationID'])){//modify display
    $GetModifyLocationID=$_POST['GetModifyLocationID'];
    $LocationClass->ModifyLocation($GetModifyLocationID);

}
if(isset($_POST['GetID']) && isset($_POST['ChangeRootLocation']) && isset($_POST['ChangeSubLocation'])){

    $GetModifyLocationID=$_POST['GetID'];
    $GetNewRootLocation=$_POST['ChangeRootLocation'];
    $GetNewRootSubLocation=$_POST['ChangeSubLocation'];
    echo $LocationClass->pushModifyLocation(serialize($GetNewRootLocation),serialize($GetNewRootSubLocation),$GetModifyLocationID);

}

/**************************************Administrator User Controller********************************************************/
//special Administraotr part
    if (isset($_POST['AdministratorID']) && isset($_POST['AdministratorName']) && isset($_POST['AdministratorPassword']) && isset($_POST['AdministratorEmail']) && isset($_POST['AdministratorPhone']) && isset($_POST['AdministratorPhotoPath']) && isset($_POST['AdministratorType'])){
       echo $UserClass->UpdateAdministratorinfo($_POST['AdministratorID'],$_POST['AdministratorName'],$_POST['AdministratorPassword'],$_POST['AdministratorEmail'],$_POST['AdministratorPhone'],$_POST['AdministratorPhotoPath'],$_POST['AdministratorType']);
    }

/**************************************User Login Controller********************************************************/
    if (isset($_POST['LoginUserName']) && isset($_POST['LoginUserPassword'])){
        echo $LoginClass->getLoginData($_POST['LoginUserName'],$_POST['LoginUserPassword']);
    }

/**************************************Email setting Controller********************************************************/
if(isset($_POST['ConstructOfActiveMail']) && isset($_POST['ConstructOfActiveMailContent']) && isset($_POST['UserMailActiveID'])&& isset($_POST['TitleOfConstructOfActiveMail'])){
        echo $MailsettingClass->GetParam_MailSetting($_POST['ConstructOfActiveMail'],$_POST['ConstructOfActiveMailContent'],$_POST['UserMailActiveID'],$_POST['TitleOfConstructOfActiveMail']);

}
/*************************************Register user info Update*************************************************/
    if(isset($_POST['GetCustomerUserID'])){

        //Add My location book
        if(isset($_POST['AddNickName']) && isset($_POST['AddPhone']) && isset($_POST['AddAdress'])){
           echo $MyaddressBookClass->GetParamOfMyaddressBook($_POST['GetCustomerUserID'],$_POST['AddNickName'],$_POST['AddPhone'],$_POST['AddAdress']);

        }
        if(isset($_POST['RemoveID'])){
            echo $MyaddressBookClass->RemoveMyaddressBook($_POST['GetCustomerUserID'],$_POST['RemoveID']);

        }
        if(isset($_POST['SetDefault'])){

            echo $MyaddressBookClass->SetMyaddressBook($_POST['GetCustomerUserID'],$_POST['SetDefault']);


        }

        if($_POST['Mode']==='1'){//register user's basic info updating
            echo $UserClass->UpdateRegUserBasicInfo($_POST['GetCustomerName'],$_POST['GetCustomerFirstName'],$_POST['GetCustomerLastName'],$_POST['GetCustomerPhone'],$_POST['GetCustomerMail'],$_POST['GetCustomerAddress'],$_POST['GetCustomerUserID']);
        }
        else if($_POST['Mode']==='2'){//register User's password info updating
            echo $UserClass->UpdateRegUserPassword($_POST['GetOldPassword'],$_POST['GetNewPassword'],$_POST['GetCustomerUserID']);

        }
        else if($_POST['Mode']==='3'){//register User's photo updating
            echo $UserClass->UpdateRegUserAvatar($_POST['CustomerPhotoPath'],$_POST['GetCustomerUserID']);

        }

    }

/************************************************User list*********************************************************/
    if(isset($_POST['GetUserEmail'])){//search userlist by mail
       echo $UserClass->DisplayUserListByEmail($_POST['GetUserEmail']);
    }

    if(isset($_POST['DeleteUserID'])){//delete User by userID
        echo $UserClass->DeleteUserByID($_POST['DeleteUserID']);

    }

}








?>