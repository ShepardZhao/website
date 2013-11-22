<?php

include '../GobalConnection.php';

if($_SERVER['REQUEST_METHOD']==='POST'){
/**************************************BasicSetting Controller********************************************************/
 if(isset($_POST['SiteName'])&&isset($_POST['SiteDescr'])&&isset($_POST['SiteSiteUrl'])&&isset($_POST['SiteSiteEmail'])&&isset($_POST['SiteSiteStatus'])&&isset($_POST['SitePolicy'])&&isset($_POST['DeliveryFee'])){
   echo  $BasicSettingClass->getSettingData($_POST['SiteName'],$_POST['SiteDescr'],$_POST['SiteSiteUrl'],$_POST['SiteSiteEmail'],$_POST['SiteSiteStatus'],$_POST['SitePolicy'],$_POST['DeliveryFee']);
 }

 /**************************************Tags Controller***********************************************************/

    /********************************Refresh Data*************************************/
 if($_POST['RefreshTagsTableName'] && $_POST['RefreshTagsName']){
        echo $TagsClass->outPutTags($_POST['RefreshTagsName'],$_POST['RefreshTagsTableName']);
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
           echo $MyaddressBookClass->GetParamOfMyaddressBook($_POST['GetCustomerUserID'],$_POST['AddNickName'],$_POST['AddPhone'],$_POST['AddAdress'],0);

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
/***********************************************Restaruant regisation*********************************************/
    if(isset($_POST['RegResturantEmail']) && isset($_POST['RegGetResturantPass']) && isset($_POST['RegisterStatus']) && isset($_POST['RegisterType'])){
        $ResturantRegisterID=$RegisterUserClass->GenerateRandomUserID();

        echo $ResturantsRegClass->ResturantRegisation($ResturantRegisterID,$_POST['RegResturantEmail'],$_POST['RegGetResturantPass'],$_POST['RegisterStatus'],$_POST['RegisterType']);
    }

/***********************************************Restaruant password changing***************************************/
    if(isset($_POST['BusAccount']) && isset($_POST['BusOldPassword']) && isset($_POST['BusNewPassword'])){
        echo $UserClass->UpdateRegUserPassword($_POST['BusOldPassword'],$_POST['BusNewPassword'],$_POST['BusAccount']);
    }
/*********************************************Restaruant info edit************************************************/
    if(isset($_POST['MyRestaurantEdit'])){
        echo $RestartuantClass->GetRestartuantParam($_POST['MyResUID'],$_POST['MyResID'],$_POST['MyResName'],$_POST['MyResDestailAddress'],$_POST['MyRootAddress'],$_POST['MyResContactName'],$_POST['MyResContactNumber'],$_POST['MyResAvailabilityTag'],$_POST['MyResCuisineTag'],$_POST['MyResOpeningHours'],$_POST['MyResRating'],$_POST['MyResReview']);
    }
/*********************************************Restaruant photo uploading******************************************/
    if(isset($_POST['RestaruantUID'])&& isset($_POST['RestaruantID']) && isset($_POST['RestaruantPhotoPath'])){
        echo $RestartuantClass->RestaruantPhotoUploader($_POST['RestaruantUID'],$_POST['RestaruantID'],$_POST['RestaruantPhotoPath']);
    }
/*********************************************Cuisine uploading*************************************************************/
    if(isset($_POST['CurrentResID']) && isset($_POST['CurrentCuisineName']) && isset($_POST['CurrentCuisineDes']) && isset($_POST['CurrentCuisinePrice']) && isset($_POST['CurrentCuisineAvali']) && isset($_POST['CurrentAvaliTag']) && isset($_POST['CurrentCusinTag']) && isset($_POST['CurrentCusinTypeTag']) && isset($_POST['CurrentCusinPriceTag']) && isset($_POST['CurrentCusinOrder'])){
        $tempCode=$RegisterUserClass->GenerateRandomUserID();
        $CuisineID='C'.$tempCode;
        echo $CuisineClass->getParamOfCuisine($CuisineID,$_POST['CurrentResID'],$_POST['CurrentCuisineName'],$_POST['CurrentCuisineDes'],$_POST['CurrentCuisinePrice'],$_POST['CurrentCuisineAvali'],$_POST['CurrentAvaliTag'],$_POST['CurrentCusinTag'],$_POST['CurrentCusinTypeTag'],$_POST['CurrentCusinPriceTag'],$_POST['CurrentCusinOrder']);
    }
/********************************************Cuisine modifying uploading*****************************************************/
    if(isset($_POST['UpCurrentCuisineID']) && isset($_POST['UpCurrentCuisineName']) && isset($_POST['UpCurrentCuisineDes']) && isset($_POST['UpCurrentCuisinePrice']) && isset($_POST['UpCurrentCuisineAvali']) && isset($_POST['CurrentAvaliTag']) && isset($_POST['CurrentCusinTag']) && isset($_POST['CurrentCusinTypeTag']) && isset($_POST['CurrentCusinPriceTag'])){
        echo $CuisineClass->UpdateFirstLevelCuisine($_POST['UpCurrentCuisineID'],$_POST['UpCurrentCuisineName'],$_POST['UpCurrentCuisineDes'],$_POST['UpCurrentCuisinePrice'],$_POST['UpCurrentCuisineAvali'],$_POST['CurrentAvaliTag'],$_POST['CurrentCusinTag'],$_POST['CurrentCusinTypeTag'],$_POST['CurrentCusinPriceTag']);
    }
/********************************************list Cuisine's data***************************************************/
    if(isset($_POST['ajaxCuisineList'])){ echo $CuisineClass->listCuisineTable($_POST['GetCurrentResID']);}
/********************************************Cuisine order check***************************************************/
    if(isset($_POST['GetOrginalOrder'])){echo $CuisineClass->CuisineOrderCheck($_POST['GetOrginalOrder'],$_POST['GetOrginalResID']);}
/********************************************Cuisine order reset***************************************************/
    if(isset($_POST['UpdateCuisineOrder']) && isset($_POST['ArrayOfCuisineOrder'])){echo $CuisineClass->RestAndUpdateOrderofCuisine($_POST['ArrayOfCuisineOrder']);}
/********************************************Second Cuisine Submit Width Add new*************************************************/
    if(isset($_POST['SetUpSecondLevel'])){echo $CuisineClass->CuisineSecondLevel($_POST['PassCuid'],$_POST['SecondLevelTitleAndContent']);}
/********************************************Second Cuisine Submit Width update*************************************************/
    if(isset($_POST['updateSetUpSecondLevel'])){echo $CuisineClass->CuisineSecondLevelWidthUpdate($_POST['updatePassCuid'],$_POST['updateKey'],$_POST['updateSecondLevelTitleAndContent']);}
/********************************************Delete current Cuisine inclduing second level**************************/
    if(isset($_POST['CuisineDeleteID'])){echo $CuisineClass->DeleteCuisine($_POST['CuisineDeleteID']);}
/********************************************Delete second level with Wrap (including title, and its names and prices)**************************/
    if(isset($_POST['SecondLevelWrapDelete'])){echo $CuisineClass->DeleteSecondWrap($_POST['SecondLevelWrapDelete']);}
/********************************************Delete inside of second level with Wrap (including title, and its names and prices)**************************/
    if(isset($_POST['DeleteInsideSecondLevel'])){echo $CuisineClass->DeleteInsideSecondLevel($_POST['getUniqueID'],$_POST['InsideName'],$_POST['InsidePrice']);}
/********************************************Cuisine photo uploading************************************************/
    if(isset($_POST['CuisinePhotoUploading'])&&isset($_POST['CuisineCuid'])&&isset($_POST['CuisinePhotoPath'])){echo $CuisineClass->CuisinePhotoUploadingAndUpdating($_POST['CuisineCuid'],$_POST['CuisinePhotoPath'],$_POST['OldPhotoPath']);}
/********************************************Added to favourite*****************************************************/
    if(isset($_POST['CuisineID'])&&isset($_POST['LoginUserID'])&&isset($_POST['AddedFavorite'])){echo $Favoriteclass->addedtoFavorite($_POST['LoginUserID'],$_POST['CuisineID'],$_POST['AddedFavorite']);}
/********************************************Added cuisine comment**************************************************/
    //added cuisine comment
    if(isset($_POST['CurrentCuisineID']) && isset($_POST['CurrentUserID']) && isset($_POST['Currentstars']) && isset($_POST['CurrentCommentContent'])){
        //prevent over comment
        $current= time();
        session_start();
        if($current - $_SESSION['SetUpCuisineCommentTime'] > 1200) { //limited user comment once with 20 min as a gap
            $CurrentDate = date("Y-m-d H:i:s");
            $like = 0;
            $dislike = 0;
            $tempCode=$RegisterUserClass->GenerateRandomUserID();
            $commentID = 'Cu'.$tempCode;
            $review = 0;
            echo $CuisineComemnt -> getCuisineCommentParam($_POST['CurrentUserID'], $_POST['CurrentCuisineID'], $commentID, intval($_POST['Currentstars']), $_POST['CurrentCommentContent'], $CurrentDate, intval($like), intval($dislike), intval($review));
        }
        else{
            echo 'Over Comment';
        }
    }

}








?>