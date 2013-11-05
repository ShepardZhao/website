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
        if($stmt=$this->DataBaseCon->prepare("UPDATE client_b2c.Option SET WebTitle=?, WebDescription=?, WebUrl=?, EMail=?, WebStatus=? ,WebPolicy=? WHERE OptionID=1")){
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
        if($stmt=$this->DataBaseCon->prepare("SELECT WebTitle,WebDescription,WebUrl,EMail,WebStatus,WebPolicy FROM client_b2c.Option WHERE OptionID=1")){
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


    //put the tags into the selct option-------for cuisine
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

    //put the tags into the selct option-------for cuisine
    public function MyRestaruantOupPutTagBySelecOption($NameOfTags,$Table){
        $tmpArray=self::getTags($NameOfTags,$Table);
        echo "<select id='MyRestaruant-$NameOfTags' class='span2 MyResttagslist'>";
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

        if($stmt=$this->DataBaseCon->prepare("SELECT LevelOne FROM client_b2c.Location WHERE LevelOne=?")){
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

        else if($stmt=$this->DataBaseCon->prepare("INSERT INTO client_b2c.Location (LevelOnePic,LevelOne, LevelTwo) VALUE (?,?,?)")){
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

        if($stmt=$this->DataBaseCon->prepare("SELECT LocationID, LevelOnePic, LevelOne, LevelTwo FROM client_b2c.Location")){
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
        if($stmt=$this->DataBaseCon->prepare("SELECT LocationID, LevelOnePic,LevelOne, LevelTwo FROM client_b2c.Location WHERE LocationID=?")){
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
        if($stmt=$this->DataBaseCon->prepare("DELETE FROM client_b2c.Location WHERE LocationID=?")){
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

        if($stmt=$this->DataBaseCon->prepare("UPDATE client_b2c.Location SET LevelOne=?, LevelTwo=? WHERE LocationID=?")){
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
                        echo "<option value='$value' id='$finalKey'>$value</option>";
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
        if($stmt=$this->DataBaseCon->prepare("UPDATE client_b2c.User SET UserStatus=? WHERE UserID=?")){
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
        if($stmt=$this->DataBaseCon->prepare("UPDATE client_b2c.User SET UserName=?, UserPassWord=?, UserPhone=?,UserPhotoPath=?,UserMail=? WHERE UserID=? AND UserType=?")){
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
            if($stmt=$this->DataBaseCon->prepare("DELETE FROM client_b2c.User WHERE UserID = ?")){
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
        if($stmt=$this->DataBaseCon->prepare("SELECT UserID, UserName, UserPhone, UserPhotoPath, UserMail, UserPoints, UserADPosition, UserType, UserStatus FROM client_b2c.User")){
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
        if($stmt=$this->DataBaseCon->prepare("SELECT UserID, UserName, UserFirstName, UserLastName,UserPassWord, UserPhone, UserPhotoPath, UserMail,UserAddress, UserPoints, UserADPosition, UserType, UserStatus FROM client_b2c.User WHERE UserID=?")){
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
        if($stmt=$this->DataBaseCon->prepare("SELECT UserID, UserName, UserPhone, UserPhotoPath, UserMail, UserPoints, UserADPosition, UserType, UserStatus FROM client_b2c.User WHERE UserMail=?")){
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
        if($stmt=$this->DataBaseCon->prepare("SELECT UserID, UserName, UserPassWord, UserPhone, UserPhotoPath, UserMail FROM client_b2c.User WHERE UserType=?")){
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
        if($stmt=$this->DataBaseCon->prepare("SELECT UserID, UserName, UserPassWord, UserPhone, UserPhotoPath, UserMail, UserType FROM client_b2c.User WHERE UserMail=? AND UserPassWord=?")){
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
        if($stmt=$this->DataBaseCon->prepare("SELECT User.UserID, User.UserName, User.UserPassWord, User.UserPhone, User.UserPhotoPath, User.UserMail, User.UserType, Restaurants.RestID, Restaurants.ResPicPath, Restaurants.ResName FROM client_b2c.User LEFT JOIN client_b2c.Restaurants ON User.UserID=Restaurants.UserID WHERE Restaurants.UserID=?")){
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
        if($stmt=$this->DataBaseCon->prepare("UPDATE client_b2c.User SET UserName=?, UserFirstName=?,UserLastName=?,UserPhone=?,UserMail=?, UserAddress=? WHERE UserID=?")){
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
            if($stmt=$this->DataBaseCon->prepare("UPDATE client_b2c.User SET UserPassWord=? WHERE UserID=?")){
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
        if($stmt=$this->DataBaseCon->prepare("UPDATE client_b2c.User SET UserPhotoPath=? WHERE UserID=?")){
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
            if($stmt=$this->DataBaseCon->prepare("INSERT INTO client_b2c.UserAddressBook (AddressBookID,UserID, AddreNickName,AddrePhone,AddresAddress,AddreStatus) VALUES (null,?,?,?,?,?)")){
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
        if ($stmt=$this->DataBaseCon->prepare("SELECT UserID,AddreNickName,AddrePhone,AddresAddress FROM client_b2c.UserAddressBook WHERE UserID=? AND AddreNickName=? AND AddrePhone=? AND AddresAddress=?")){
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
        if ($stmt=$this->DataBaseCon->prepare("SELECT AddreStatus,AddressBookID,UserID,AddreNickName,AddrePhone,AddresAddress FROM client_b2c.UserAddressBook WHERE UserID=?")){
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
        if ($stmt=$this->DataBaseCon->prepare("SELECT AddreStatus,AddressBookID,UserID,AddreNickName,AddrePhone,AddresAddress FROM client_b2c.UserAddressBook WHERE UserID=? AND AddreStatus=?")){
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
        if($stmt=$this->DataBaseCon->prepare("DELETE FROM client_b2c.UserAddressBook WHERE AddressBookID=?")){
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
            if($stmt=$this->DataBaseCon->prepare("UPDATE client_b2c.UserAddressBook SET AddreStatus=? WHERE AddressBookID=? AND UserID=?")){
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
        if($stmt=$this->DataBaseCon->prepare("UPDATE client_b2c.UserAddressBook SET AddreStatus=? WHERE UserID=?")){
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
        if($stmt=$this->DataBaseCon->prepare("DELETE FROM client_b2c.TempActiveCode WHERE TempActiveCode=?")){
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
        if($stmt=$this->DataBaseCon->prepare("INSERT INTO client_b2c.TempActiveCode (TempActiveCode) VALUE (?)")){
            $stmt->bind_param('s',$this->GenerateActiveCode);
            $stmt->execute();
            $stmt->close();
        }

    }
    private function selectTempActiveCode(){
        if($stmt=$this->DataBaseCon->prepare("SELECT TempActiveCode FROM client_b2c.TempActiveCode")){
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

        if($stmt=$this->DataBaseCon->prepare("SELECT UserMailActiveID, UserMailSender, UserMailConstructer, UserMailTitle FROM client_b2c.MailSetting WHERE UserMailActiveID=?")){
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
        if($stmt=$this->DataBaseCon->prepare("UPDATE client_b2c.MailSetting SET UserMailSender=?,UserMailConstructer=?,UserMailTitle=? WHERE UserMailActiveID=?")){
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
        if($stmt=$this->DataBaseCon->prepare("INSERT INTO client_b2c.User (UserID,UserMail,UserPassWord,UserStatus,UserType) VALUES (?,?,?,?,?)")){
            $stmt->bind_param('issis',$this->ResturantRegisterID,$this->ResturantRegisterEmail,md5(base64_encode($this->ResturantRegisterPass)),$this->ResturantRegisterStatus,$this->ResturantRegisterType);
            $stmt->execute();
            $stmt->close();
            $condition1=1;
        }

        if($stmt=$this->DataBaseCon->prepare("INSERT INTO client_b2c.Restaurants (UserID,RestID) VALUES (?,?)")){
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



/**********************************************Restartuant class**********************************************************/
class Restartuant {
    private  $DataBaseCon=null;
    private  $ResUID=null;
    private  $ResID=null;
    private  $ResName=null;
    private  $ResDetailAddress=null;
    private  $ResRootAddress=null;
    private  $ResContactName=null;
    private  $ResContactPhone=null;
    private  $ResAvailabilityTag=null;
    private  $ResCuisineTag=null;
    private  $ResOpeningHours=null;
    private  $ResRating=null;
    private  $ResReview=null;

    public function __construct($DataBaseCon){
        $this->DataBaseCon=$DataBaseCon;
    }

    public function GetRestartuantParam($ResUID,$ResID,$ResName,$ResDetailAddress,$ResRootAddress,$ResContactName,$ResContactPhone,$ResAvailabilityTag,$ResCuisineTag,$ResOpeningHours,$MyResRating,$ResReview){

        $this->ResUID=$ResUID;
        $this->ResID=$ResID;
        $this->ResName=$ResName;
        $this->ResDetailAddress=$ResDetailAddress;
        $this->ResRootAddress=$ResRootAddress;
        $this->ResContactName=$ResContactName;
        $this->ResContactPhone=$ResContactPhone;
        $this->ResAvailabilityTag=$ResAvailabilityTag;
        $this->ResCuisineTag=$ResCuisineTag;
        $this->ResOpeningHours=serialize($ResOpeningHours);
        $this->ResRating=$MyResRating;
        $this->ResReview=$ResReview;
        return self::InsertRestaruantRecord();

    }

    private function InsertRestaruantRecord(){
        //user table
        $Condition1=0;
        //restaruant table
        $Condition2=0;
        if($stmt=$this->DataBaseCon->prepare("UPDATE client_b2c.User SET UserName=?, UserPhone=? WHERE UserID=?")){
            $stmt->bind_param('sii',$this->ResContactName,$this->ResContactPhone,$this->ResUID);
            $stmt->execute();
            $stmt->close();
            $Condition1=1;
        }
        if($stmt=$this->DataBaseCon->prepare("UPDATE client_b2c.Restaurants SET ResName=?, ResAddress=?, ResRootAddress=?, ResAvaliability=?, ResCuisine=?, ResOpenTime=?,ResRating=?,ResReview=? WHERE RestID=?")){
            $stmt->bind_param('ssssssiis',$this->ResName,$this->ResDetailAddress,$this->ResRootAddress,$this->ResAvailabilityTag,$this->ResCuisineTag,$this->ResOpeningHours,$this->ResRating,$this->ResReview,$this->ResID);
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
        if($stmt=$this->DataBaseCon->prepare("UPDATE client_b2c.Restaurants SET ResPicPath=? WHERE RestID=? AND UserID=?")){
            $stmt->bind_param('ssi',$ResPhotoPath,$ResID,$UID);
            $stmt->execute();
            $stmt->close();
            return 'Successed';
        }
        else {
            return 'Error';
        }
    }



//fetch the all keys and values from Restaruant table by sepcial parameter
    public function GetRestaruantWithParm($ResID){
        if($stmt=$this->DataBaseCon->prepare("SELECT * FROM client_b2c.Restaurants WHERE RestID=?")){
            $stmt->bind_param('s',$ResID);
            $stmt->execute();
            $stmt->bind_result();
            $result = $stmt->get_result();
            $object=array();
            while($row=$result->fetch_assoc()){
                array_push($object,$row);
            }
            $stmt->close();
            return json_encode($object);
        }
    }

 //fetch the ID and Name
    public function FetchRestaruantName($ResID){
        if($stmt=$this->DataBaseCon->prepare("SELECT ResName FROM client_b2c.Restaurants WHERE RestID=?")){
            $stmt->bind_param('s',$ResID);
            $stmt->execute();
            $stmt->bind_result($ResName);
            while($stmt->fetch()){
                $tmp=array("CuisineResName"=>$ResName);
            }
            $stmt->close();
            return $tmp;
        }
    }

//fetch the all keys and values from Restaruant table with objective
    public function GetRestaruant(){
        if($stmt=$this->DataBaseCon->prepare("SELECT * FROM client_b2c.Restaurants")){
            $stmt->execute();
            $stmt->bind_result();
            $result = $stmt->get_result();
            $object=array();
            while($row=$result->fetch_assoc()){
                array_push($object,$row);
            }
            $stmt->close();
            return json_encode($object);
        }
    }

    //split time
    public function explodeTime($GetArray){

        foreach ($GetArray as $key=>$value){
            $date[$key]=explode('-',$value);
        }
        return json_encode($date);

    }


    //fetch restraruant with normall array
    public function FetchRestaruant(){
        $object=array();
        if($stmt=$this->DataBaseCon->prepare("SELECT RestID,ResName,ResOpenTime,ResAddress,ResRootAddress,ResPicPath,ResRating,ResAvaliability,ResCuisine,ResReview,UserID FROM client_b2c.Restaurants WHERE ResReview=1")){
            $stmt->execute();
            $stmt->bind_result($RestID,$ResName,$ResOpenTime,$ResAddress,$ResRootAddress,$ResPicPath,$ResRating,$ResAvaliability,$ResCuisine,$ResReview,$UserID);
            $object=array();
            while($stmt->fetch()){
                $tmp=array("RestID"=>$RestID,"ResName"=>$ResName,"ResOpenTime"=>unserialize($ResOpenTime),"ResAddress"=>$ResAddress,"ResRootAddress"=>$ResRootAddress,"PicPath"=>$ResPicPath,"ResRating"=>$ResRating,"ResAvaliability"=>$ResAvaliability,"ResCuisine"=>$ResCuisine,"ResReview"=>$ResReview,"UserID"=>$UserID);
                array_push($object,$tmp);
            }
            $stmt->close();
            return $object;
        }
    }

    public function RestartuantProcess($getCuisineArray){
        foreach ($getCuisineArray as $RootKey=>$subArray){
            foreach ($subArray as $key=>$value){
                if($key==='CuisineRestID'){
                    if(count($this->FetchRestaruantName($value))>0){
                        $getCuisineArray[$RootKey]=array_merge($getCuisineArray[$RootKey],$this->FetchRestaruantName($value));
                    }
                }
            }
        }


      foreach ($this->FetchRestaruant() as $ReKey=>$ReValue){
          array_push($getCuisineArray,$ReValue);
       }


    return $getCuisineArray;

    }

    //return restartuant that contains location
    public function ReturnResLocation($locationName){
        if($stmt=$this->DataBaseCon->prepare("SELECT RestID,ResName,ResOpenTime,ResAddress,ResRootAddress,ResPicPath,ResRating,ResAvaliability,ResCuisine,ResReview FROM client_b2c.Restaurants WHERE ResRootAddress=? AND ResReview=?")){
            $object=array();
            $Rereview=1;
            $stmt->bind_param('si',$locationName,$Rereview);
            $stmt->execute();
            $stmt->bind_result($RestID,$ResName,$ResOpenTime,$ResAddress,$ResRootAddress,$ResPicPath,$ResRating,$ResAvaliability,$ResCuisine,$ResReview);
            while($stmt->fetch()){
                $tmp=array("RestID"=>$RestID,"ResName"=>$ResName,"ResOpenTime"=>unserialize($ResOpenTime),"ResDetailAddress"=>$ResAddress,"ResRootAddress"=>$ResRootAddress,"PicPath"=>$ResPicPath,"ResRating"=>$ResRating,"ResAvaliability"=>$ResAvaliability,"ResCuisine"=>$ResCuisine,"ResReview"=>$ResReview);
                array_push($object,$tmp);
            }
            $stmt->close();
            return $object;
        }

    }



}




/*************************************************Cuisine Class***********************************************/

class Cuisine{
    private  $DataBaseCon=null;
    private  $CurrentCusineID=null;
    private  $CurrentResID=null;
    private  $CurrentCuisineName=null;
    private  $CurrentCuisineDes=null;
    private  $CurrentCuisinePrice=null;
    private  $CurrentCuisineAvali=null;
    private  $CurrentAvaliTag=null;
    private  $CurrentCusinTag=null;
    private  $CurrentCusinTypeTag=null;
    private  $CurrentCusinPriceTag=null;
    private  $CurrentCusinOrder=null;

    public function __construct($DataBaseCon){
        $this->DataBaseCon=$DataBaseCon;
    }

    public function getParamOfCuisine($CurrentCusineID,$CurrentResID,$CurrentCuisineName,$CurrentCuisineDes,$CurrentCuisinePrice,$CurrentCuisineAvali,$CurrentAvaliTag,$CurrentCusinTag,$CurrentCusinTypeTag,$CurrentCusinPriceTag,$CurrentCusinOrder){
        $this->CurrentCusineID=$CurrentCusineID;
        $this->CurrentResID=$CurrentResID;
        $this->CurrentCuisineName=$CurrentCuisineName;
        $this->CurrentCuisineDes=$CurrentCuisineDes;
        $this->CurrentCuisinePrice=$CurrentCuisinePrice;
        $this->CurrentCuisineAvali=$CurrentCuisineAvali;
        $this->CurrentAvaliTag=$CurrentAvaliTag;
        $this->CurrentCusinTag=$CurrentCusinTag;
        $this->CurrentCusinTypeTag=$CurrentCusinTypeTag;
        $this->CurrentCusinPriceTag=$CurrentCusinPriceTag;
        $this->CurrentCusinOrder=$CurrentCusinOrder;
        return self::InsertFirstLevelCuisine();
    }


    //Order check
    public function CuisineOrderCheck($GetOrder,$ResID){
        if(count(json_decode(self::CuisineOrderCheckDatabase($GetOrder,$ResID)))>0){
            return 'Repeated Order';
        }
        else {
            return 'Current Order is available';
        }
    }

    //Upload and update photo
    public function CuisinePhotoUploadingAndUpdating($CurrentCuid,$PicPath,$DeleteOldPhotoPath){
        if($stmt=$this->DataBaseCon->prepare("UPDATE client_b2c.Cuisine SET CuPicPath=? WHERE CuID=?")){
            $stmt->bind_param('ss',$PicPath,$CurrentCuid);
            $stmt->execute();
            $stmt->close();
            unlink($DeleteOldPhotoPath);//delete old photo
            return 'You have successfully uploaded photo';
        }
        else{
            return 'Database Error';
        }
    }


    //Order check from database
    private function CuisineOrderCheckDatabase($GetOrder,$ResID){
        if($stmt=$this->DataBaseCon->prepare("SELECT * FROM client_b2c.Cuisine WHERE CuOrder=? AND RestID=?")){
            $stmt->bind_param('is',$GetOrder,$ResID);
            $stmt->execute();
            $stmt->bind_result();
            $result = $stmt->get_result();
            $object=array();
            while($row=$result->fetch_assoc()){
                array_push($object,$row);
            }
            $stmt->close();
            return json_encode($object);
        }
    }

    //Cuisine First Level insert function
    private function InsertFirstLevelCuisine(){
        if($stmt=$this->DataBaseCon->prepare("INSERT INTO client_b2c.Cuisine (CuID,CuName,CuDescr,Avaliability,CuAvaliability,CuCuisine,CuType, CuPrice, RestID, CuReview,CuOrder,Price,CuRating) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)")){
            $CuReview=0;
            $CuRating=0;
            $stmt->bind_param('sssssssssiidi',$this->CurrentCusineID,$this->CurrentCuisineName,$this->CurrentCuisineDes,$this->CurrentCuisineAvali,$this->CurrentAvaliTag,$this->CurrentCusinTag,$this->CurrentCusinTypeTag,$this->CurrentCusinPriceTag,$this->CurrentResID,$CuReview,$this->CurrentCusinOrder,$this->CurrentCuisinePrice,$CuRating);
            $stmt->execute();
            $stmt->close();
            return 'Submit successful';
        }
        else{
            return 'Error';
        }
    }
    //Insert record into Second Level of current cuisine: table name is SecondLevelofCuisine
    public function CuisineSecondLevel($PassCuid,$SecondLevelTitleAndContent){
        $condition=0;

        foreach ($SecondLevelTitleAndContent as $key=>$content){
            if($stmt=$this->DataBaseCon->prepare("INSERT INTO client_b2c.SecondLevelofCuisine (SeLevelTitle,SeLevelMultiple,CuID) VALUES (?,?,?)")){
                $stmt->bind_param('sss',$key,serialize($content),$PassCuid);
                $stmt->execute();
                $stmt->close();
            }
            else{
                $condition=1;
            }
        }

        if($condition===1){
            return 'Error';
        }
        else{
            return 'Submit successful';
        }

    }

    //Update record of Second Level of current cuisine
    public function CuisineSecondLevelWidthUpdate($updatePassCuid,$updateKey,$updateSecondLevelTitleAndContent){
        $count=0;
        $condition=0;//success condition with update:default is success
        $condition2=0;////success condition with insert:default is success
        foreach ($updateSecondLevelTitleAndContent as $Updatekey=>$Updatecontent){
            if($count<count($updateKey)){//compare with unique that if unique key is exeisted then update, otherwise insert new record into the database

                if($stmt=$this->DataBaseCon->prepare("UPDATE client_b2c.SecondLevelofCuisine SET SeLevelTitle=?, SeLevelMultiple=? WHERE SecLevelCuID=? AND CuID=?")){
                    $stmt->bind_param('ssss',$Updatekey,serialize($Updatecontent),$updateKey[$count],$updatePassCuid);
                    $count++;
                    $stmt->execute();
                    $stmt->close();

                }
                else{
                    $condition=1;
                }
            }

            else{
                if($stmt=$this->DataBaseCon->prepare("INSERT INTO client_b2c.SecondLevelofCuisine (SeLevelTitle,SeLevelMultiple,CuID) VALUES (?,?,?)")){
                    $stmt->bind_param('sss',$Updatekey,serialize($Updatecontent),$updatePassCuid);
                    $stmt->execute();
                    $stmt->close();
                }
                else{
                    $condition2=1;

                }
            }

        }

        if($condition===1 || $condition2===1){
            return 'Error';
        }
        else{
            return 'Update successful';
        }

    }


    //Select SecondLevelofCuisine from table SecondLevelofCuisine
    public function GetSecondLevelofCuisine($getCuid){
        if($stmt=$this->DataBaseCon->prepare("SELECT * FROM client_b2c.SecondLevelofCuisine WHERE CuID=?")){
            $stmt->bind_param('s',$getCuid);
            $stmt->execute();
            $stmt->bind_result();
            $result = $stmt->get_result();
            $object=array();
            while($row=$result->fetch_assoc()){
                array_push($object,$row);
            }
            $stmt->close();
            return json_encode($object);
        }

    }

    //Select SecondLevelofCuisine from table SecondLevelofCuisine
    public function GetSecondLevelofCuisineByUnqieID($getUniqeID){
        if($stmt=$this->DataBaseCon->prepare("SELECT * FROM client_b2c.SecondLevelofCuisine WHERE SecLevelCuID=?")){
            $stmt->bind_param('i',$getUniqeID);
            $stmt->execute();
            $stmt->bind_result();
            $result = $stmt->get_result();
            $object=array();
            while($row=$result->fetch_assoc()){
                array_push($object,$row);
            }
            $stmt->close();
            return json_encode($object);
        }

    }

    //Delete Second level with wrap
    public function DeleteSecondWrap($getUniqueID){
        if($stmt=$this->DataBaseCon->prepare("DELETE FROM client_b2c.SecondLevelofCuisine WHERE SecLevelCuID=?")){
            $stmt->bind_param('i',$getUniqueID);
            $stmt->execute();
            $stmt->close();
            return 'Delete Successful';
        }
        else{
            return 'Error';
        }
    }
//***************************************************************************
    private function  ReturnSeLevelMultiple($getArray){
       $tmp=array();
        foreach ($getArray as $key=>$arrayValue){
            foreach ($arrayValue as $subkey=>$subValue){
                if($subkey==='SeLevelMultiple'){
                    $tmp=unserialize($subValue);

                }
            }
        }
        return $tmp;
    }
    private function ReturnCompareValue($getUnserializeSeLevelMultiple,$GetName,$GetPrice){
        $condition=0;
        $condiiion1=0;
        foreach ($getUnserializeSeLevelMultiple as $key=>$value){
                 foreach ($value as $subkey=>$content){
                     if ($subkey==='name' && $content===$GetName){
                         $condition=1;
                     }
                     elseif ($subkey==='price' && $content===$GetPrice){
                         $condiiion1=1;
                     }

                     if($condition===1 && $condiiion1===1){
                         return $key;
                     }
                 }
            }
    }

    private function deleteAndUpdate($UniqueID,$getDeleteIndex,$getUnserializeSeLevelMultiple){
       unset($getUnserializeSeLevelMultiple[$getDeleteIndex]);
        if($stmt=$this->DataBaseCon->prepare("UPDATE client_b2c.SecondLevelofCuisine SET SeLevelMultiple=? WHERE SecLevelCuID=?")){
            $stmt->bind_param('si',serialize($getUnserializeSeLevelMultiple),$UniqueID);
            $stmt->execute();
            $stmt->close();
            return 'Delete Successfully!';
        }
        else{
            return 'Delete Error';
        }
    }

    //Delete inside Second level
    public function DeleteInsideSecondLevel($GetUniqueID,$GetName,$GetPrice){
        /*According to UniqueID to get Matched array*/
        $getArray=json_decode($this->GetSecondLevelofCuisineByUnqieID($GetUniqueID));
        /*According to array to get sub array that we will use later*/
        $getUnserializeSeLevelMultiple=$this->ReturnSeLevelMultiple($getArray);
        /*Pass the sub array and name and price to find the index key*/
        $getDeleteIndex=$this->ReturnCompareValue($getUnserializeSeLevelMultiple,$GetName,$GetPrice);
        /*According to index key to delete record that exeisted and saved the result to database*/
        return $this->deleteAndUpdate($GetUniqueID,$getDeleteIndex,$getUnserializeSeLevelMultiple);
    }

    //Delete Current Cuisine
    public function DeleteCuisine($GetDeleteID){
        $condition1=0;
        $condition2=0;
        if($stmt=$this->DataBaseCon->prepare("DELETE FROM client_b2c.Cuisine WHERE client_b2c.Cuisine.CuID=?")){
            $stmt->bind_param('s',$GetDeleteID);
            $stmt->execute();
            $stmt->close();
            $condition1=1;
        }
        else{
            return 'Error';
        }

        if($stmt=$this->DataBaseCon->prepare("DELETE FROM client_b2c.SecondLevelofCuisine WHERE client_b2c.SecondLevelofCuisine.CuID=?")){
            $stmt->bind_param('s',$GetDeleteID);
            $stmt->execute();
            $stmt->close();
            $condition2=1;
        }
        else{
            return 'Error';
        }

        if($condition1===1 && $condition2===1){
            return 'Delete Successful';
        }


    }



    //public Cuisine First Level updating
    public function UpdateFirstLevelCuisine($UpCurrentCusineID,$UpCurrentCuisineName,$UpCurrentCuisineDes,$UpCurrentCuisinePrice,$UpCurrentCuisineAvali,$CurrentAvaliTag,$CurrentCusinTag,$CurrentCusinTypeTag,$CurrentCusinPriceTag){
        if($stmt=$this->DataBaseCon->prepare("UPDATE client_b2c.Cuisine SET CuName=?,CuDescr=?, Price=?, Avaliability=?, CuAvaliability=?, CuCuisine=?, CuType=?, CuPrice=? WHERE CuID=?")){
            $stmt->bind_param('ssdssssss',$UpCurrentCuisineName,$UpCurrentCuisineDes,$UpCurrentCuisinePrice,$UpCurrentCuisineAvali,$CurrentAvaliTag,$CurrentCusinTag,$CurrentCusinTypeTag,$CurrentCusinPriceTag,$UpCurrentCusineID);
            $stmt->execute();
            $stmt->close();
            return 'Update successful';
        }
        else{
            return 'Error';
        }
    }

    //return normal dataset of cuisine
    private function ReturnDataOfNormalCuisine($getResID){
        if($stmt=$this->DataBaseCon->prepare("SELECT CuOrder,Avaliability,CuName,CuPicPath,CuDescr,Price,CuAvaliability,CuCuisine,CuType,CuPrice,CuID FROM client_b2c.Cuisine WHERE RestID=? ORDER BY CuOrder")){
            $stmt->bind_param('s',$getResID);
            $stmt->execute();
            $stmt->bind_result($CuOrder,$Avaliability,$CuName,$CuPicPath,$CuDescr,$Price,$CuAvaliability,$CuCuisine,$CuType,$CuPrice,$CuID);
            $result = $stmt->get_result();
            $object=array();
            while($row=$result->fetch_assoc()){
                array_push($object,$row);
            }
            $stmt->close();
            return json_encode($object);
        }
    }
    //return second dataset level of cuisine
    private function ReturnDataOfSecondCuisine($getCuID){
        if($stmt=$this->DataBaseCon->prepare("SELECT * FROM client_b2c.Cuisine LEFT JOIN client_b2c.SecondLevelofCuisine ON Cuisine.CuID=SecondLevelofCuisine.CuID WHERE SecondLevelofCuisine.CuID=?")){
            $stmt->bind_param('s',$getCuID);
            $stmt->execute();
            $stmt->bind_result();
            $result = $stmt->get_result();
            $object=array();
            while($row=$result->fetch_assoc()){
                array_push($object,$row);
            }
            $stmt->close();
            return json_encode($object);
        }


    }


    //return normal dataset of cuisine by CUID
    public function ReturnDataOfNormalCuisineByID($GetCUID){
        if($stmt=$this->DataBaseCon->prepare("SELECT * FROM client_b2c.Cuisine WHERE CuID=?")){
            $stmt->bind_param('s',$GetCUID);
            $stmt->execute();
            $stmt->bind_result();
            $result = $stmt->get_result();
            $object=array();
            while($row=$result->fetch_assoc()){
                array_push($object,$row);
            }
            $stmt->close();
            return json_encode($object);
        }
    }

    //return tags only

    private function ReturnTagsOnly($GetCuid){
        if($stmt=$this->DataBaseCon->prepare("SELECT CuAvaliability,CuCuisine,CuType,CuPrice FROM client_b2c.Cuisine WHERE CuID=?")){
            $stmt->bind_param('s',$GetCuid);
            $stmt->execute();
            $stmt->bind_result($CuAvaliability,$CuCuisine,$CuType,$CuPrice);
            while($stmt->fetch()){
                $tempArray= array('Avaliability'=>$CuAvaliability,'Cuisine'=>$CuCuisine,'Type'=>$CuType,'Price'=>$CuPrice);
            }
            $stmt->close();
            return $tempArray;
        }
    }


    //reset and update order of cuisine
    public function RestAndUpdateOrderofCuisine($getArrayOfNewOrder){
        $error=0;
        foreach($getArrayOfNewOrder as $key=>$value){
            if($stmt=$this->DataBaseCon->prepare("UPDATE client_b2c.Cuisine SET CuOrder=? WHERE CuID=?")){
                $stmt->bind_param('is',$value,$key);
                $stmt->execute();
                $stmt->close();
            }
            else{
                $error=1;
            }
        }
        if($error===1){
            return 1;//means that there was error be happended.
        }
        else{
            return 0;//means that there was not error be happaed.
        }

    }


    //display the second level info pnly
    public function DisplaySecondLevel($getCuid){
        $getSecondLevelKeyAndValue=json_decode(self::ReturnDataOfSecondCuisine($getCuid));
        foreach($getSecondLevelKeyAndValue as $TotalKey=>$SubArray){
            foreach($SubArray as $key=>$value){
                if($key==='SeLevelTitle'){
                    echo "<h5>$value</h5>";
                }

                if($key==='SeLevelMultiple'){
                    $finalValue=unserialize($value);
                    foreach ($finalValue as $subkey=>$subvalue){
                        foreach ($subvalue as $lastKey=>$lastValue){
                            echo "<p>$lastKey: $lastValue </p>";

                        }


                    }


                }

            }
        }
    }


    //return second level of cuisine according to CuisineID
    private function ReturnSecondLevelbyCuID($getcuid){
         $object=array();
         $finalObject=array();
        if($stmt=$this->DataBaseCon->prepare("SELECT SeLevelTitle, SeLevelMultiple FROM client_b2c.SecondLevelofCuisine WHERE CuID=?")){
           $stmt->bind_param('s',$getcuid);
           $stmt->execute();
           $stmt->bind_result($SeLevelTitle,$SeLevelMultiple);
           while($stmt->fetch()){
               $tmp=array("SecondlevelTitle"=>$SeLevelTitle,"SecondLevelContent"=>unserialize($SeLevelMultiple));
               array_push($object,$tmp);
           }
            $finalObject['SecondLevel']=$object;
            $stmt->close();
        return $finalObject;

        }
    }



    //return all cuisine
    private function ReturnAllCuisine(){
        $tmp=array();

        if($stmt=$this->DataBaseCon->prepare("SELECT CuID,CuName,CuDescr,CuPicPath,Avaliability,CuAvaliability,CuCuisine,CuType,CuPrice,CuRating, RestID,CuOrder,Price FROM client_b2c.Cuisine WHERE CuReview=?")){
            $condition=1;
            $stmt->bind_param('i',$condition);
            $stmt->execute();
            $stmt->bind_result($CuID,$CuName,$CuDescr,$CuPicPath,$Avaliability,$CuAvaliability,$CuCuisine,$CuType,$CuPrice,$CuRating, $RestID,$CuOrder,$Price);
            while($stmt->fetch()){

                $object=array("CuisineID"=>$CuID,"CuisineName"=>$CuName,"CuisineDescription"=>$CuDescr,"PicPath"=>$CuPicPath,"CuisineAvaliability"=>$Avaliability,"CuisineAvaliabilityTag"=>$CuAvaliability,"CuisineCuisineTag"=>$CuCuisine,"CuisineTypeTag"=>$CuType,"CuisinePriceTag"=>$CuPrice,"CuisineRating"=>$CuRating,"CuisineRestID"=>$RestID,"CuisineOrder"=>$CuOrder,"CuisinePrice"=>$Price);
                array_multisort($object);
                array_push($tmp,$object);
            }
            $stmt->close();
            return $tmp;
        }
    }


    private function ReturnfinalCuisine($allCuisine){
        foreach ($allCuisine as $RootKey=>$subArray){
            foreach ($subArray as $key=>$value){
                if ($key==='CuisineID'){
                    if(count($this->ReturnSecondLevelbyCuID($value))>0){
                        $allCuisine[$RootKey]=array_merge($allCuisine[$RootKey],$this->ReturnSecondLevelbyCuID($value));
                    }
                }
            }
        }
        return $allCuisine;

    }




    //return cusisine and its second level
    public function CuisineWithSeondLevel(){
        //return all cuisine
        $getAllCuisine=$this->ReturnAllCuisine();
        //return cuisine and its ResName and ID
        return  $this->ReturnfinalCuisine($getAllCuisine);

    }

    private function FilterCuisine($getResID,$AllCuisine){
        $object=array();
        $returnObject=array();
        foreach ($AllCuisine as $key=>$subArray){
            foreach ($subArray as $finalKey=>$Value){
                if($finalKey==="CuisineRestID"){
                    if($Value===$getResID){
                        array_push($object,$subArray);
                    }
                }
            }
        }
        $returnObject['Cuisine']=$object;
        return $returnObject;

    }


    //return cuisine that followed by order with ASC and matched its ResID
    public function ReturnCuisineWithOrderByResID($ResArray){
       $getAllCuisine=$this->CuisineWithSeondLevel();
            foreach ($ResArray as $key=>$subArray){
                foreach($subArray as $SubKey=>$SubValue){
                    if($SubKey==='RestID'){
                        $ResArray[$key]=array_merge($ResArray[$key],$this->FilterCuisine($SubValue,$getAllCuisine));

                    }
                }


            }

return $ResArray;

    }

    //return cuisine
    private function ReturnFindCuisine($ResID,$AllCuisine){
        $RestartuantClass=new Restartuant($this->DataBaseCon);
        $object=array();
        foreach ($AllCuisine as $key=>$subArray){
            foreach ($subArray as $finalKey=>$Value){
                if($finalKey==="CuisineRestID"){
                    if($Value===$ResID){
                        $NewsubArray=array_merge($subArray,$RestartuantClass->FetchRestaruantName($Value));

                        array_push($object,$NewsubArray);
                    }
                }
            }
        }
        return $object;
    }




    //Filter cuisine according to Restaruant

    public function ReturnCuisineAccordingToRes($ResArray){
        $tmp=array();
        $getAllCuisine=$this->CuisineWithSeondLevel();
        foreach ($ResArray as $key=>$subArray){
            foreach($subArray as $SubKey=>$SubValue){
                if($SubKey==='RestID'){
                    if(count($this->ReturnFindCuisine($SubValue,$getAllCuisine))>0){

                        foreach ($this->ReturnFindCuisine($SubValue,$getAllCuisine) as $insideKey=>$insidevalue){
                            array_push($ResArray,$insidevalue);
                        }
                    }

                }
            }


        }
        sort($ResArray);
        return $ResArray;
    }


    //list cuisine into table
    public function listCuisineTable($getResid){
        $GetNormalDataset=json_decode(self::ReturnDataOfNormalCuisine($getResid));
        echo '<table class="table table-striped" id="CusinesTable">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>Order</th>';
        echo '<th>Avaliable</th>';
        echo '<th>Name</th>';
        echo '<th>Picture</th>';
        echo '<th>Description</th>';
        echo '<th>Price</th>';
        echo '<th>Tags</th>';
        echo '<th>Second Level</th>';
        echo '<th></th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        foreach ($GetNormalDataset as $Rootkey=>$SubArray){
            echo "<tr id=$Rootkey>";
            foreach ($SubArray as $key=>$value){
                if($key==='CuOrder'){
                    echo '<td id="OrderPostion"><i class="icon-caret-up-table fa fa-caret-up"></i><h5>'.$value.'</h5><i class="icon-caret-down-table fa fa-caret-down"></i></td>';
                }
                if($key==='Avaliability'){
                    echo '<td>'.$value.'</td>';
                }
                if($key==='CuName'){
                    echo "<td class='CuName' id='$value'><div class='TablePreventOverflow' title='$value'>$value</div></td>";
                }
                if($key==='CuPicPath'){
                    if(isset($value)){
                        echo "<td><a href='$value' target='_blank'><img style='width:50px;height:50px' src='$value'></a><button class='btn TableButtonStyle UploadCuisPhoto' type='button'>Edit</button></td>";


                    }
                    else{
                        echo '<td><button class="btn TableButtonStyle UploadCuisPhoto" type="button">Uploads Photo</button></td>';

                    }
                }
                if($key==='CuDescr'){
                    echo "<td><div class='TablePreventOverflow' title='$value'>$value</div></td>";
                }
                if($key==='Price'){
                    echo '<td>$'.$value.'</td>';
                }

                if($key==='CuID'){
                    echo "<td><div class='btn-group dropup'><button class='btn TableButtonStyle ShowTags dropdown-toggle' data-toggle='dropdown' id='$value' type='button'>Shows Tags</button><button class='btn TableButtonStyle dropdown-toggle' data-toggle='dropdown'><span class='caret'></span></button><ul class='dropdown-menu'>";
                    foreach (self::ReturnTagsOnly($value) as $TagKeys=>$Tagvalue){
                        echo "<li><a tabindex='-1'>$TagKeys:$Tagvalue</a></li>";
                    }
                    echo '</ul></td>';

                    if(count(json_decode(self::ReturnDataOfSecondCuisine($value)))>0){
                        echo "<td><div class='btn-group dropup'><button class='btn TableButtonStyle dropdown-toggle' data-toggle='dropdown'>Edit&Show</button>  <button class='btn TableButtonStyle dropdown-toggle' data-toggle='dropdown'><span class='caret'></span></button><ul class='dropdown-menu dropdown-menu-Cuisine-table'><li><a tabindex='-1' id='$value' class='EditSecondLevel'>Edits Second Level</a></li></ul></div>";
                    }
                    else{
                        echo "<td><button class='btn TableButtonStyle AddSecondLevel' id='$value' type='button'>Adds Second Level</button></td>";
                    }
                    echo '<td>';
                    echo '<div class="form-inline">';
                    echo "<button class='button subbutton subAddNewBotton EditCusine' id='$value' type='button' >Edit</button> ";
                    echo "<button class='button text-right button-delete' id='$value' type='button'>Delete</button>";
                    echo '</div>';
                    echo '</td>';


                }


            }
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';

    }


}



/**********************************************Img watermark*******************************************/

class waterMarker{

    private $imgPath;

    public function __construct($path){
        $this->imgPath = $path;
    }

    public function waterInfo($ground,$water,$pos=0,$prefix="lee_",$tm=50){
        $allPathGround  = $this->imgPath.$ground;
        $allPathWater   = $this->imgPath.$water;
        $groundInfo = $this->imgInfo($allPathGround);
        $waterInfo  = $this->imgInfo($allPathWater);


        if(!$newPos=$this->imgPos($groundInfo,$waterInfo,$pos)){
            echo "Your WaterMarker is too large";
            return false;
        }

        //open sources
        $groundRes=$this->imgRes($allPathGround,$groundInfo['mime']);
        $waterRes=$this->imgRes($allPathWater,$waterInfo['mime']);

        //Intergrate sources
        $newGround=$this->imgCopy($groundRes,$waterRes,$newPos,$waterInfo,$tm);

        //Save sources
        $this->saveImg($newGround,$ground,$groundInfo['mime'],$prefix);

    }

    private function saveImg($img,$ground,$info,$prefix){
        $path=$this->imgPath.$prefix.$ground;
        switch($info){
            case "image/jpg":
            case "image/jpeg":
            case "image/pjpeg":
                imagejpeg($img,$path);
                break;
            case "image/gif":
                imagegif($img,$path);
                break;
            case "image/png":
                imagepng($img,$path);
                break;
            default:
                imagegd2($img,$path);
        }
    }

    private function imgCopy($ground,$water,$pos,$waterInfo,$tm){
        imagecopymerge($ground,$water,$pos[0],$pos[1],0,0,$waterInfo[0],$waterInfo[1],$tm);
        return $ground;
    }

    private function imgRes($img,$imgType){
        switch($imgType){
            case "image/jpg":
            case "image/jpeg":
            case "image/pjpeg":
                $res=imagecreatefromjpeg($img);
                break;
            case "image/gif":
                $res=imagecreatefromgif($img);
                break;
            case "image/png":
                $res=imagecreatefrompng($img);
                break;
            case "image/wbmp":
                $res=imagecreatefromwbmp($img);
                break;
            default:
                $res=imagecreatefromgd2($img);
        }
        return $res;
    }

    //Position 1.Top left 2.Middle and Top 3. Top right 4. Bottom left 5 Bottom right
    private function imgPos($ground,$water,$pos){
        if($ground[0]<$water[0] || $ground[1]<$water[1])  //if WaterMarker small than original iage then return false
            return false;
        switch($pos){
            case 1:
                $x=0;
                $y=0;
                break;
            case 2:
                $x=ceil(($ground[0]-$water[0])/2);
                $y=0;
                break;
            case 3:
                $x=$ground[0]-$water[0];
                $y=0;
                break;
            case 4:
                $x=0;
                $y=ceil(($ground[1]-$water[1])/2);
                break;
            case 5:
                $x=ceil(($ground[0]-$water[0])/2);
                $y=ceil(($ground[1]-$water[1])/2);
                break;
            case 6:
                $x=$ground[0]-$water[0];
                $y=ceil(($ground[1]-$water[1])/2);
                break;
            case 7:
                $x=0;
                $y=$ground[1]-$water[1];
                break;
            case 8:
                $x=ceil($ground[0]-$water[0]/2);
                $y=$ground[1]-$water[1];
                break;
            case 9:
                $x=$ground[0]-$water[0];
                $y=$ground[1]-$water[1];
                break;
            case 0:
            default:
                $x=rand(0,$ground[0]-$water[0]);
                $y=rand(0,$ground[1]-$water[1]);
        }
        $xy[]=$x;
        $xy[]=$y;
        return $xy;
    }

    // 获取图片信息的函数
    private function imgInfo($img){
        return getimagesize($img);
    }
}


/**********************************************Img resize**********************************************/
class resize
{
    // *** Class variables
    private $image;
    private $width;
    private $height;
    private $imageResized;

    function __construct($fileName)
    {
        // *** Open up the file
        $this->image = $this->openImage($fileName);

        // *** Get width and height
        $this->width  = imagesx($this->image);
        $this->height = imagesy($this->image);
    }

    ## --------------------------------------------------------

    private function openImage($file)
    {
        // *** Get extension
        $extension = strtolower(strrchr($file, '.'));

        switch($extension)
        {
            case '.jpg':
            case '.jpeg':
                $img = @imagecreatefromjpeg($file);
                break;
            case '.gif':
                $img = @imagecreatefromgif($file);
                break;
            case '.png':
                $img = @imagecreatefrompng($file);
                break;
            default:
                $img = false;
                break;
        }
        return $img;
    }

    ## --------------------------------------------------------

    public function resizeImage($newWidth, $newHeight, $option="auto")
    {
        // *** Get optimal width and height - based on $option
        $optionArray = $this->getDimensions($newWidth, $newHeight, $option);

        $optimalWidth  = $optionArray['optimalWidth'];
        $optimalHeight = $optionArray['optimalHeight'];


        // *** Resample - create image canvas of x, y size
        $this->imageResized = imagecreatetruecolor($optimalWidth, $optimalHeight);
        imagecopyresampled($this->imageResized, $this->image, 0, 0, 0, 0, $optimalWidth, $optimalHeight, $this->width, $this->height);


        // *** if option is 'crop', then crop too
        if ($option == 'crop') {
            $this->crop($optimalWidth, $optimalHeight, $newWidth, $newHeight);
        }
    }

    ## --------------------------------------------------------

    private function getDimensions($newWidth, $newHeight, $option)
    {

        switch ($option)
        {
            case 'exact':
                $optimalWidth = $newWidth;
                $optimalHeight= $newHeight;
                break;
            case 'portrait':
                $optimalWidth = $this->getSizeByFixedHeight($newHeight);
                $optimalHeight= $newHeight;
                break;
            case 'landscape':
                $optimalWidth = $newWidth;
                $optimalHeight= $this->getSizeByFixedWidth($newWidth);
                break;
            case 'auto':
                $optionArray = $this->getSizeByAuto($newWidth, $newHeight);
                $optimalWidth = $optionArray['optimalWidth'];
                $optimalHeight = $optionArray['optimalHeight'];
                break;
            case 'crop':
                $optionArray = $this->getOptimalCrop($newWidth, $newHeight);
                $optimalWidth = $optionArray['optimalWidth'];
                $optimalHeight = $optionArray['optimalHeight'];
                break;
        }
        return array('optimalWidth' => $optimalWidth, 'optimalHeight' => $optimalHeight);
    }

    ## --------------------------------------------------------

    private function getSizeByFixedHeight($newHeight)
    {
        $ratio = $this->width / $this->height;
        $newWidth = $newHeight * $ratio;
        return $newWidth;
    }

    private function getSizeByFixedWidth($newWidth)
    {
        $ratio = $this->height / $this->width;
        $newHeight = $newWidth * $ratio;
        return $newHeight;
    }

    private function getSizeByAuto($newWidth, $newHeight)
    {
        if ($this->height < $this->width)
            // *** Image to be resized is wider (landscape)
        {
            $optimalWidth = $newWidth;
            $optimalHeight= $this->getSizeByFixedWidth($newWidth);
        }
        elseif ($this->height > $this->width)
            // *** Image to be resized is taller (portrait)
        {
            $optimalWidth = $this->getSizeByFixedHeight($newHeight);
            $optimalHeight= $newHeight;
        }
        else
            // *** Image to be resizerd is a square
        {
            if ($newHeight < $newWidth) {
                $optimalWidth = $newWidth;
                $optimalHeight= $this->getSizeByFixedWidth($newWidth);
            } else if ($newHeight > $newWidth) {
                $optimalWidth = $this->getSizeByFixedHeight($newHeight);
                $optimalHeight= $newHeight;
            } else {
                // *** Sqaure being resized to a square
                $optimalWidth = $newWidth;
                $optimalHeight= $newHeight;
            }
        }

        return array('optimalWidth' => $optimalWidth, 'optimalHeight' => $optimalHeight);
    }

    ## --------------------------------------------------------

    private function getOptimalCrop($newWidth, $newHeight)
    {

        $heightRatio = $this->height / $newHeight;
        $widthRatio  = $this->width /  $newWidth;

        if ($heightRatio < $widthRatio) {
            $optimalRatio = $heightRatio;
        } else {
            $optimalRatio = $widthRatio;
        }

        $optimalHeight = $this->height / $optimalRatio;
        $optimalWidth  = $this->width  / $optimalRatio;

        return array('optimalWidth' => $optimalWidth, 'optimalHeight' => $optimalHeight);
    }

    ## --------------------------------------------------------

    private function crop($optimalWidth, $optimalHeight, $newWidth, $newHeight)
    {
        // *** Find center - this will be used for the crop
        $cropStartX = ( $optimalWidth / 2) - ( $newWidth /2 );
        $cropStartY = ( $optimalHeight/ 2) - ( $newHeight/2 );

        $crop = $this->imageResized;
        //imagedestroy($this->imageResized);

        // *** Now crop from center to exact requested size
        $this->imageResized = imagecreatetruecolor($newWidth , $newHeight);
        imagecopyresampled($this->imageResized, $crop , 0, 0, $cropStartX, $cropStartY, $newWidth, $newHeight , $newWidth, $newHeight);
    }

    ## --------------------------------------------------------

    public function saveImage($savePath, $imageQuality="100")
    {
        // *** Get extension
        $extension = strrchr($savePath, '.');
        $extension = strtolower($extension);

        switch($extension)
        {
            case '.jpg':
            case '.jpeg':
                if (imagetypes() & IMG_JPG) {
                    imagejpeg($this->imageResized, $savePath, $imageQuality);
                }
                break;

            case '.gif':
                if (imagetypes() & IMG_GIF) {
                    imagegif($this->imageResized, $savePath);
                }
                break;

            case '.png':
                // *** Scale quality from 0-100 to 0-9
                $scaleQuality = round(($imageQuality/100) * 9);

                // *** Invert quality setting as 0 is best, not 9
                $invertScaleQuality = 9 - $scaleQuality;

                if (imagetypes() & IMG_PNG) {
                    imagepng($this->imageResized, $savePath, $invertScaleQuality);
                }
                break;

            // ... etc

            default:
                // *** No extension - No save.
                break;
        }

        imagedestroy($this->imageResized);
    }
    ##----------------------------------------------
    public function OnselectSave($CuisineOldImagePath,$targ_w,$targ_h,$CuisineX,$CuisineY,$CuisineW,$CuisineH,$CuisineOldImagePath,$savePath,$jpeg_quality,$returPath,$WaterMarkerStatus,$WaterMarkerPositon){
        $pos=strripos($CuisineOldImagePath,'/');
        $getpath=substr($CuisineOldImagePath,0,$pos+1);//path
        $getFileName=substr($CuisineOldImagePath,$pos+1);
        $changedName='small-'.$getFileName;
        $finalSavePath=$getpath.$changedName;
        $img_r = imagecreatefromjpeg($CuisineOldImagePath);
        $dst_r = ImageCreateTrueColor($targ_w,$targ_h);
        imagecopyresampled($dst_r,$img_r,0,0,$CuisineX,$CuisineY,$targ_w,$targ_h,$CuisineW,$CuisineH);
        //unlink($CuisineOldImagePath);
        header('Content-type: image/jpeg');
        imagejpeg($dst_r,$finalSavePath,$jpeg_quality);
        //return path
        $ReturnFullPath=$returPath.$changedName;
        if($WaterMarkerStatus==='yes'){
            $waterMarker=new waterMarker($getpath);
            $waterMarker->waterInfo($changedName,'WaterMarker/WaterMarker.png',$WaterMarkerPositon,"WaterMarker",20);
            unlink($finalSavePath);
            return  $returPath.'WaterMarker'.$changedName;
        }
        else if($WaterMarkerStatus==='no'){
            return $ReturnFullPath;

        }



    }


}












/************************************************json return area************************************************/
//this class is only dealing with requestments from /json/index.php that sends or deals data between phone and website
class JsonReturnOrDeal{
    private $DataBaseCon=null;
    public function __construct($DataBaseCon){
        $this->DataBaseCon=$DataBaseCon;
    }

    //return Restaurant and cuisine by location

    public function ReturnResAndCusineAccordingToLocation($locationName,$startCount,$ReturnCount,$filter){
        $CuisineClass=new Cuisine($this->DataBaseCon);
        $RestartuantClass=new Restartuant($this->DataBaseCon);
        $GetAllRes=$RestartuantClass->ReturnResLocation($locationName);
        $GetResult=$CuisineClass->ReturnCuisineAccordingToRes($GetAllRes);
        $ReturnResult=$this->returnLimitedRecord($GetResult,$startCount,$ReturnCount);
        $FinalResult=$this->filtertags($filter,$ReturnResult);



        return json_encode($FinalResult);
    }

    //return Restaurant and cuisine together
    public function RestaurantAndcuisine(){
        $CuisineClass=new Cuisine($this->DataBaseCon);
        $RestartuantClass=new Restartuant($this->DataBaseCon);
        //get Cuisine and its SecondLevel
        $getCuisineWithSecondLevel=$CuisineClass->CuisineWithSeondLevel();
        $CuisineAndRestaurants=$RestartuantClass->RestartuantProcess($getCuisineWithSecondLevel);
        return json_encode($CuisineAndRestaurants);
    }

    private function foreachComparedTages($filter,$comaredValue){
        foreach ($filter as $key=>$value){
            if($value===$comaredValue){
                return $comaredValue;
            }
        }


    }


    private function filtertags($filter,$ReturnedArray){
        if(count($filter)>0){
            $newArray=[];
            foreach ($ReturnedArray as $key=>$subArray){
                foreach ($subArray as $finalKey=>$finalvalue){
                    if($finalvalue===$this->foreachComparedTages($filter,$finalvalue)){
                        array_push($newArray,$subArray);
                    }

                }
            }

            return $newArray;
        }
        else{
            return $ReturnedArray;
        }


    }



    //return limited record
    private function returnLimitedRecord($array,$startCount,$limit){
        $count=0;
        $NewArray=[];
        for ($startCount;$startCount<count($array);$startCount++){
            if($count!==$limit){
                array_push($NewArray,$array[$startCount]);
            }
            else{
                break;
            }
            $count++;
        }


        return $NewArray;

    }




}










?>