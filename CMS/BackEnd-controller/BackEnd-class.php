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

    public function outPutTags($Tags,$Table){//display the Tags via html
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


    //put the tags into the selct option
    public function OupPutTagBySelecOption($NameOfTags,$Table){
        $tmpArray=self::getTags($NameOfTags,$Table);
        echo "<select id='$NameOfTags' class='span2 MyResttagslist'>";
        foreach ($tmpArray as $values){
            if($values!=''){
                echo "<option value='$values' id='$Table'>$values</option>";
            }
        }
        echo "</select>";


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

    public function GetAddLocation($getRootLocationPic,$getRootLocation,$GetSubLocationArray){//check whether has same value that is in the database
        if( self::PushValueCompared($getRootLocation)==="existed"){
            return "repeated";
        }

        else if($stmt=$this->DataBaseCon->prepare("INSERT INTO B2C.Location (LevelOnePic,LevelOne, LevelTwo) VALUE (?,?,?)")){
            $stmt->bind_param('sss',$getRootLocationPic,$getRootLocation,$GetSubLocationArray);
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

        if($stmt=$this->DataBaseCon->prepare("SELECT LocationID, LevelOnePic, LevelOne, LevelTwo FROM B2C.Location")){
            $stmt->execute();
            $stmt->bind_result($LocationID,$LevelOnePic, $levelOne, $LevelTwo);
            $TemLocationArray=array();
            while($stmt->fetch()){
                $TemLocationArray[]=array('LocationID'=>$LocationID,'LevelOnePic'=>$LevelOnePic,'LevelOne'=>unserialize($levelOne),'LevelTwo'=>unserialize($LevelTwo));

            }

            $stmt->close();
            return $TemLocationArray;

        }
    }

    public function GetLocationWithParma($getID){
        if($stmt=$this->DataBaseCon->prepare("SELECT LocationID, LevelOnePic,LevelOne, LevelTwo FROM B2C.Location WHERE LocationID=?")){
            $stmt->bind_param('i',$getID);
            $stmt->execute();
            $stmt->bind_result($LocationID,$LevelOnePic, $levelOne, $LevelTwo);
            $TemLocationArray=array();
            while($stmt->fetch()){
                $TemLocationArray[]=array('LocationID'=>$LocationID,'LevelOnePic'=>$LevelOnePic, 'LevelOne'=>unserialize($levelOne),'LevelTwo'=>unserialize($LevelTwo));

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




    public function GetRootLocationBySelectOption(){
        $GetLocationArray=self::GetLocationNoParma();
        echo "<select id='MyRestartuant' class='span4 MyResRootAddress'>";
        foreach ($GetLocationArray as $key=>$subArray){
            foreach ($subArray as $Secondkey=>$secondvalue){
                if($Secondkey==='LevelOne'){
                    foreach($secondvalue as $finalKey=>$value)
                echo "<option value='$value' id='$value'>$value</option>";
            }
            }

        }
        echo "</select>";










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
                        echo "<div class='control-group changeSubGroup'>";
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
        echo "<button class='button ChangeLocationButton_AddMore' type='button'>More</button> ";
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
        echo '<td><h6>Location ID</h6></td>';
        echo '<td><h6>Root Location photo</h6></td>';
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
                elseif ($key==='LevelOnePic'){

                    echo "<td><img src='$subarray' style='width:150px;height:90px;'></td>";

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

//delete user by user id
    public function DeleteUserByID($getArray){
        if(self::_DeleteUserByID($getArray)==='completed'){
            $getJson_DecodeUserArray=json_decode(self::ReadAllUser($GetEmail));
            return self::ListAllUsers($getJson_DecodeUserArray);
        }

    }





//Get external email to display the user list
    public function DisplayUserListByEmail($GetEmail){
        if ($GetEmail==='All'){
            $getJson_DecodeUserArray=json_decode(self::ReadAllUser($GetEmail));
            return self::ListAllUsers($getJson_DecodeUserArray);
        }
        else{
            $getJson_DecodeUserArray=json_decode(self::SearchUser($GetEmail));
            return self::ListAllUsers($getJson_DecodeUserArray);

        }
    }


    //No condition to Display all user's
    public function DisplayDefaultUserList(){

        $json_decode_UserArray=json_decode(self::ReadAllUser());
        self::ListAllUsers($json_decode_UserArray);

    }


    //delete user the UserID(one or more)
    private function _DeleteUserByID($array){
       foreach ($array as $value){
       if($stmt=$this->DataBaseCon->prepare("DELETE FROM B2C.User WHERE UserID = ?")){
           $stmt->bind_param('s',$value);
           $stmt->execute();
           $stmt->close();

       }
       }
        return 'completed';

    }

    //List and Dispaly All Users
    private function ListAllUsers($Get_Json_decode_array){
        $json_decode_UserArray=$Get_Json_decode_array;
        echo "<table class='table table-striped' id='UserTableList'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>User ID</th>";
        echo "<th>User Name</th>";
        echo "<th>User Phone</th>";
        echo "<th>User Pic</th>";
        echo "<th>User Mail</th>";
        echo "<th>User Points</th>";
        echo "<th>User AD Position</th>";
        echo "<th>User Type</th>";
        echo "<th>Delete</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        foreach ($json_decode_UserArray as $key=>$subArray)
        {
            echo '<tr>';
            foreach($subArray as $subKey=>$value){
                if($subKey==='UserID'){
                    echo "<td>$value</td>";
                    $GetUserID=$value;
                }
                else if($subKey==='UserName'){
                    echo "<td>$value</td>";
                }
                else if($subKey==='UserPhone'){
                    echo "<td>$value</td>";
                }
                else if($subKey==='UserPhotoPath'){
                    echo "<td><img src=$value class='img-circle' style='width:65px;height:65px'></td>";
                }
                else if($subKey==='UserMail'){
                    echo "<td>$value</td>";
                }
                else if($subKey==='UserPoints'){
                    echo "<td>$value</td>";
                }
                else if($subKey==='UserADPosition'){
                    echo "<td>$value</td>";
                }
                else if($subKey==='UserType'){
                    echo "<td>$value</td>";
                }


            }
            echo "<td> <input type='checkbox' value=$GetUserID name='SelectUser' class='checkboxclass'></td>";

            echo '</tr>';
        }

        echo "</tbody>";

        echo "</table>";

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
      if($stmt=$this->DataBaseCon->prepare("SELECT UserID, UserName, UserPhone, UserPhotoPath, UserMail, UserPoints, UserADPosition, UserType, UserStatus FROM B2C.User WHERE UserMail=?")){
          $stmt->bind_param('s',$UserEmail);
          $stmt->execute();
          $stmt->bind_result($UserID, $UserName, $UserPhone, $UserPhotoPath, $UserMail, $UserPoints, $UserADPosition, $UserType, $UserStatus);
          $result = $stmt->get_result();
          $object=array();
          while ($row=$result->fetch_assoc()){

              array_push($object,$row);
          }
          $stmt->close();
          return json_encode($object); //return all user infor by json;
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
        if($stmt=$this->DataBaseCon->prepare("SELECT UserID, UserName, UserPassWord, UserPhone, UserPhotoPath, UserMail, UserType FROM B2C.User WHERE UserMail=? AND UserPassWord=?")){
            $stmt->bind_param('ss',$GetEmail,$GetEncryedPassword);
            $stmt->execute();
            $stmt->bind_result($UserID,$UserName,$UserPassWord,$UserPhone,$UserPhotoPath,$UserMail,$UserType);
            $result = $stmt->get_result();
            $object=array();
            while($row=$result->fetch_assoc()){
                array_push($object,$row);
            }
            $stmt->close();

            return json_encode($object); //returned condition user info by json;

        }


    }

//validation same UserID in Restaruant
    public function ValidSameUserIDInRestaurant($UserID){
        if($stmt=$this->DataBaseCon->prepare("SELECT User.UserID, User.UserName, User.UserPassWord, User.UserPhone, User.UserPhotoPath, User.UserMail, User.UserType, Restaurants.RestID, Restaurants.ResPicPath, Restaurants.ResName FROM B2C.User LEFT JOIN B2C.Restaurants ON User.UserID=Restaurants.UserID WHERE Restaurants.UserID=?")){
            $stmt->bind_param('s',$UserID);
            $stmt->execute();
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

    public function GetParamOfMyaddressBook($GetUserID,$GetNickName,$GetPhone,$GetAddress,$DefaultStauts){
        $this->GetUserID=$GetUserID;
        $this->GetNickName=$GetNickName;
        $this->GetPhone=$GetPhone;
        $this->GetAddress=$GetAddress;
        if (self::AddMyaddressbook($DefaultStauts)==='ok'){
            return self::loopDisplayAddressCard($this->GetUserID);

        }
        else{
            return self::AddMyaddressbook($DefaultStauts);
        }

    }

    public function GetParamOfMyaddressBookForFrontEndAddress($GetUserID,$GetNickName,$GetPhone,$GetAddress,$DefaultStauts){
        $this->GetUserID=$GetUserID;
        $this->GetNickName=$GetNickName;
        $this->GetPhone=$GetPhone;
        $this->GetAddress=$GetAddress;
        return self::AddMyaddressbook($DefaultStauts);

    }


    private function AddMyaddressbook($DefaultStauts){
      if (self::CompareInfo()==='pass'){
        if($stmt=$this->DataBaseCon->prepare("INSERT INTO B2C.UserAddressBook (AddressBookID,UserID, AddreNickName,AddrePhone,AddresAddress,AddreStatus) VALUES (null,?,?,?,?,?)")){
           //default is not been taken;
           $stmt->bind_param('isisi',$this->GetUserID,$this->GetNickName,$this->GetPhone,$this->GetAddress,$DefaultStauts);
           $stmt->execute();
           $stmt->close();
            return 'ok';
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

   protected function readAllAddressbookByID($GegID){//read all record from table
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

//Get Default address
    protected function readAllAddressbookByIDAndDefaultStauts($GegID,$Default){//read all record from table
        if ($stmt=$this->DataBaseCon->prepare("SELECT AddreStatus,AddressBookID,UserID,AddreNickName,AddrePhone,AddresAddress FROM B2C.UserAddressBook WHERE UserID=? AND AddreStatus=?")){
            $stmt->bind_param('ii',$GegID,$Default);
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

/***************************************************Resturants Regisation (not front registation, cms only)***********************************************/
class ResturantsReg extends User{
    private $ResturantRegisterID=null;
    private $ResturantRegisterPass=null;
    private $ResturantRegisterEmail=null;
    private $ResturantRegisterType=null;
    private $ResturantRegisterStatus=null;

    public function __construct($DataBaseCon){
        parent::__construct($DataBaseCon);
    }

    public function ResturantRegisation($ResturantRegisterID,$ResturantRegisterEmail,$ResturantRegisterPass,$ResturantRegisterStatus,$ResturantRegisterType){
        $this->ResturantRegisterID=$ResturantRegisterID;
        $this->ResturantRegisterEmail=$ResturantRegisterEmail;
        $this->ResturantRegisterPass=$ResturantRegisterPass;
        $this->ResturantRegisterStatus=$ResturantRegisterStatus;
        $this->ResturantRegisterType=$ResturantRegisterType;
        return self::MartchEmail($this->ResturantRegisterEmail);
    }
    private function MartchEmail($GetEmail){
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

            return self::InsertRestaurantToDatabase();

        }

    }
private function InsertRestaurantToDatabase(){

         $condition1=0;
         $condition2=0;
        if($stmt=$this->DataBaseCon->prepare("INSERT INTO B2C.User (UserID,UserMail,UserPassWord,UserStatus,UserType) VALUES (?,?,?,?,?)")){
            $stmt->bind_param('issis',$this->ResturantRegisterID,$this->ResturantRegisterEmail,md5(base64_encode($this->ResturantRegisterPass)),$this->ResturantRegisterStatus,$this->ResturantRegisterType);
            $stmt->execute();
            $stmt->close();
            $condition1=1;
          }

        if($stmt=$this->DataBaseCon->prepare("INSERT INTO B2C.Restaurants (UserID,RestID) VALUES (?,?)")){
            $ResID='R'.$this->ResturantRegisterID;
            $stmt->bind_param('is',$this->ResturantRegisterID,$ResID);
            $stmt->execute();
            $stmt->close();
            $condition2=1;
        }

    if($condition1===1 && $condition2===1){
        return 'successed';
    }
    else{
        return 'error';
    }



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

/**********************************************Restartuant class**********************************************************/
class Restartuant {
    private  $DataBaseCon=null;
    private  $ResUID=null;
    private  $ResID=null;
    private  $ResName=null;
    private  $ResAddress=null;
    private  $ResContactName=null;
    private  $ResContactPhone=null;
    private  $ResAvailabilityTag=null;
    private  $ResCuisineTag=null;
    private  $ResOpeningHours=null;
    private  $ResReview=null;

    public function __construct($DataBaseCon){
        $this->DataBaseCon=$DataBaseCon;
    }

    public function GetRestartuantParam($ResUID,$ResID,$ResName,$ResAddress,$ResContactName,$ResContactPhone,$ResAvailabilityTag,$ResCuisineTag,$ResOpeningHours,$ResReview){

        $this->ResUID=$ResUID;
        $this->ResID=$ResID;
        $this->ResName=$ResName;
        $this->ResAddress=$ResAddress;
        $this->ResContactName=$ResContactName;
        $this->ResContactPhone=$ResContactPhone;
        $this->ResAvailabilityTag=$ResAvailabilityTag;
        $this->ResCuisineTag=$ResCuisineTag;
        $this->ResOpeningHours=serialize($ResOpeningHours);
        $this->ResReview=$ResReview;
        return self::InsertRestaruantRecord();

    }

    private function InsertRestaruantRecord(){
       //user table
        $Condition1=0;
       //restaruant table
        $Condition2=0;
        if($stmt=$this->DataBaseCon->prepare("UPDATE B2C.User SET UserName=?, UserPhone=? WHERE UserID=?")){
           $stmt->bind_param('sii',$this->ResContactName,$this->ResContactPhone,$this->ResUID);
           $stmt->execute();
           $stmt->close();
           $Condition1=1;
        }
        if($stmt=$this->DataBaseCon->prepare("UPDATE B2C.Restaurants SET ResName=?, ResAddress=?, ResAvaliability=?, ResCuisine=?, ResOpenTime=?, ResReview=? WHERE RestID=?")){
            $stmt->bind_param('sssssis',$this->ResName,$this->ResAddress,$this->ResAvailabilityTag,$this->ResCuisineTag,$this->ResOpeningHours,$this->ResReview,$this->ResID);
            $stmt->execute();
            $stmt->close();
            $Condition2=1;

        }

        if($Condition1===1 && $Condition2===1){

            return 'Successed';
        }
        else{
            return 'Error';
        }

    }

//Restaruant's photo uploading
    public function RestaruantPhotoUploader($UID,$ResID,$ResPhotoPath){
        if($stmt=$this->DataBaseCon->prepare("UPDATE B2C.Restaurants SET ResPicPath=? WHERE RestID=? AND UserID=?")){
            $stmt->bind_param('ssi',$ResPhotoPath,$ResID,$UID);
            $stmt->execute();
            $stmt->close();
            return 'Successed';
        }
        else {
            return 'Error';
        }
    }









}


?>