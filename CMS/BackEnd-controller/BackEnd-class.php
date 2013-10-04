<?php
/***********************************************this file is Back end class****************************************/
/************************************************DataBase Class****************************************************/
class DataBase extends mysqli {
    public function __construct($host, $user, $pass, $db) {
        parent::__construct($host, $user, $pass, $db);

        if (mysqli_connect_error()) {
            die('Connect Error (' . mysqli_connect_errno() . ') '
                . mysqli_connect_error());
        }
    }
}





/**********************************************Website setting  Class***********************************************/
class BasicSystemInfo{//this class only display the info;

    public function _SysInformationDisply($SysParater){
        echo $_SERVER[$SysParater];
    }
    public function _SysTime(){
        date_default_timezone_set('utc');
        echo date("d-m-y H:i:s");
    }


}



class BasicSetting{ //setting up basic information for website

    private $DataBaseCon=null;

    public function __construct($DataBaseCon){
        $this->DataBaseCon=$DataBaseCon;

    }

    public function getSettingData($SiteName,$SiteDescr,$SiteSiteUrl,$SiteSiteEmail,$SiteSiteStatus,$SitePolicy){//update record of basicsetting
        if($stmt=$this->DataBaseCon->prepare("UPDATE B2C.Option SET WebTitle=?, WebDescription=?, WebUrl=?, EMail=?, WebStatus=? ,WebPolicy=? WHERE OptionID=1")){
            $stmt->bind_param('ssssss',$SiteName,$SiteDescr,$SiteSiteUrl,$SiteSiteEmail,$SiteSiteStatus,$SitePolicy);
            $stmt->execute();
            $stmt->close();
            return "Saved successfully";
        }
        else {

            return "Error";
        }

    }


    public function pushSettingData(){//return valuesArray
        if($stmt=$this->DataBaseCon->prepare("SELECT WebTitle,WebDescription,WebUrl,EMail,WebStatus,WebPolicy FROM B2C.Option WHERE OptionID=1")){
            $stmt->execute();
            $stmt->bind_result($WebTitle,$WebDescription,$WebUrl,$EMail,$WebStatus,$WebPolicy);
            $result = $stmt->get_result();
            $object = $result->fetch_assoc();
            $stmt->close();
            return $object;

        }

    }

}



/****************************************************Tags Class********************************************************/
Class Tags{
    private $DataBaseCon=null;
    public function __construct($DataBaseCon){
        $this->DataBaseCon=$DataBaseCon;
    }



    public function SetTags($TableName,$TagID,$TagValue,$IndexID){//set tags' type and name, regardless of the Restaruant or Cusinse| Insert the record into the database
        $serializeArray_Value_of_tag=self::getTags($TagID,$TableName);
        if ($serializeArray_Value_of_tag===false){//first time when the vale is null
            $serializeArray_Value_of_tag=[];
            array_push($serializeArray_Value_of_tag,$TagValue);
            if($stmt=$this->DataBaseCon->prepare("UPDATE $TableName SET $TagID=? WHERE $IndexID=0")){
                $stmt->bind_param('s',serialize($serializeArray_Value_of_tag));
                $stmt->execute();
                $stmt->close();
                return "Added successfully";
            }

        }
        else {//if database has existed value then read out and push in

            array_push($serializeArray_Value_of_tag,$TagValue);
            if($stmt=$this->DataBaseCon->prepare("UPDATE $TableName SET $TagID=? WHERE $IndexID=0")){
                $stmt->bind_param('s',serialize($serializeArray_Value_of_tag));
                $stmt->execute();
                $stmt->close();
                return "Added successfully";
            }
        }

    }

    public function outPutRestaurantTags($Tags,$Table){//display the Tags via html
        $tmpArray=self::getTags($Tags,$Table);
        echo "<select id='$Tags' class='tagslist' multiple='multiple'>";
        foreach ($tmpArray as $values){
            if($values!=''){
                echo "<option value='$values' id='$Table'>$values</option>";
            }
        }
        echo "</select>";

    }

    public function DeleteTags($TableName,$TagID,$TagValue,$IndexID){//delete Record (in this case we are using update to filter the value that wants to remove and cp new array in to database)according to parmamters
        $serializeArray_Value_of_tag_del=self::MatchArray($TagValue,$TagID,$TableName);

        if($stmt=$this->DataBaseCon->prepare("UPDATE $TableName SET $TagID=? WHERE $IndexID=0")){
            $stmt->bind_param('s',serialize($serializeArray_Value_of_tag_del));
            $stmt->execute();
            $stmt->close();
            return "Deleted successfully";
        }


    }

    public function MatchArray($TagValue,$Tags,$Table){
        $tmpArray=self::getTags($Tags,$Table);
        $tmpForSaveArray=[];
        foreach ($tmpArray as $value){
            if ($value!==$TagValue){
                $tmpForSaveArray[]=$value;
            }
        }
        return $tmpForSaveArray;

    }


    public function getTags($NameOfTags,$Table){//Reading the record from the data regardless of resturantant or cusine

        if($stmt=$this->DataBaseCon->prepare("SELECT $NameOfTags FROM $Table")){
            $stmt->execute();
            $stmt->bind_result($NameOfTags);
            while ($stmt->fetch()) {
                $tmpArry=$NameOfTags;
            }
            $stmt->close();
            return unserialize($tmpArry);
        }
    }

}




/****************************************************lcoation Class************************************************/
class Location{

    private $DataBaseCon=null;

    public function __construct($DataBaseCon){
        $this->DataBaseCon=$DataBaseCon;
    }


    public function PushValueCompared($getRootLocation){

        if($stmt=$this->DataBaseCon->prepare("SELECT LevelOne FROM B2C.Location WHERE LevelOne=?")){
            $stmt->bind_param('s',$getRootLocation);
            $stmt->bind_result($LevelOne);
            $stmt->execute();
            while($stmt->fetch()){
                if($getRootLocation===$LevelOne){
                    return "existed";
                }
            }
            $stmt->close();
        }

    }

    public function GetAddLocation($getRootLocation,$GetSubLocationArray){//check whether has same value that is in the database
        if( self::PushValueCompared($getRootLocation)==="existed"){
            return "repeated";
        }

        else if($stmt=$this->DataBaseCon->prepare("INSERT INTO B2C.Location (LevelOne, LevelTwo) VALUE (?,?)")){
            $stmt->bind_param('ss',$getRootLocation,$GetSubLocationArray);
            $stmt->execute();
            $stmt->close();
            return "Successed";
        }
        else
        {

            return "Error";
        }
    }


    public function GetLocationNoParma(){//This function only return the array without Condition

        if($stmt=$this->DataBaseCon->prepare("SELECT LocationID, LevelOne, LevelTwo FROM B2C.Location")){
            $stmt->execute();
            $stmt->bind_result($LocationID, $levelOne, $LevelTwo);
            $TemLocationArray=array();
            while($stmt->fetch()){
                $TemLocationArray[]=array('LocationID'=>$LocationID,'LevelOne'=>unserialize($levelOne),'LevelTwo'=>unserialize($LevelTwo));

            }

            $stmt->close();
            return $TemLocationArray;

        }
    }

    public function GetLocationWithParma($getID){
        if($stmt=$this->DataBaseCon->prepare("SELECT LocationID, LevelOne, LevelTwo FROM B2C.Location WHERE LocationID=?")){
            $stmt->bind_param('i',$getID);
            $stmt->execute();
            $stmt->bind_result($LocationID, $levelOne, $LevelTwo);
            $TemLocationArray=array();
            while($stmt->fetch()){
                $TemLocationArray[]=array('LocationID'=>$LocationID,'LevelOne'=>unserialize($levelOne),'LevelTwo'=>unserialize($LevelTwo));

            }

            $stmt->close();
            return $TemLocationArray;

        }

    }

    public function getIDToDelete($getLocationID){//according to LocationID then delete the record from the database: return the status that is including: success or error
        if($stmt=$this->DataBaseCon->prepare("DELETE FROM B2C.Location WHERE LocationID=?")){
            $stmt->bind_param('i',$getLocationID);
            $stmt->execute();
            $stmt->close();
            return "Deleted successfully";
        }
        else{
            return "Deleted error";
        }

    }

    public function pushModifyLocation($GetModifyLocationRootLocation,$GetModifyLocationSubLocation,$GetModifyLocationID){

        if($stmt=$this->DataBaseCon->prepare("UPDATE B2C.Location SET LevelOne=?, LevelTwo=? WHERE LocationID=?")){
            $stmt->bind_param('ssi',$GetModifyLocationRootLocation,$GetModifyLocationSubLocation,$GetModifyLocationID);
            $stmt->execute();
            $stmt->close();
            return "Modified successfully";
        }
        else {

            return "Modified error";

        }


    }



    public function ModifyLocation($GetModifyLocationID){//Change Location value
        $TmpArray=self::GetLocationWithParma($GetModifyLocationID);
        $getid=null;
        echo "<div class='LocationModify'>";
        echo "<div class='row-fluid'>";
        echo  "<div class='span12'>";
        echo "<div class='divhead'><h4><i class='icon-list-ul'>  Please Change Location below</i><h4></div>";
        echo "<div class='basicInfo-box'>";
        echo "<div class='form-horizontal'>";
        foreach($TmpArray as $subvaluearray){
            foreach($subvaluearray as $key=>$value){
                if($key==="LocationID"){
                    $getid=$value;
                }
                else if($key==="LevelOne"){
                    foreach($value as $key=>$getvalue){
                    echo  "<div class='control-group'>";
                    echo  "<label class='control-label'>Please Change Root Location:</label>";
                    echo "<div class='controls'>";
                    echo "<input type='text'  id='ChangeRootLocation' class='input-xlarge' name='ChangeRootLocation[]' value='$getvalue'>";
                    echo " <input type='text'  id='ChangeRootLocationID' class='input-xlarge' name='ChangeRootLocationID[]' value='$key'>";
                    echo "</div>";
                    echo "</div>";
                    }
                    echo "<br>";
                    echo  "<label class='control-label'>Please Change Sub Location:</label>";

                }
                else if($key==="LevelTwo"){
                    foreach($value as $key=>$finalvalue){

                        echo "<div class='control-group'>";
                        echo "<div class='controls'>";
                        echo  "<input type='text' class='input-xlarge' name='ChangeSubLocation[]' value='$finalvalue' >";
                        echo  " <input type='text' class='input-xlarge' name='ChangeSubLocationID[]' value='$key' >";
                        echo "</div>";
                        echo "</div>";
                    }
                }
            }
        }
        echo "</div>";
        echo "<button id='$getid' class='button ChangeLocationButton' type='button'>Change</button>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
        echo "<div class='span12'></div>";

        echo "</div>";

    }



    public function CmsDisplay(){//only display the result at cms index page
        echo '<table  class="table table-striped">';
        echo  '<thead>';
        echo '<tr class="thead">';
        // echo '<td><h4>Select Status</h4></td>';
        echo '<td><h6>Location ID</h6></td>';
        echo '<td><h6>Root Location</h6></td>';
        echo '<td><h6>Sub Location</h6></td>';
        echo '<td><h6>Change</h6></td>';
        echo '<td><h6>Delete</h6></td>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        foreach(self::GetLocationNoParma() as $subArray){
            echo '<tr>';
            $temID=null;
            foreach($subArray as $key=>$subarray){

                if($key==="LocationID"){
                    $temID=$subarray;
                    //echo "<td><label class='checkbox'><input name='Locationcheckbox[$subarray]' id=".$subarray." type='checkbox'></label></td>";
                    echo '<td>'.$subarray.'</td>';


                }

                else if($key==="LevelTwo"){
                    echo '<td>';
                    foreach($subarray as $key=>$value){
                        echo "<p>ID($key)  Name($value)</p>";
                    }
                    echo '</td>';
                }
                else if($key==="LevelOne"){
                    foreach($subarray as $key=>$value){
                        echo "<td>ID ($key)  Name($value)</td>";
                    }
                }


            }

            echo "<td><button id='$temID' class='button Modify' type='button'>Modify</button></td>";
            echo "<td><button id='$temID' class='button delete' type='button'>Delete</button></td>";

            echo '</tr>';

        }

        echo '</tbody>';
        echo '</table>';

    }
}


/**********************************************************User Class*********************************************/
class User{
    public $DataBaseCon=null;
    public function __construct($DataBaseCon){

        $this->DataBaseCon=$DataBaseCon;
    }

    public function UpdateInfoOfActivtion($UserID,$UserStatus){
        if($stmt=$this->DataBaseCon->prepare("UPDATE B2C.User SET UserStatus=? WHERE UserID=?")){
            $stmt->bind_param('is',$UserStatus,$UserID);
            $stmt->execute();
            $stmt->close();
            return "Successfuly actived";
        }
        else {

            return "Updated error";

        }
    }


    public function ValidActiveion($getEncrpyUserID){//valid the userID whether exeisted
           $jsonedArray=self::ReadAllUser();
           $comfirmStatus=0;//default is 0, which mean the user id is not exeisted in database
        foreach (json_decode($jsonedArray) as $key=>$Subvalue){
            foreach ($Subvalue as $keys=>$value){
                if($keys==='UserID'){
                    if($getEncrpyUserID===base64_encode($value)){
                        $comfirmStatus=1;
                        break;
                    }
                }
            }
        }
        if ($comfirmStatus===1){
            return 'pass';
        }
        if($comfirmStatus===0){
            return 'fail';
        }


    }


    public function UpdateAdministratorinfo($AdministratorID,$AdministratorName,$AdministratorPassword,$AdministratorEmail,$AdministratorPhone,$AdministratorPhotoPath,$AdministratorType){
        if($stmt=$this->DataBaseCon->prepare("UPDATE B2C.User SET UserName=?, UserPassWord=?, UserPhone=?,UserPhotoPath=?,UserMail=? WHERE UserID=? AND UserType=?")){
            $stmt->bind_param('ssissis',$AdministratorName,md5(base64_encode(($AdministratorPassword))),$AdministratorPhone,$AdministratorPhotoPath,$AdministratorEmail,$AdministratorID,$AdministratorType);
            $stmt->execute();
            $stmt->close();
            return "Updated successfully";
        }
        else {

            return "Updated error";

        }

    }

    Public function ReadAllUser(){
        if($stmt=$this->DataBaseCon->prepare("SELECT UserID, UserName, UserPhone, UserPhotoPath, UserMail, UserPoints, UserADPosition, UserType, UserStatus FROM B2C.User")){
            $stmt->execute();
            $stmt->bind_result($UserID,$UserName,$UserPhone,$UserPhotoPath,$UserMail,$UserPoints,$UserADPosition,$UserType,$UserStatus);
            $result = $stmt->get_result();
            $object=array();
            while ($row=$result->fetch_assoc()){

                array_push($object,$row);
            }
            $stmt->close();
            return json_encode($object); //return all user infor by json;
        }

    }

    public function ReadAllUserbyUserID($getUserID){
        if($stmt=$this->DataBaseCon->prepare("SELECT UserID, UserName, UserFirstName, UserLastName,UserPassWord, UserPhone, UserPhotoPath, UserMail,UserAddress, UserPoints, UserADPosition, UserType, UserStatus FROM B2C.User WHERE UserID=?")){
            $stmt->bind_param('i',$getUserID);
            $stmt->execute();
            $stmt->bind_result($UserID,$UserName,$UserFirstName,$UserLastName,$UserPassWord,$UserPhone,$UserPhotoPath,$UserMail,$UserAddress,$UserPoints,$UserADPosition,$UserType,$UserStatus);
            $result = $stmt->get_result();
            $object=array();
            while ($row=$result->fetch_assoc()){

                array_push($object,$row);
            }
            $stmt->close();
            return json_encode($object); //return all user infor by json;
        }


    }


  public function SearchUser($UserEmail){
      if($stmt=$this->DataBaseCon->prepare("SELECT UserID, UserName, UserPhone, UserPhotoPath, UserMail FROM B2C.User WHERE UserMail=?")){
          $stmt->bind_param('s',$UserEmail);
          $stmt->execute();
          $stmt->bind_result($UserID,$UserName,$UserPhone,$UserPhotoPath,$UserMail);
          while($stmt->fetch()){
            $TmpArray=array('UserID'=>$UserID,'UserName'=>$UserName,'UserPhone'=>$UserPhone,'UserPhotoPath'=>$UserPhotoPath,'UserMail'=>$UserMail);
          }
          $stmt->close();
          return $TmpArray;
      }


  }

    public function ReadAdministraorInfo(){
        if($stmt=$this->DataBaseCon->prepare("SELECT UserID, UserName, UserPassWord, UserPhone, UserPhotoPath, UserMail FROM B2C.User WHERE UserType=?")){
            $UserType='Administrator';
            $stmt->bind_param('s',$UserType);
            $stmt->execute();
            $stmt->bind_result($UserID,$UserName,$UserPassWord,$UserPhone,$UserPhotoPath,$UserMail);
            while($stmt->fetch()){
                $tempArray= array('UserID'=>$UserID,'UserName'=>$UserName,'UserPassWord'=>$UserPassWord,'UserPhone'=>$UserPhone,'UserPhotoPath'=>$UserPhotoPath,'UserMail'=>$UserMail);
            }
            $stmt->close();

            return $tempArray;

        }


    }



    //validing normal user and its password and mail, then return status
    public function ValidNormalUserMailAndPass($GetEmail,$GetEncryedPassword){
        if($stmt=$this->DataBaseCon->prepare("SELECT UserID, UserName, UserPassWord, UserPhone, UserPhotoPath, UserMail FROM B2C.User WHERE UserMail=? AND UserPassWord=?")){
            $stmt->bind_param('ss',$GetEmail,$GetEncryedPassword);
            $stmt->execute();
            $stmt->bind_result($UserID,$UserName,$UserPassWord,$UserPhone,$UserPhotoPath,$UserMail);
            $result = $stmt->get_result();
            $object=array();
            while($row=$result->fetch_assoc()){
                array_push($object,$row);
            }
            $stmt->close();

            return json_encode($object); //returned condition user info by json;

        }


    }

//Register user updating-basic info
    public function UpdateRegUserBasicInfo($UserName,$UserFirstName,$UserLastName,$UserPhone,$UserMail,$UserAddress,$UserID){
        if($stmt=$this->DataBaseCon->prepare("UPDATE B2C.User SET UserName=?, UserFirstName=?,UserLastName=?,UserPhone=?,UserMail=?, UserAddress=? WHERE UserID=?")){
            $stmt->bind_param('sssissi',$UserName,$UserFirstName,$UserLastName,$UserPhone,$UserMail,$UserAddress,$UserID);
            $stmt->execute();
            $stmt->close();
            return "Updated successfully";
        }
        else {
            return "Updated error";
        }

    }

//Register user updating-password updating info
    public function UpdateRegUserPassword($OldPassword,$Newpassword,$UserID){

        if (self::RegisterPasswordChangeMatch($OldPassword,$UserID)==='pass'){
        if($stmt=$this->DataBaseCon->prepare("UPDATE B2C.User SET UserPassWord=? WHERE UserID=?")){
            $stmt->bind_param('si',md5(base64_encode($Newpassword)),$UserID);
            $stmt->execute();
            $stmt->close();
            return "Changed password successfully";
        }
        else {
            return "Updated error";

        }
       }
        else{

            return 'fail';
        }

    }




//Register user updating-avatar
    public function UpdateRegUserAvatar($Avatar,$UserID){
        if($stmt=$this->DataBaseCon->prepare("UPDATE B2C.User SET UserPhotoPath=? WHERE UserID=?")){
            $stmt->bind_param('si',$Avatar,$UserID);
            $stmt->execute();
            $stmt->close();
            return "Updated avatar successfully";
        }
        else {
            return "Updated error";

        }

    }


//Register user password changing, the $getUserData from function ReadAllUserbyUserID
    private function RegisterPasswordChangeMatch($Oldpassword,$userid){
        $getTempArray=json_decode(self::ReadAllUserbyUserID($userid));
        $a=$getTempArray[0]->UserPassWord;
        $b=md5(base64_encode($Oldpassword));
        if ($getTempArray[0]->UserPassWord===md5(base64_encode($Oldpassword))){
            return 'pass';
        }
        else{
            return 'fail';
        }



    }




}
/*********************************************************Addressbook Class****************************************/
class MyaddressBook {
    public $DataBaseCon=null;
    private $GetUserID=null;
    Private $GetNickName=null;
    private $GetPhone=null;
    private $GetAddress=null;
    public function __construct($DataBaseCon){

        $this->DataBaseCon=$DataBaseCon;
    }

    public function GetParamOfMyaddressBook($GetUserID,$GetNickName,$GetPhone,$GetAddress){
        $this->GetUserID=$GetUserID;
        $this->GetNickName=$GetNickName;
        $this->GetPhone=$GetPhone;
        $this->GetAddress=$GetAddress;
        return self::AddMyaddressbook();

    }

    private function AddMyaddressbook(){
      if (self::CompareInfo()==='pass'){
        if($stmt=$this->DataBaseCon->prepare("INSERT INTO B2C.UserAddressBook (AddressBookID,UserID, AddreNickName,AddrePhone,AddresAddress,AddreStatus) VALUES (null,?,?,?,?,?)")){
           $DefaultStauts=0;//default is not been taken;

           $stmt->bind_param('isisi',$this->GetUserID,$this->GetNickName,$this->GetPhone,$this->GetAddress,$DefaultStauts);
           $stmt->execute();
           $stmt->close();
           return self::loopDisplayAddressCard($this->GetUserID);
            }
         else {
             return 'Error';
         }

       }
       else if (self::CompareInfo()==='fail'){
           return 'Repeated Addressbook';
       }

    }

    private function CompareInfo(){
      if ($stmt=$this->DataBaseCon->prepare("SELECT UserID,AddreNickName,AddrePhone,AddresAddress FROM B2C.UserAddressBook WHERE UserID=? AND AddreNickName=? AND AddrePhone=? AND AddresAddress=?")){
          $stmt->bind_param('isis',$this->GetUserID,$this->GetNickName,$this->GetPhone,$this->GetAddress);
          $stmt->execute();
          $stmt->bind_result($UserID,$AddreNickName,$AddrePhone,$AddresAddress);
          $result = $stmt->get_result();
          $object=array();
          while($row=$result->fetch_assoc()){
              array_push($object,$row);
          }
          $stmt->close();

        if (count($object)===0){
            return 'pass';
        }
        else if(count($object)>0){
            return 'fail';
        }
      }


    }

   private function readAllAddressbookByID($GegID){//read all record from table
       if ($stmt=$this->DataBaseCon->prepare("SELECT AddreStatus,AddressBookID,UserID,AddreNickName,AddrePhone,AddresAddress FROM B2C.UserAddressBook WHERE UserID=?")){
           $stmt->bind_param('i',$GegID);
           $stmt->execute();
           $stmt->bind_result($AddreStatus,$AddressBookID,$UserID,$AddreNickName,$AddrePhone,$AddresAddress);
           $result = $stmt->get_result();
           $object=array();
           while($row=$result->fetch_assoc()){
               array_push($object,$row);
           }
           $stmt->close();
           return $object;
       }


   }

  //Remove My address book
  public function RemoveMyaddressBook($getUserID, $GetAddressID){
      if($stmt=$this->DataBaseCon->prepare("DELETE FROM B2C.UserAddressBook WHERE AddressBookID=?")){
         $stmt->bind_param('i',$GetAddressID);
         $stmt->execute();
         $stmt->close();
         return  self::loopDisplayAddressCard($getUserID);
      }
      else{
         return 'Error';
      }
  }
  //Set default addressbook
  public function SetMyaddressBook($getUserID, $GetAddressID){
      //Check past default stauts
      if (self::ResetPastDefault($getUserID)===1){
      if($stmt=$this->DataBaseCon->prepare("UPDATE B2C.UserAddressBook SET AddreStatus=? WHERE AddressBookID=? AND UserID=?")){
          $AddreStatus=1;
          $stmt->bind_param('iii',$AddreStatus,$GetAddressID,$getUserID);
          $stmt->execute();
          $stmt->close();

          return  self::loopDisplayAddressCard($getUserID);
      }
      else{
          return 'Error';
      }
  }
  }

 //Check past default stauts function
  public function ResetPastDefault($GetID){
      if($stmt=$this->DataBaseCon->prepare("UPDATE B2C.UserAddressBook SET AddreStatus=? WHERE UserID=?")){
          $AddreStatus=0;
          $stmt->bind_param('ii',$AddreStatus,$GetID);
          $stmt->execute();
          $stmt->close();

          return  1;
      }
      else{
          return 0;
      }


  }

  //Display the content by UserID
  public function loopDisplayAddressCard($getUserID){
      $getAddressCard=self::readAllAddressbookByID($getUserID);
       foreach ($getAddressCard as $key=>$subArray){
           echo '<li class="DescideCheck text-left">';
           echo '<a class="thumbnail AddressCardStyle">';
           echo '<address>';
           foreach($subArray as $key=>$value){

              if($key==='AddreNickName'){
               echo "<h4>Name: $value</h4>";
              }
              elseif($key==='AddrePhone'){
               echo "<abbr title='Phone'>Phone: $value";

              }
              elseif($key==='AddresAddress'){
               echo  "<p style='margin-top:9px;'>Delivery Address: $value</p>";
              }
              elseif($key==='AddreStatus'){
                  if($value===1){
                  $CheckStatus='Checked';
                  }
                  elseif($value===0){
                      $CheckStatus='';

                  }
               }

              elseif ($key==='AddressBookID'){

               echo '<div class="RaidoPositon">';
               echo '<label class="radio">';

               echo "<input type='radio' name='Default' class='radioStatus' $CheckStatus id=$value>Default";

               echo '</label>';
               echo '</div>';
              }
           }
           echo '</address>';
           echo '</a>';
           echo '</li>';
       }



  }






}



/**********************************************************Login Class*********************************************/
class Login extends User{
    private $GetloginUserName=null;
    private $GetLoginPassword=null;

    public function __construct($DataBaseCon){
        parent::__construct($DataBaseCon);

    }

    public function getLoginData($GetloginUserName,$GetLoginPassword){

        $this->GetloginUserName=$GetloginUserName;
        $this->GetLoginPassword=$GetLoginPassword;
        return self::UserPassCheck(parent::ReadAdministraorInfo());

    }
    private function UserPassCheck($TmpArray){
        if($this->GetloginUserName===$TmpArray['UserName'] && md5(base64_encode($this->GetLoginPassword))===$TmpArray['UserPassWord']){
            session_start();
            $_SESSION['LoginedAdmministratorName']=$this->GetloginUserName;
            return 'Pass';
        }
        else {

            return 'Error';

        }


    }

    public function ReLogin(){

        echo '<script type="text/javascript">';
        echo 'alert("We do not have you login record, pls re-login again!");';
        echo 'window.location = "login.php";';
        echo '</script>';

    }



}


/**************************************************Temp Activation class************************************************/
class TempActivationClass{
    private $DataBaseCon=null;
    private $GenerateActiveCode=null;
    public function __construct($DataBaseCon){
        $this->DataBaseCon=$DataBaseCon;

    }

    public function GenerateActiveCode(){
        $GetCurrent=time();
        $EncrpyGetCurrent=md5($GetCurrent);
        return $EncrpyGetCurrent;
    }

    public function DeleteActiveCode($GetTempCode){
        if($stmt=$this->DataBaseCon->prepare("DELETE FROM B2C.TempActiveCode WHERE TempActiveCode=?")){
            $stmt->bind_param('s',$GetTempCode);
            $stmt->execute();
            $stmt->close();
            return 1;
        }



    }

    public function ValideTemActiveCode($GetTempCode){
        $jsonedArray=self::selectTempActiveCode();

        $comfirmStatus=0;//default is 0, which mean the user id is not exeisted in database
        foreach (json_decode($jsonedArray) as $key=>$Subvalue){
            foreach ($Subvalue as $keys=>$value){
                if($keys==='TempActiveCode'){
                    if($GetTempCode===$value){
                        $comfirmStatus=1;
                        break;
                    }
                }
            }
        }
        if ($comfirmStatus===1){
            return 'pass';
        }
        if($comfirmStatus===0){
            return 'fail';
        }


    }

    public function GetTempActiveCode($getTempActivationCode){
        $this->GenerateActiveCode=$getTempActivationCode;
        self::InsertTempActiveCode();

    }
    private function InsertTempActiveCode(){
        if($stmt=$this->DataBaseCon->prepare("INSERT INTO B2C.TempActiveCode (TempActiveCode) VALUE (?)")){
            $stmt->bind_param('s',$this->GenerateActiveCode);
            $stmt->execute();
            $stmt->close();
        }

    }
    private function selectTempActiveCode(){
        if($stmt=$this->DataBaseCon->prepare("SELECT TempActiveCode FROM B2C.TempActiveCode")){
            $stmt->execute();
            $stmt->bind_result($TempActiveCode);
            $object=array();
            $result = $stmt->get_result();
            $object=array();
            while ($row=$result->fetch_assoc()){

                array_push($object,$row);
            }

            $stmt->close();
            return json_encode($object);
        }

    }

    public function CompareActiveCode($GetParamCode){
        $PassStatus=0;
        $Tempary=self::selectTempActiveCode();
        foreach ($Tempary as $value){
            if($GetParamCode===md5(base64_encode($value))){
                $PassStatus=1;
            }

        }

        if($PassStatus===1){
                return 'pass';

        }
        else if ($PassStatus===0){
                return 'Not Match';


        }


    }



}



/*************************************************Mail Setting class*****************************************/
class Mailsetting{
    private  $DataBaseCon=null;
    private  $UserMailSender=null;
    private  $UserMailConstructer=null;
    private  $UserMailActiveID=null;
    private  $TitleOfMail=null;
    public function __construct($DataBaseCon){
        $this->DataBaseCon=$DataBaseCon;
    }
    public function GetParam_MailSetting($UserMailSender,$UserMailConstructer,$UserMailActiveID,$TitleOfMail){
        $this->UserMailSender=$UserMailSender;
        $this->UserMailConstructer=$UserMailConstructer;
        $this->UserMailActiveID=$UserMailActiveID;
        $this->TitleOfMail=$TitleOfMail;

        return self::AddMailAndItsContent($this->UserMailSender,$this->UserMailConstructer,$this->UserMailActiveID, $this->TitleOfMail);
    }

    public function GetMailContentViaParam($UserMailActiveID){

        if($stmt=$this->DataBaseCon->prepare("SELECT UserMailActiveID, UserMailSender, UserMailConstructer, UserMailTitle FROM B2C.MailSetting WHERE UserMailActiveID=?")){
            $stmt->bind_param('s',$UserMailActiveID);
            $stmt->execute();
            $stmt->bind_result($UserMailActiveID,$UserMailSender,$UserMailConstructer,$UserMailTitle);
            while($stmt->fetch()){
                $TmpArray=array('UserMailActiveID'=>$UserMailActiveID,'UserMailSender'=>$UserMailSender,'UserMailConstructer'=>$UserMailConstructer,'UserMailTitle'=>$UserMailTitle);

            }
            $stmt->close();
            return $TmpArray;
        }
    }

    private function AddMailAndItsContent($UserMailSender,$UserMailConstructer,$UserMailActiveID,$TitleOfMail){
        if($stmt=$this->DataBaseCon->prepare("UPDATE B2C.MailSetting SET UserMailSender=?,UserMailConstructer=?,UserMailTitle=? WHERE UserMailActiveID=?")){
           $stmt->bind_param('ssss',$UserMailSender,$UserMailConstructer,$TitleOfMail,$UserMailActiveID);
           $stmt->execute();
           $stmt->close();
           return 'Saved Successful';

        }
        else
        {
            return 'Error';

        }


    }


}





?>