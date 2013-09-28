<?php
include '../BackEnd-controller/BackEnd-class.php';
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
        $getTempActiveCode=TempActivationClass::GenerateActiveCode();
        $TmpMailSettingArray=Mailsetting::GetMailContentViaParam('ActivactionMail');//get Array of Mail setting
        $SenderTo=$this->RegisterEmail;
        $Subject='Active your account (From:'.$TmpMailSettingArray['UserMailSender'].')';
        $NeededToActiveContent=GlobalPath.'/register/Vaild?UserID='.base64_encode($this->RegisterUserID).'&a='.$getTempActiveCode.'&ust=1';

        mail($SenderTo, $Subject, $NeededToActiveContent, "Content-type: text/html; charset=iso-8859-1");

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

    private function MatchEmail($InputEmail){
      $RepatedMail=0;
      $getArray=parent::SearchUser($InputEmail);
      foreach ($getArray as $key=>$value){
          if($key==='UserMail'){
              if($value===$InputEmail){
                  $RepatedMail=1;
                  break;
              }

          }

      }
    if($RepatedMail===1){
        return 'Repeated UserMail';
    }
    else {

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

}



?>