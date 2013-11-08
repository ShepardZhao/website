<?php
/**************************************************This file is FrontEnd Class****************************/

/**************************************************Extended user class***********************/
class RegisterUser extends User{
    private $RegisterUserID=null;
    private $RegisterUserPass=null;
    private $RegisterEmail=null;
    private $RegisterUserType=null;
    private $RegisterUserStatus=null;
    public function __construct($DataBaseConnetcion){
        parent::__construct($DataBaseConnetcion);
    }

    Public function GetUserRegisterData($RegisterUserID,$RegisterEmail,$RegisterUserPass,$RegisterUserType){

        $this->RegisterUserID=$RegisterUserID;
        $this->RegisterUserPass=$RegisterUserPass;
        $this->RegisterEmail=trim($RegisterEmail);
        $this->RegisterUserType=trim($RegisterUserType);
        $this->RegisterUserStatus=0;//setting up Register's status
        return self::MatchEmail($this->RegisterEmail);
    }

    private function UserMailValid(){//this function is send
        $getTempActiveCode=TempActivationClass::GenerateActiveCode();//get a Temp Active Code from class -   TempActivationClass this is existed in BackEnd-class.php
        TempActivationClass::GetTempActiveCode($getTempActiveCode);//insert temp active Code into the database
        $TmpMailSettingArray=Mailsetting::GetMailContentViaParam('ActivactionMail');//get Array of Mail setting - is existed in  BackEnd-class.php
        $SenderTo=$this->RegisterEmail;//get register's mailaddress;
        $Subject=$TmpMailSettingArray['UserMailTitle']. '(From:'.$TmpMailSettingArray['UserMailSender'].')'; //generate the subject of mail
        $NeededToActiveContent=GlobalPath.'/register/Valid?UserID='.base64_encode(trim($this->RegisterUserID)).'&a='.trim($getTempActiveCode).'&ust=1'; //generate user's active content that prepared to send to user
        $StyleOfMailContent=$TmpMailSettingArray['UserMailConstructer'];
        $FullyContentOfMail=$StyleOfMailContent.'<br><a href='.$NeededToActiveContent.'>Active your Account</a>';
        mail($SenderTo, $Subject, $FullyContentOfMail, "Content-type: text/html; charset=UTF-8");

    }



    private function InsertRegistrerToDatabase(){

        if($stmt=$this->DataBaseCon->prepare("INSERT INTO client_b2c.User (UserID,UserPassWord,UserMail,UserType,UserStatus) VALUES (?,?,?,?,?)")){
            $stmt->bind_param('isssi',$this->RegisterUserID,md5(base64_encode($this->RegisterUserPass)),$this->RegisterEmail, $this->RegisterUserType,$this->RegisterUserStatus);
            $stmt->execute();
            $stmt->close();
            self::UserMailValid();//send mail though to the user to valid
            return 'Register Done';
        }
        else {
            return 'Error';

        }
    }

    public function MatchUserFacebookID($getFBid){
        if(parent::ValidActiveion(base64_encode(trim($getFBid)))==='pass'){//in this case for facebook valid, the pass means that data already in the database
            return 1;
        }


    }


    private function MatchEmail($InputEmail){//this function is only works on normal register user
        $RepatedMail=0;
        $getArray=json_decode(parent::SearchUser($InputEmail));
        foreach ($getArray as $key=>$subvalueArray){
            foreach($subvalueArray as $subKey=>$value){
                if($subKey==='UserMail'){
                    if($value===$InputEmail){
                        $RepatedMail=1;
                        break;
                    }

                }
            }

        }
        if($RepatedMail===1){
            return 'Repeated UserMail';
        }
        else if($RepatedMail===0){

            return self::InsertRegistrerToDatabase();

        }

    }



    public function GenerateRandomUserID(){//this function is generated to UserID, which is according to current time and random
        $currentTime=time();
        $random=rand();
        $currentTimes=$currentTime*$random;
        $FinalUserID=substr($currentTimes,-11,-1);
        return $FinalUserID;

    }

    public function ActiveAccount($UserID,$ActiveStatus){

        return parent::UpdateInfoOfActivtion($UserID,$ActiveStatus);



    }

    //this function is getting facebook user's infomation straght away
    public function DirectlyRegisterFacebook($FBID,$FBUserName,$FBFirstName,$FBLastName,$FBMail,$FBPhoto,$FBstatus,$UserType){
        if($stmt=$this->DataBaseCon->prepare("INSERT INTO client_b2c.User (UserID,UserName,UserFirstName,UserLastName,UserPhotoPath,UserMail,UserType,UserStatus) VALUES (?,?,?,?,?,?,?,?)")){
            $stmt->bind_param('issssssi',$FBID,$FBUserName,$FBFirstName,$FBLastName,$FBPhoto,$FBMail,$UserType,$FBstatus);
            $stmt->execute();
            $stmt->close();
        }

    }


}


class LoginedIn extends User{

    private $DataBaseConnetcion=null;
    public function __construct($DataBaseConnetcion){
        $this->DataBaseConnetcion=$DataBaseConnetcion;
        parent::__construct($DataBaseConnetcion);
    }

    public function GetUsersLoginInfo($userID){
        $TempArray=json_decode(parent::ReadAllUserbyUserID(trim($userID)));
        return $TempArray[0];//only one element required, so we selected first record of array

    }

    public function FacebookLogininWithSession($Id,$Name){
        $userPhoto='https://graph.facebook.com/'.$Id.'/picture';
        unset($_SESSION['LoginedUserID']);
        unset($_SESSION['LoginedUserName']);
        unset($_SESSION['LoginedUserPhoto']);
        $_SESSION['LoginedUserID']=$Id;
        $_SESSION['LoginedUserName']=$Name;
        $_SESSION['LoginedUserPhoto']=$userPhoto;

    }


    public function ValidNormalUserLogining($GetNuerMail,$GetNuerMailPass){

        //Valid User Email and password
        $Result=json_decode(parent::ValidNormalUserMailAndPass($GetNuerMail,md5(base64_encode($GetNuerMailPass))));
        if (count($Result)>0){
            session_start();




            //saving current user ID,username,photo to session
            $_SESSION['LoginedUserID']=$Result[0]->UserID;
            $TmpName=$Result[0]->UserName;
            $TmpPhoto=$Result[0]->UserPhotoPath;
            $TmpType=$Result[0]->UserType;
            $_SESSION['LoginedUserType']=$TmpType;
           if($TmpType==='Facebook' || $TmpType==='Users'){

            if (!isset($TmpName)){
                $_SESSION['LoginedUserName']=$Result[0]->UserMail;
            }
            else if (isset($TmpName)){
                $_SESSION['LoginedUserName']=$TmpName;

            }
            if(!isset($TmpPhoto)){
                $_SESSION['LoginedUserPhoto']=GlobalPath.'/assets/framework/front-images/default-user-avatar.png';

            }
            else if(isset($TmpPhoto)){
                $_SESSION['LoginedUserPhoto']=$TmpPhoto;
            }
                return 'pass';
          }
            else if($TmpType==='Restaturant'){
                //if UserID exeisted in the restaruant, then return value
                $tmpRestaurantValues=json_decode(parent::ValidSameUserIDInRestaurant($Result[0]->UserID));
                $_SESSION['RestaruantID']=$tmpRestaurantValues[0]->RestID;

                if (!isset($tmpRestaurantValues[0]->ResName)){
                    $_SESSION['LoginedUserName']=$tmpRestaurantValues[0]->UserMail;
                }
                else{
                    $_SESSION['LoginedUserName']=$tmpRestaurantValues[0]->ResName;

                }
                if(!isset($tmpRestaurantValues[0]->ResPicPath)){
                    $_SESSION['LoginedUserPhoto']=GlobalPath.'/assets/framework/front-images/avatar_vendor_default_profile.png';
                }
                else{
                    $_SESSION['LoginedUserPhoto']=$tmpRestaurantValues[0]->ResPicPath;
                }
                return 'pass';
            }


        }
        else if(count($Result)===0){
            return 'NoMatch';
        }

    }


    //loginedIn user added new address whtere located at sidebar
    public function AddedNewAddress($UserID,$UserNickName,$UserPhone,$UserAddress,$SetDefaultStatus){
        #call MyaddressBook and InitialUserMyaddressBook two classes that to perform different functions
        $MyaddressBookcalass=new MyaddressBook($this->DataBaseConnetcion);
        $InitialUserMyaddressBookClass=new InitialUserMyaddressBook($this->DataBaseConnetcion);

        if ($MyaddressBookcalass->ResetPastDefault($UserID)===1){//if ResetPastDefault equal 1 then set all address to default according to user id
            if ($MyaddressBookcalass->GetParamOfMyaddressBookForFrontEndAddress($UserID,$UserNickName,$UserPhone,$UserAddress,$SetDefaultStatus)==='Repeated Addressbook'){
                return 'Repeated Addressbook';// check replated addressbook, return error to ajax
            }
            else{
                return $InitialUserMyaddressBookClass->DisplayAddressBookByUID($UserID);// re-display all address under current user id
            }
        }


    }





}

class InitialLocationSelect extends Location{

    public function __construct($DataBaseConnetcion){
        parent::__construct($DataBaseConnetcion);
    }



    public function GetLocation($getCondition){

        $GetLocationArray=parent::GetLocationNoParma();
        return self::InitialDisplay($getCondition,$GetLocationArray);
    }

    //sub location display
    public function GetSubLoaction($getID){
        $GetSubLocationArray=parent::GetLocationWithParma($getID);
        return self::InitialSubLocationDispaly($GetSubLocationArray);

    }


    //according RootID gets its name
    public function GetsRootLocalName($getRootid){
        $GetLocation=parent::GetLocationWithParma($getRootid);
        foreach ($GetLocation as $Rootkey=>$SubArray){
            foreach($SubArray as $secondkey=>$SecondArray){
                if($secondkey==='LevelOne'){
                    foreach ($SecondArray as $key=>$value){
                        return $value;
                    }
                }
            }

        }
    }




    //according SubID gets its name
    public function GetsSubLocalName($getRootid,$GetSubLocalID){
        $GetLocations=parent::GetLocationWithParma($getRootid);
        foreach ($GetLocations as $Rootkey=>$SubArray){
            foreach($SubArray as $secondkey=>$SecondArray){
                if($secondkey==='LevelTwo'){
                    foreach ($SecondArray as $key=>$value){
                        if($key===$GetSubLocalID){
                            return $value;
                        }
                    }
                }
            }
        }
    }





    //Sub location display
    private function InitialSubLocationDispaly($GetSubLocationArray){
        echo '<h3>Select Your Sub Address</h3>';
        echo '<div class="row-fluid">';
        echo '<div class="span12">';
        echo '<ul class="nav nav-pills SubLocationGroup">';
        foreach ($GetSubLocationArray as $Rootkey=>$SubArray){
            foreach($SubArray as $secondkey=>$SecondArray){
                if($secondkey==='LevelTwo'){
                    foreach ($SecondArray as $key=>$value){
                        echo "<li id='$key'><a href='#'>$value</a></li>";

                    }
                }
            }
        }
        echo '</ul>';
        echo '</div>';
        echo  '<div class="control-group text-center">';
        echo  '<button type="botton" class="mySubmit" id="SelectSubLocation">Next</button>';
        echo  '</div>';
        echo '</div>';
    }




    //root location display
    private function InitialDisplay($LoginStatus,$GetLocationArray){//display initial location selection with loginedIn condition
        // initial layer
        echo '<div class="initialDiv radius hidden-phone">';
        echo '<div class="secondWindows text-center">';
        echo '<div class="thumbnailsWrap">';
        if ($LoginStatus==='LoginedIn'){
            echo '<h3>Select Your Address</h3>';

        }
        else if($LoginStatus==='SignUp'){
            echo '<h3>Select Default Address To Complete Sign Up</h3>';

        }
        else if($LoginStatus==='NoParam'){
            echo '<h3>Please Selest Location First</h3>';

        }
        echo  '<div class="row-fluid">';
        echo  '<ul class="thumbnails thumClick">';
        foreach ($GetLocationArray as $key=>$SubArray){
            echo  '<li class="span6">';
            echo  '<div class="thumbnail">';
            foreach ($SubArray as $secondKey=>$SecondValue){
                if($secondKey==='LocationID'){
                    echo "<input type='hidden' class='hidenLocationID' id='$SecondValue'>";
                }
                if($secondKey==='LevelOnePic'){
                    echo  "<img data-src='holder.js/300x200' alt='$SecondValue' style='width: 300px; height: 200px;' src=$SecondValue>";
                }
                if($secondKey==='LevelOne'){
                    echo  '<div class="caption">';
                    foreach ($SecondValue as $subKEY=>$value){
                        echo  "<h4>$value</h4>";

                    }
                    echo  '</div>';
                }
            }
            echo  '</div>';
            echo  '</li>';
        }
        echo  '</ul>';
        echo  '<div class="control-group text-center">';
        echo  '<button type="botton" class="mySubmit" id="SelectRootLocation">Next</button>';
        echo  '</div>';
        echo  '</div>';
        echo  '</div>';
        echo  '</div>';
        echo  '</div>';

    }


    public function hiddenInitialLocation(){
        echo '<script type="text/javascript">';
        echo '$(document).ready(function(){$(".initialDiv").hide();});';
        echo '</script>';
    }
    public function ShowInitialLocation(){
        echo '<script type="text/javascript">';
        echo '$(document).ready(function(){$(".initialDiv").css("display","block");});';
        echo '</script>';
    }


}


class InitialUserMyaddressBook extends MyaddressBook{

    public function __construct($DataBaseConnetcion){
        parent::__construct($DataBaseConnetcion);
    }

    public function DisplayAddressBookByUID($getUID){
        $GetArray=parent::readAllAddressbookByIDAndDefaultStauts($getUID,0);
        $GetArrayWithDefault=parent::readAllAddressbookByIDAndDefaultStauts($getUID,1);
        return self::DisplayMyaddressbook($GetArray,$GetArrayWithDefault);
    }

    public function DisplayMyaddressbook($MyaddressBookArray,$MyaddressBookArrayWithDefault){
        //list default address that has the default property
        foreach ($MyaddressBookArrayWithDefault as $key=>$subArray){
            foreach ($subArray as $subKey=>$value){
                if($subKey==='AddresAddress'){
                    echo '<label class="radio">';
                    echo "<input type='radio' name='optionsRadios' value='$value' checked>";
                    echo "Default: <i>$value</i>";
                    echo "</label>";
                }
            }
        }

        //other hidden address
        echo '<div class="hideAddress">';
        foreach ($MyaddressBookArray as $key=>$subArray){
            foreach ($subArray as $subKey=>$value){
                if($subKey==='AddresAddress'){
                    echo '<label class="radio">';
                    echo "<input type='radio' name='optionsRadios' value='$value'>";
                    echo "<i>$value</i>";
                    echo '</label>';
                }
            }
        }
        echo '<div class="btn-group">';
        echo '<button class="setUp radius AddedNewAddress" type="button" data-toggle="modal" href="#static"><h6>New Address</h6>';
        echo '</button>';
        echo '</div>';
        echo '</div>';
    }


}


/******************************************OrderSelectionTags*************************************************/
class OrderSelectionTags extends Tags{
    public function __construct($DataBaseConnetcion){
        parent::__construct($DataBaseConnetcion);
    }

    public function FrontEndDisplayTags($Tags,$Table){
        $tmpArray=parent::getTags($Tags,$Table);
        foreach($tmpArray as $key=>$value){
        echo "<li class='$key'><a>$value</a></li>";
        }

    }
}


/*****************************************Added to favorite**************************************************/
class favorite{
    private $DataBaseCon=null;
    public function __construct($DataBaseConnetcion){
        $this->DataBaseCon=$DataBaseConnetcion;
    }

    private function ConfirmExesited($userID,$CuisineID){
        if($stmt=$this->DataBaseCon->prepare("SELECT * FROM client_b2c.Userfavorite WHERE UserID=? AND CuID=?")){
           $stmt->bind_param('ss',$userID,$CuisineID);
           $stmt->execute();
           $stmt->bind_result();
           $result = $stmt->get_result();
           $object=array();
           while($row=$result->fetch_assoc()){
               array_push($object,$row);
           }
           $stmt->close();
            if(count($object)>0){
                return true;
            }
            else{
                return false;
            }


        }
    }

    public function addedtoFavorite($userID,$CuisineID,$FavoriteStatus){
     if($this->ConfirmExesited($userID,$CuisineID)){
          if($stmt=$this->DataBaseCon->prepare("UPDATE client_b2c.Userfavorite SET FavoriteStatus=? WHERE UserID=? AND CuID=?")){
             $stmt->bind_param('iss',$FavoriteStatus,$userID,$CuisineID);
             $stmt->execute();
             $stmt->close();
             return 'true';
          }
         else{
             return 'false';
         }
     }
     else{
         if($stmt=$this->DataBaseCon->prepare("INSERT INTO client_b2c.Userfavorite (UserID,CuID,FavoriteStatus) VALUES (?,?,?)")){
             $stmt->bind_param('ssi',$userID,$CuisineID,$FavoriteStatus);
             $stmt->execute();
             $stmt->close();
             return 'true';
         }
         else{
             return 'false';
         }
     }
     }






}




?>