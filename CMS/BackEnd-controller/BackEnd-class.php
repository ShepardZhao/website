<?php

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

    public function getSettingData($SiteName,$SiteDescr,$SiteSiteUrl,$SiteSiteEmail,$SiteSiteStatus){//update record of basicsetting
        if($stmt=$this->DataBaseCon->prepare("UPDATE B2C.Option SET WebTitle=?, WebDescription=?, WebUrl=?, EMail=?, WebStatus=? WHERE OptionID=1")){
            $stmt->bind_param('sssss',$SiteName,$SiteDescr,$SiteSiteUrl,$SiteSiteEmail,$SiteSiteStatus);
            $stmt->execute();
            $stmt->close();
            return "Saved successfully";
        }
        else {

            return "Error";
        }

    }


    public function pushSettingData(){//return valuesArray
        if($stmt=$this->DataBaseCon->prepare("SELECT WebTitle,WebDescription,WebUrl,EMail,WebStatus FROM B2C.Option WHERE OptionID=1")){
            $stmt->execute();
            $stmt->bind_result($WebTitle,$WebDescription,$WebUrl,$EMail,$WebStatus);
            while ($stmt->fetch()){
                $tempArray['WebTitle']=$WebTitle;
                $tempArray['WebDescription']=$WebDescription;
                $tempArray['WebUrl']=$WebUrl;
                $tempArray['EMail']=$EMail;
                $tempArray['WebStatus']=$WebStatus;

            }
            $stmt->close();
            return $tempArray;

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

                $TemLocationArray[]=array('LocationID'=>$LocationID,'LevelOne'=>$levelOne,'LevelTwo'=>unserialize($LevelTwo));

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
                $TemLocationArray[]=array('LocationID'=>$LocationID,'LevelOne'=>$levelOne,'LevelTwo'=>unserialize($LevelTwo));

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
                    echo  "<div class='control-group'>";
                    echo  "<label class='control-label'>Please Change Root Location:</label>";
                    echo "<div class='controls'>";
                    echo "<input type='text'  id='ChangeRootLocation' class='input-xlarge' name='ChangeRootLocation' value='$value'>";
                    echo "</div>";
                    echo "</div>";
                }
                else if($key==="LevelTwo"){
                    foreach($value as $finalvalue){
                        echo "<div class='control-group'>";
                        echo "<div class='controls'>";
                        echo  "<input type='text' class='input-xlarge' name='ChangeSubLocation[]' value='$finalvalue' >";
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
                    foreach($subarray as $value){
                        echo '<p>'.$value.'</p>';
                    }
                    echo '</td>';
                }
                else{

                    echo '<td>'.$subarray.'</td>';
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
        if($stmt=$this->DataBaseCon->prepare("SELECT UserID, UserName, UserPhone, UserPhotoPath, UserMail FROM B2C.User")){
            $stmt->execute();
            $stmt->bind_result($UserID,$UserName,$UserPhone,$UserPhotoPath,$UserMail);
            while($stmt->fetch()){


            }

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
    private function GetTempActiveCode($getTempActivationCode){
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
            while($stmt->fetch()){
                $TempArray=array($TempActiveCode);

            }
            $stmt->close();
            return $TempArray;
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
           $stmt->bind_param('sss',$UserMailSender,$UserMailConstructer,$TitleOfMail,$UserMailActiveID);
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