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

        if($stmt=$this->DataBaseCon->prepare("INSERT INTO B2C.User (UserID,UserPassWord,UserMail,UserType,UserStatus) VALUES (?,?,?,?,?)")){
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
        if($stmt=$this->DataBaseCon->prepare("INSERT INTO B2C.User (UserID,UserName,UserFirstName,UserLastName,UserPhotoPath,UserMail,UserType,UserStatus) VALUES (?,?,?,?,?,?,?,?)")){
            $stmt->bind_param('issssssi',$FBID,$FBUserName,$FBFirstName,$FBLastName,$FBPhoto,$FBMail,$UserType,$FBstatus);
            $stmt->execute();
            $stmt->close();
        }

    }


}


class LoginedIn extends User{


    public function __construct($DataBaseConnetcion){
        parent::__construct($DataBaseConnetcion);
    }

    public function GetUsersLoginInfo($userID){
        $TempArray=json_decode(parent::ReadAllUserbyUserID(trim($userID)));
        return $TempArray[0];//only one element required, so we selected first record of array

    }

    public function FacebookLogininWithSession($Id,$Name){
        $userPhoto='https://graph.facebook.com/'.$Id.'/picture';
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
        else if(count($Result)===0){
            return 'NoMatch';
        }



    }



}


?>