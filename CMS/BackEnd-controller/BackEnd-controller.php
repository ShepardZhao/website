<?php

include '../GobalConnection.php';

if($_SERVER['REQUEST_METHOD']==='POST'){
/**************************************BasicSetting Controller********************************************************/
 if(isset($_POST['SiteName'])&&isset($_POST['SiteDescr'])&&isset($_POST['SiteSiteUrl'])&&isset($_POST['SiteSiteEmail'])&&isset($_POST['SiteSiteStatus'])&&isset($_POST['SitePolicy'])){
   echo  $BasicSettingClass->getSettingData($_POST['SiteName'],$_POST['SiteDescr'],$_POST['SiteSiteUrl'],$_POST['SiteSiteEmail'],$_POST['SiteSiteStatus'],$_POST['SitePolicy']);
 }

 /**************************************Tags Controller***********************************************************/

    /********************************Refresh Data*************************************/
 if(isset($_POST['RefreshTagsTableName']) && isset($_POST['RefreshTagsName'])){
        echo $TagsClass->outPutTags($_POST['RefreshTagsName'],$_POST['RefreshTagsTableName']);
    }
    /********************************Set Tags******************************/
if(isset($_POST['TagsTableName']) && isset($_POST['TagsID']) && isset($_POST['TagsValue'])&& $_POST['DeleteCondition']==='False' && isset($_POST['IndexID'])){
        echo $TagsClass->SetTags($_POST['TagsTableName'],$_POST['TagsID'],$_POST['TagsValue'],$_POST['IndexID']);
  }
    /********************************Delete Data*************************************/
if(isset($_POST['TagsTableName']) && isset($_POST['TagsID']) && isset($_POST['TagsValue'])&& $_POST['DeleteCondition']==='True' && isset($_POST['IndexID'])){
        echo $TagsClass->DeleteTags($_POST['TagsTableName'],$_POST['TagsID'],$_POST['TagsValue'],$_POST['IndexID']);
  }


/**************************************Location Controller********************************************************/


if((isset($_POST['RootLocationID']) && isset($_POST['RootLocation'])) && isset($_POST['RootLocationPic']) && isset($_POST['SubLocation'])){
   echo $LocationClass->GetAddLocation($_POST['RootLocationID'],$_POST['RootLocation'],$_POST['RootLocationPic'],$_POST['SubLocation']); //add new Location into the database
}

if(isset($_POST['ReFreshList'])){
    $LocationClass->CmsDisplay();//Display the result at the CMS Location page
}

if(isset($_POST['GetDeleteRootLocationID']) && isset($_POST['GetDeleteSubLocationID'])){//delete
    echo $LocationClass->getIDToDelete($_POST['GetDeleteRootLocationID'],$_POST['GetDeleteSubLocationID']);

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
    if(isset($_POST['RegResturantEmail']) && isset($_POST['RegGetResturantPass']) && isset($_POST['RegisterStatus']) && isset($_POST['RegisterType']) && isset($_POST['RegisterPicpathPrefix'])){
        $ResturantRegisterID=$RegisterUserClass->GenerateRandomUserID();
        echo $ResturantsRegClass->ResturantRegisation($ResturantRegisterID,strtolower($_POST['RegResturantEmail']),$_POST['RegGetResturantPass'],$_POST['RegisterStatus'],$_POST['RegisterType'],$_POST['RegisterPicpathPrefix']);
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
/******************************************** Cuisine promotion ***************************************************/
    if(isset($_POST['Featured']) && isset($_POST['FeaturedID']) && isset($_POST['FeaturedType'])){echo $PromotionClass -> CuisinePromotion($_POST['FeaturedID'],$_POST['FeaturedType']);}
/******************************************** list promotion data **************************************************/
    if(isset($_POST['ajaxPromotionList']) && isset($_POST['GetCurrentResID'])){echo $PromotionClass -> listPromotion($_POST['GetCurrentResID']);}
/******************************************* Requesting Delete *****************************************************/
    if(isset($_POST['RequestingDeleteID'])){echo $PromotionClass -> RequestingDelete($_POST['RequestingDeleteID']);}
/********************************************Added into temp order list********************************************/
    if(isset($_POST['TempOrder']) && isset($_POST['CurrentUserID']) && isset($_POST['CurrentCuisineID']) && isset($_POST['CurrentResID']) && isset($_POST['CurrentCuisineName']) && isset($_POST['CurrentCuisinePicPath']) && isset($_POST['CurrentCuisinePrice']) && isset($_POST['CurrentCuisineSecondLevel'])){ $tempCode=$RegisterUserClass->GenerateRandomUserID(); $TempOderID = 'TM'.$tempCode; echo $classOrder -> AddedTOATempOrder($_POST['CurrentUserID'], $TempOderID, $_POST['CurrentCuisineID'],$_POST['CurrentResID'], $_POST['CurrentCuisineName'], $_POST['CurrentCuisinePicPath'], $_POST['CurrentCuisinePrice'],$_POST['CurrentCuisineSecondLevel']); }
/*******************************************Fetch Temp order Items ************************************************/
    if(isset($_POST['FetchTempOrderItems']) && isset($_POST['CurrentUserID'])){echo $classOrder -> GetTempItemsFromUserID($_POST['CurrentUserID']);}
/*******************************************CancelCurrentOrderItem*************************************************/
    if(isset($_POST['CancelCurrentOrderItem'])){echo $classOrder -> cancelTempOrderItem($_POST['CancelCurrentOrderItem']); }
/*******************************************reset Count Number***********************************************************/
    if(isset($_POST['resetCountNumber']) && isset($_POST['CurrentUserID'])){echo $classOrder -> GetTotalCountOfAccodringToUserID ($_POST['CurrentUserID']);}
/*******************************************update current temp order ***************************************************/
    if(isset($_POST['updateCurrentOrder']) && isset($_POST['tempOrderID']) && isset($_POST['NewCount']) && isset($_POST['NewPrice'])){$classOrder -> updateCurrentSubTempOrder($_POST['tempOrderID'],$_POST['NewCount'],$_POST['NewPrice']);}
/****************************************** set up deliver fee **********************************************************/
    if(isset($_POST['DeliverCondition'])){echo $classOrder -> CaculatedDeliverFee($_POST['CurrentUserID']);}
/******************************************* fetch total price **********************************************************/
    if(isset($_POST['GetSumPrice']) && isset($_POST['CurrentUserID'])){echo $classOrder -> fetchTotalPrice($_POST['CurrentUserID']);}
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
    if(isset($_POST['CuisinePhotoUploading']) && isset($_POST['CuisineCuid']) && isset($_POST['CuisinePhotoPath']) && isset($_POST['CuisinePicWidth']) && isset($_POST['CuisinePicHeight']) ){echo $CuisineClass->CuisinePhotoUploadingAndUpdating($_POST['CuisineCuid'],$_POST['CuisinePhotoPath'],$_POST['OldPhotoPath'],$_POST['CuisinePicWidth'],$_POST['CuisinePicHeight']);}
/********************************************Added to favourite*****************************************************/
    if(isset($_POST['CuisineID'])&&isset($_POST['LoginUserID'])&&isset($_POST['AddedFavorite'])){echo $Favoriteclass->addedtoFavorite($_POST['LoginUserID'],$_POST['CuisineID'],$_POST['AddedFavorite']);}
/********************************************Distinguish favourite**************************************************/
    if(isset($_POST['FavoriteStatus'])){echo $Favoriteclass->ConfirmExesitedByFavorite();}

/********************************************Added cuisine comment**************************************************/
    //added cuisine comment
    if(isset($_POST['CurrentCuisineID']) && isset($_POST['CurrentUserID']) && isset($_POST['Currentstars']) && isset($_POST['CurrentCommentContent'])){
        //prevent over comment
        $current= time();
        session_start();
        if($current - $_SESSION['SetUpCuisineCommentTime'] > 1200) { //limited user comment once with 20 min as a gap
            $like = 0;
            $dislike = 0;
            $tempCode=$RegisterUserClass->GenerateRandomUserID();
            $commentID = 'CUC'.$tempCode;
            $review = 0;
            echo $CuisineComemnt -> getCuisineCommentParam($_POST['CurrentUserID'], $_POST['CurrentCuisineID'], $commentID, intval($_POST['Currentstars']), $_POST['CurrentCommentContent'], intval($like), intval($dislike), intval($review));
        }
        else{
            echo 'Over Comment';
        }
    }
    /********************************************Added Restaruant comment**************************************************/
    //added Restaruant comment
    if(isset($_POST['CurrentResID']) && isset($_POST['CurrentUserID']) && isset($_POST['Currentstars']) && isset($_POST['CurrentCommentContent'])){
        //prevent over comment
        if($CuisineComemnt -> ReturnCommentRecordCompared($_POST['CurrentUserID'], $_POST['CurrentResID'])) { //limited user comment once with 20 min as a gap
            echo 'Over Comment';
        }
        else{
            $like = 0;
            $dislike = 0;
            $tempCode=$RegisterUserClass->GenerateRandomUserID();
            $commentID = 'RC'.$tempCode;
            $review = 0;
            echo $CuisineComemnt -> getResCommentParam($_POST['CurrentUserID'], $_POST['CurrentResID'], $commentID, intval($_POST['Currentstars']), $_POST['CurrentCommentContent'], intval($like), intval($dislike), intval($review));
        }
    }


/*******************************************Thumb Like Or dislike***************************************************/
    if(isset($_POST['thumbLikeOrDislike']) && isset($_POST['CurrentUserID']) && isset($_POST['CurrentCommmentID']) && isset($_POST['CurrentCommentType'])){
        echo $ThumbLikeOrDislikeclass -> GetThumbsDistingush($_POST['thumbLikeOrDislike'], $_POST['CurrentUserID'], $_POST['CurrentCommmentID'],$_POST['CurrentCommentType']);
    }



/******************************************Final check&payment setting ***************************************************/
    /**
     * set up current payment address as default for current user
     */

    if(isset($_POST['PaymentAddressSet']) && isset($_POST['PaymentNiceName']) && isset($_POST['PaymentNumber']) && isset($_POST['PaymentUserID']) && isset($_POST['PaymentSetDefaultStatus'])){

        echo $MyaddressBookClass -> PaymentSetDefaultAddress($_POST['PaymentUserID'],$_POST['PaymentNiceName'],$_POST['PaymentNumber'],$_POST['PaymentAddressSet'],$_POST['PaymentSetDefaultStatus']);
    }


/************************************************************Co - Mobile end *****************************************************/
    //register manager or Deliver
    if(isset($_POST['Manager_Deliverer_Register']) && isset($_POST['Manager_DeliverEmail']) && isset($_POST['Manager_DeliverPassword']) && isset($_POST['Manager_Deliver_Name']) && isset($_POST['Manager_Deliver_Phone']) && isset($_POST['Manager_Deliver_Type'])){
        $Manager_DelivererID=$RegisterUserClass->GenerateRandomUserID();
        echo $ManagerDelivererClass -> RegisterManagerOrDeliverer($Manager_DelivererID,strtolower($_POST['Manager_DeliverEmail']),$_POST['Manager_DeliverPassword'],$_POST['Manager_Deliver_Name'],$_POST['Manager_Deliver_Phone'],$_POST['Manager_Deliver_Type']);

    }

    if(isset($_POST['refreshManagerTable'])){
        echo $ManagerDelivererClass -> qViewManagerOrDelivererTable($_POST['refreshType']);
    }





    //add record
    if(isset($_POST['managerAJAX']) && isset($_POST['managerInputFiled']) && isset($_POST['SelectedLocationID'])){
        $MangerID = 'M'.$RegisterUserClass->GenerateRandomUserID();
        echo $ManagerDelivererClass -> FetchParamerAndReadyInsert($MangerID, $_POST['managerInputFiled'], $_POST['SelectedLocationID']);
    }
    //delete reocrd
    if(isset($_POST['ManagerDelete']) && isset($_POST['GetManagerID'])){
        echo $ManagerDelivererClass -> DeleteMnager($_POST['GetManagerID']);
    }



}


?>