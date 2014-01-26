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
        if($stmt=$this->DataBaseCon->prepare("UPDATE Cometome_Option SET WebTitle=?, WebDescription=?, WebUrl=?, EMail=?, WebStatus=? ,WebPolicy=? WHERE OptionID=1")){
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
        if($stmt=$this->DataBaseCon->prepare("SELECT WebTitle,WebDescription,WebUrl,EMail,WebStatus,WebPolicy FROM Cometome_Option WHERE OptionID=1")){
            $stmt->execute();
            $stmt->bind_result($WebTitle,$WebDescription,$WebUrl,$EMail,$WebStatus,$WebPolicy);
            while($stmt->fetch()){
                $tmparray = array('WebTitle'=>$WebTitle,'WebDescription'=>$WebDescription,'WebUrl'=>$WebUrl,'EMail'=>$EMail,'WebStatus'=>$WebStatus,'WebPolicy'=>$WebPolicy);
            }
            $stmt->close();
            return $tmparray;

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


    //put tags into the selection option-------for cuisine
    public function OupPutTagBySelecOption($NameOfTags,$Table){
        $tmpArray=self::getTags($NameOfTags,$Table);
        echo "<select id='$NameOfTags' data-placeholder='Choose a your tags' class='chosen-select' multiple style='width:350px;' tabindex='4' class='span2 MyResttagslist'>";
        foreach ($tmpArray as $values){
            if($values!=''){
                echo "<option value='$values' id='$Table'>$values</option>";
            }
        }
        echo "</select>";
    }
    //put tags into the selection option-------for edit cuisine
    public function OutPutTagByEditSelectionOption($GetCurrentCuisinID,$NameOfTags,$Table){
        $selectedArray=[];
        $tmpArray=self::getTags($NameOfTags,$Table);
        $CuisineClass= new Cuisine($this->DataBaseCon);
        $getCusisneTagByResID=$CuisineClass->ReturnTagsOnly($GetCurrentCuisinID);
        foreach ($tmpArray as $values){
            foreach ($getCusisneTagByResID as $key=>$insdieArray){
                        if($key===$NameOfTags){
                            $selectedArray=$insdieArray;
                          }
                }
        }
        echo "<select id='$NameOfTags' data-placeholder='Choose a your tags' class='chosen-select' multiple style='width:350px;' tabindex='4' class='span2 MyResttagslist'>";

        foreach($tmpArray as $value){
            if(in_array($value,$selectedArray)){
                echo "<option value='$value' selected='selected' >$value</option>";

            }else{
                echo "<option value='$value'>$value</option>";

            }
        }


        echo "</select>";
    }

    //put the tags into the selct option-------for Restaruant
    public function MyRestaruantOupPutTagBySelecOption($RestaurantID,$NameOfTags,$Table){
        $selectedArray=[];
        $tmpArray=self::getTags($NameOfTags,$Table);
        $RestartuantClass=new Restartuant($this->DataBaseCon);
        $GetRestaruantTags=$RestartuantClass->ReturnResTagsOnly($RestaurantID);
        foreach ($tmpArray as $values){
            foreach ($GetRestaruantTags as $key=>$insdieArray){
                if($key===$NameOfTags){
                    $selectedArray=$insdieArray;
                }
            }
        }
        echo "<select id='MyRestaruant-$NameOfTags' data-placeholder='Choose tags' class='chosen-select' multiple style='width:100%;' tabindex='4' class='span2 MyResttagslist'>";
        foreach($tmpArray as $value){
            if(in_array($value,$selectedArray)){
                echo "<option value='$value' selected='selected' >$value</option>";

            }else{
                echo "<option value='$value'>$value</option>";

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


    /**
     *
     * according to id then reutrn the relative name
     * @param $RootID
     * @param $SubID
     *
     * @return null
     */
    public function ReturnNameAccordingID($RootID,$SubID){
        $returnValue = null;
        if($SubID===null){
            if($stmt=$this->DataBaseCon->prepare("SELECT LevelOne FROM Location WHERE LevelOneID=?")){
                $stmt->bind_param('s',$RootID);
                $stmt->execute();
                $stmt->bind_result($LevelOne);
                while($stmt->fetch()){
                    $returnValue=$LevelOne;
                }
                $stmt->close();
                return $returnValue;
            }
        }
        else{
            if($stmt=$this->DataBaseCon->prepare("SELECT LevelTwo FROM SubLocation WHERE LevelOneID=? AND LevelTwoID=?")){
                $stmt->bind_param('ss',$RootID,$SubID);
                $stmt->execute();
                $stmt->bind_result($LevelTwo);
                while($stmt->fetch()){
                    $returnValue=$LevelTwo;
                }
                $stmt->close();
                return $returnValue;
            }
        }

    }



    public function GetRootLocationWithIDAskey(){
        if($stmt=$this->DataBaseCon->prepare("SELECT LevelOneID,LevelOne FROM Location")){
            $stmt->execute();
            $stmt->bind_result($LevelOneID,$LevelOne);
            while($stmt->fetch()){
                $array[]=array($LevelOneID => $LevelOne);
            }
            $stmt->close();
            return $array;
        }
    }


    public function GetRootLocationOnly(){

        if($stmt=$this->DataBaseCon->prepare("SELECT LevelOneID,LevelOnePic,LevelOne FROM Location")){
            $stmt->execute();
            $stmt->bind_result($LevelOneID,$LevelOnePic,$LevelOne);
            while($stmt->fetch()){
                $array[]=array('LevelOneID'=>$LevelOneID,'LevelOnePic'=>$LevelOnePic,'LevelOne'=>$LevelOne);
            }
            $stmt->close();
            return $array;
        }
    }

    public function PushValueCompared($getRootLocation,$getRootLocationID){

        if($stmt=$this->DataBaseCon->prepare("SELECT LevelOne FROM Location WHERE LevelOne=? AND LevelOneID=?")){
            $stmt->bind_param('ss',$getRootLocation,$getRootLocationID);
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

    private function comparedSubLocation($RootID){
        if($stmt=$this->DataBaseCon->prepare("SELECT LevelOneID FROM SubLocation WHERE LevelOneID=?")){
            $stmt->bind_param('s',$RootID);
            $stmt->bind_result($RootID);
            $stmt->execute();
            while($stmt->fetch()){
               $arry[]=array('LevelOneID'=>$LevelOneID);
            }
            $stmt->close();
            if(count($arry)>0){
                return true;
            }
            else{
                return false;
            }

        }
    }

    /**
     * @param $getRootLocationID
     * @param $getRootLocation
     * @param $getRootLocationPic
     *
     * @return bool
     */
    public function InsertNewRootRecord($getRootLocationID,$getRootLocation,$getRootLocationPic){
        if($stmt=$this->DataBaseCon->prepare("INSERT INTO Location (LevelOneID,LevelOne,LevelOnePic) VALUE (?,?,?)")){
            $stmt->bind_param('sss',$getRootLocationID,$getRootLocation,$getRootLocationPic);
            $stmt->execute();
            $stmt->close();
            return true;
        }

    }

    /**
     * @param $getRootLocationID
     * @param $getSubLocationArray
     */
    private function CheckSubLocationReplated($getRootLocationID,$getSubLocationArray){
        foreach ($getSubLocationArray as $key => $value){
            if($stmt=$this->DataBaseCon->prepare("SELECT LevelOneID,LevelTwoID,LevelTwo FROM SubLocation WHERE LevelOneID=? AND LevelTwoID=? AND LevelTwo=?")){
                $stmt->bind_param('sss',$getRootLocationID,$key,$value);
                $stmt->bind_result($LevelOneID,$LevelTwoID,$LevelTwo);
                $stmt->execute();
                while($stmt->fetch()){
                   $temp[] = array("LevelOneID"=>$LevelOneID,"LevelTwoID"=>$LevelTwoID,"LevelTwo"=>$LevelTwo);

                }
                $stmt->close();
            }
        }
        if(count($temp)>0){
            return false;
        }
        else{
            return true;
        }

    }


    /**
     * @param $getRootLocationID
     * @param $getSubLocationArray
     *
     * @return bool
     */
    public function InsertNewSubRecord($getRootLocationID,$getSubLocationArray){
        if($this -> CheckSubLocationReplated($getRootLocationID,$getSubLocationArray)){
        $Condition = false;
        foreach ($getSubLocationArray as $key => $value){
        if($stmt=$this->DataBaseCon->prepare("INSERT INTO SubLocation (LevelOneID,LevelTwoID,LevelTwo) VALUE (?,?,?)")){
            $stmt->bind_param('sss',$getRootLocationID,$key,$value);
            $stmt->execute();
            $stmt->close();
            $Condition = true;
        }
            if (!$Condition){return false;}
        }
        return true;
        }
        else{
        return false;

        }



    }

    public function GetAddLocation($getRootLocationID,$getRootLocation,$getRootLocationPic,$getSubLocationArray){//check whether has same value that is in the database
        if( self::PushValueCompared($getRootLocation,$getRootLocationID)==="existed"){
            return "repeated";
        }

        elseif($this -> InsertNewRootRecord($getRootLocationID,$getRootLocation,$getRootLocationPic) && $this -> InsertNewSubRecord($getRootLocationID,$getSubLocationArray)){
            return "Successed";
        }
        else{
            return "Error";
        }
    }


    public function GetLocationNoParma(){//This function only return the array without Condition

        if($stmt=$this->DataBaseCon->prepare("SELECT Location.LevelOneID, Location.LevelOnePic, Location.LevelOne,SubLocation.LevelTwoID,SubLocation.LevelTwo FROM Location LEFT JOIN SubLocation ON Location.LevelOneID = SubLocation.LevelOneID")){
            $stmt->execute();
            $stmt->bind_result($LevelOneID,$LevelOnePic, $LevelOne, $LevelTwoID, $LevelTwo);
            $TemLocationArray=array();
            while($stmt->fetch()){
                $TemLocationArray[]=array('LevelOnePic'=>$LevelOnePic,'LevelOneID'=>$LevelOneID,'LevelOne'=>$LevelOne,'LevelTwoID'=>$LevelTwoID,'LevelTwo'=>$LevelTwo);
            }


            $stmt->close();
            return $TemLocationArray;

        }
    }

    public function GetLocationWithParma($getID){
        if($stmt=$this->DataBaseCon->prepare("SELECT LevelTwoID,LevelTwo FROM SubLocation WHERE LevelOneID=?")){
            $stmt->bind_param('s',$getID);
            $stmt->execute();
            $stmt->bind_result($LevelTwoID, $LevelTwo);
            $TemLocationArray=array();
            while($stmt->fetch()){
                $TemLocationArray[]=array('LevelTwoID'=>$LevelTwoID, 'LevelTwo'=>$LevelTwo);

            }

            $stmt->close();
            return $TemLocationArray;

        }

    }


    private function DeleteRootLocation($RootLocationID){
        if($stmt=$this->DataBaseCon->prepare("DELETE FROM Location WHERE LevelOneID=?")){
            $stmt->bind_param('s',$RootLocationID);
            $stmt->execute();
            $stmt->close();
            return true;
        }
        else{
            return false;
        }
    }

    private function DeleteSubLocation($getRootLocationID,$getSubLocationID){
        if($stmt=$this->DataBaseCon->prepare("DELETE FROM SubLocation WHERE LevelOneID=? AND LevelTwoID=?")){
            $stmt->bind_param('ss',$getRootLocationID,$getSubLocationID);
            $stmt->execute();
            $stmt->close();
            return true;
        }
        else{
            return false;
        }
    }

    /**
     * @param $getRootLocationID
     * @param $getSubLocationID
     *
     * @return string
     */
    public function getIDToDelete($getRootLocationID,$getSubLocationID){//according to LocationID then delete the record from the database: return the status that is including: success or error
    if($this -> comparedSubLocation($getRootLocationID)){
        if($this-> DeleteSubLocation($getRootLocationID,$getSubLocationID)){
          if(!$this -> comparedSubLocation($getRootLocationID)){
              if($this-> DeleteRootLocation($getRootLocationID)){
                  return "Deleted successfully";
              }
          }
            else{
            return "Deleted successfully";
            }
        }
        else{
            return "Deleted error";

        }
    }
     else{
         if($this-> DeleteSubLocation($getRootLocationID,$getSubLocationID) && $this-> DeleteRootLocation($getRootLocationID)){
             return "Deleted successfully";
         }
         else{
             return "Deleted error";

         }

        }


    }

    public function pushModifyLocation($GetModifyLocationRootLocation,$GetModifyLocationSubLocation,$GetModifyLocationID){

        if($stmt=$this->DataBaseCon->prepare("UPDATE Location SET LevelOne=?, LevelTwo=? WHERE LocationID=?")){
            $stmt->bind_param('ssi',$GetModifyLocationRootLocation,$GetModifyLocationSubLocation,$GetModifyLocationID);
            $stmt->execute();
            $stmt->close();
            return "Modified successfully";
        }
        else {

            return "Modified error";

        }


    }

    public function GenerateFinalRootLocationWithID(){
        $newarray = array();
        $array = $this -> GetLocationNoParma();

    }

    private function GenerateFinalrootLocation(){
       $newarray = array();
       $array = $this -> GetLocationNoParma();
       foreach($array as $key => $subarray){
           foreach($subarray as $subkey => $value){
               if($subkey === 'LevelOne'){
                   array_push($newarray,$value);
               }
           }
       }
       return array_unique($newarray);
    }

    public function GetRootLocationBySelectOption(){

        echo "<select id='MyRestartuant' class='span4 MyResRootAddress'>";
        foreach ($this -> GenerateFinalrootLocation() as $key=>$subArray){
                echo "<option value='$subArray'>$subArray</option>";

        }
        echo "</select>";
    }




    public function CmsDisplay(){//only display the result at cms index page
        echo '<table  class="table table-striped">';
        echo  '<thead>';
        echo '<tr class="thead">';
        echo '<td><h6>Root Location photo</h6></td>';
        echo '<td><h6>Root Location ID</h6></td>';
        echo '<td><h6>Root Location Name</h6></td>';
        echo '<td><h6>Sub Location ID</h6></td>';
        echo '<td><h6>Sub Location Name</h6></td>';
        echo '<td><h6>Delete</h6></td>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        foreach($this -> GetLocationNoParma() as $Rootkey => $Subvalue){
            echo '<tr>';

            foreach ($Subvalue as $key => $value){

                if ($key==='LevelOnePic'){

                    echo "<td><img src='$value' style='width:120px;height:70px;'></td>";

                }

                else if($key==="LevelOneID"){
                    echo '<td>';
                    echo "<p class='GetLevelOneID'>$value</p>";
                    echo '</td>';
                }
                else if($key==="LevelOne"){
                    echo '<td>';
                    echo "<p>$value</p>";
                    echo '</td>';
                }

                else if($key==="LevelTwoID"){
                        echo "<td><p class='GetLevelTwoID'>$value</p></td>";
                }
                else if($key==="LevelTwo"){
                        echo "<td>$value</td>";

                }
            }

            echo "<td><button class='button delete' type='button'>Delete</button></td>";
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
        if($stmt=$this->DataBaseCon->prepare("UPDATE User SET UserStatus=? WHERE UserID=?")){
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
        if($stmt=$this->DataBaseCon->prepare("UPDATE User SET UserName=?, UserPassWord=?, UserPhone=?,UserPhotoPath=?,UserMail=? WHERE UserID=? AND UserType=?")){
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
            if($stmt=$this->DataBaseCon->prepare("DELETE FROM User WHERE UserID = ?")){
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
                    echo "<td><img src=$value class='img-circle' style='margin-top:7px;width:30px;height:30px'></td>";
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
        if($stmt=$this->DataBaseCon->prepare("SELECT UserID, UserName, UserPhone, UserPhotoPath, UserMail, UserPoints, UserADPosition, UserType, UserStatus FROM User")){
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
        if($stmt=$this->DataBaseCon->prepare("SELECT UserID, UserName, UserFirstName, UserLastName,UserPassWord, UserPhone, UserPhotoPath, UserMail,UserAddress, UserPoints, UserADPosition, UserType, UserStatus FROM User WHERE UserID=?")){
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
        if($stmt=$this->DataBaseCon->prepare("SELECT UserID, UserName, UserPhone, UserPhotoPath, UserMail, UserPoints, UserADPosition, UserType, UserStatus FROM User WHERE UserMail=?")){
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
        if($stmt=$this->DataBaseCon->prepare("SELECT UserID, UserName, UserPassWord, UserPhone, UserPhotoPath, UserMail FROM User WHERE UserType=?")){
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
        if($stmt=$this->DataBaseCon->prepare("SELECT UserID, UserName, UserPassWord, UserPhone, UserPhotoPath, UserMail, UserType FROM User WHERE UserMail=? AND UserPassWord=?")){
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
        if($stmt=$this->DataBaseCon->prepare("SELECT User.UserID, User.UserName, User.UserPassWord, User.UserPhone, User.UserPhotoPath, User.UserMail, User.UserType, Restaurants.RestID, Restaurants.ResPicPath, Restaurants.ResName FROM User LEFT JOIN Restaurants ON User.UserID=Restaurants.UserID WHERE Restaurants.UserID=?")){
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
        if($stmt=$this->DataBaseCon->prepare("UPDATE User SET UserName=?, UserFirstName=?,UserLastName=?,UserPhone=?,UserMail=?, UserAddress=? WHERE UserID=?")){
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
            if($stmt=$this->DataBaseCon->prepare("UPDATE User SET UserPassWord=? WHERE UserID=?")){
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
        if($stmt=$this->DataBaseCon->prepare("UPDATE User SET UserPhotoPath=? WHERE UserID=?")){
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


    /**
     * This will return user info according to usermail and encrypedPassword
     */

    public function ReturnValiationNormalUser($GetEmail,$GetEncryedPassword){
        if($stmt=$this->DataBaseCon->prepare("SELECT UserID, UserName, UserFirstName, UserLastName,  UserPhone, UserPhotoPath, UserMail, UserType FROM User WHERE UserMail=? AND UserPassWord=?")){
            $stmt->bind_param('ss',$GetEmail,$GetEncryedPassword);
            $stmt->execute();
            $stmt->bind_result($UserID,$UserName,$UserFirstName,$UserLastName,$UserPhone,$UserPhotoPath,$UserMail,$UserType);
            while($stmt->fetch()){
                $tmp[]=array('UserID' => $UserID, 'UserName' => $UserName, 'UserFirstName' => $UserFirstName, 'UserLastName' =>$UserLastName, 'UserPhone' => $UserPhone, 'UserPhotoPath' => $UserPhotoPath, 'UserMail' => $UserMail, 'UserType' => $UserType, 'Authorization' => 'success');
            }
            $stmt->close();

            return $tmp;

        }
    }

    /**
     * Return facebook info only
     * @param $FacebookID
     * @param $UserType
     *
     * @return array
     */
    public function ReturnFaceookinfoOnly($FacebookID, $UserType){
        if($stmt=$this->DataBaseCon->prepare("SELECT UserID, UserName, UserFirstName, UserLastName,  UserPhone, UserPhotoPath, UserMail, UserType FROM User WHERE UserID=? AND UserType=?")){
            $stmt->bind_param('ss',$FacebookID,$UserType);
            $stmt->execute();
            $stmt->bind_result($UserID,$UserName,$UserFirstName,$UserLastName,$UserPhone,$UserPhotoPath,$UserMail,$UserType);
            while($stmt->fetch()){
                $tmp[]=array('UserID' => $UserID, 'UserName' => $UserName, 'UserFirstName' => $UserFirstName, 'UserLastName' =>$UserLastName, 'UserPhone' => $UserPhone, 'UserPhotoPath' => $UserPhotoPath, 'UserMail' => $UserMail, 'UserType' => $UserType, 'Authorization' => 'success');
            }
            $stmt->close();

            return $tmp;

        }
    }


    /**
     * this function is for json validation
     * @param $GetEmail
     * @param $GetEncryedPassword
     *
     * @return array
     */
//Validation user and password then return the info
    public function ReturnValiationOfUserPass($GetEmail,$GetEncryedPassword,$facebookid,$GetType){
        //return normal user and resturant
        if(isset($GetEmail) && isset($GetEncryedPassword)){
            return $this -> ReturnValiationNormalUser($GetEmail,$GetEncryedPassword);
        }
        //return user of facebook info only
        if(isset($facebookid) && isset($GetType)){
            return $this -> ReturnFaceookinfoOnly($facebookid,$GetType);
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
            if($stmt=$this->DataBaseCon->prepare("INSERT INTO UserAddressBook (UserID, AddreNickName,AddrePhone,AddresAddress,AddreStatus) VALUES (?,?,?,?,?)")){
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
        if ($stmt=$this->DataBaseCon->prepare("SELECT UserID,AddreNickName,AddrePhone,AddresAddress FROM UserAddressBook WHERE UserID=? AND AddreNickName=? AND AddrePhone=? AND AddresAddress=?")){
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
        if ($stmt=$this->DataBaseCon->prepare("SELECT AddreStatus,AddressBookID,UserID,AddreNickName,AddrePhone,AddresAddress FROM UserAddressBook WHERE UserID=?")){
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
        if ($stmt=$this->DataBaseCon->prepare("SELECT AddreStatus,AddressBookID,UserID,AddreNickName,AddrePhone,AddresAddress FROM UserAddressBook WHERE UserID=? AND AddreStatus=?")){
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
        if($stmt=$this->DataBaseCon->prepare("DELETE FROM UserAddressBook WHERE AddressBookID=?")){
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
            if($stmt=$this->DataBaseCon->prepare("UPDATE UserAddressBook SET AddreStatus=? WHERE AddressBookID=? AND UserID=?")){
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
        if($stmt=$this->DataBaseCon->prepare("UPDATE UserAddressBook SET AddreStatus=? WHERE UserID=?")){
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




   /**
    * check and payment address function
    */
    public function PaymentSetDefaultAddress($GetUserID,$GetNickName,$GetPhone,$GetAddress,$DefaultStauts){
        $this->GetUserID=$GetUserID;
        $this->GetNickName=$GetNickName;
        $this->GetPhone=$GetPhone;
        $this->GetAddress=$GetAddress;
        return $this -> paymentAddressbook($DefaultStauts);
    }

    private function paymentAddressbook($DefaultStauts){
        if (self::CompareInfo()==='pass'){
            $this -> ResetPastDefault($this -> GetUserID);
            if($stmt=$this->DataBaseCon->prepare("INSERT INTO UserAddressBook (UserID, AddreNickName,AddrePhone,AddresAddress,AddreStatus) VALUES (?,?,?,?,?)")){
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
            //session_start();
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
        if($stmt=$this->DataBaseCon->prepare("DELETE FROM TempActiveCode WHERE TempActiveCode=?")){
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
        if($stmt=$this->DataBaseCon->prepare("INSERT INTO TempActiveCode (TempActiveCode) VALUE (?)")){
            $stmt->bind_param('s',$this->GenerateActiveCode);
            $stmt->execute();
            $stmt->close();
        }

    }
    private function selectTempActiveCode(){
        if($stmt=$this->DataBaseCon->prepare("SELECT TempActiveCode FROM TempActiveCode")){
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

        if($stmt=$this->DataBaseCon->prepare("SELECT UserMailActiveID, UserMailSender, UserMailConstructer, UserMailTitle FROM MailSetting WHERE UserMailActiveID=?")){
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
        if($stmt=$this->DataBaseCon->prepare("UPDATE MailSetting SET UserMailSender=?,UserMailConstructer=?,UserMailTitle=? WHERE UserMailActiveID=?")){
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
    private $ResturantRegisterPicPathPrefix=null;

    public function __construct($DataBaseCon){
        parent::__construct($DataBaseCon);
    }

    public function ResturantRegisation($ResturantRegisterID,$ResturantRegisterEmail,$ResturantRegisterPass,$ResturantRegisterStatus,$ResturantRegisterType,$ResturantRegisterPicPathPrefix){
        $this->ResturantRegisterID=$ResturantRegisterID;
        $this->ResturantRegisterEmail=$ResturantRegisterEmail;
        $this->ResturantRegisterPass=$ResturantRegisterPass;
        $this->ResturantRegisterStatus=$ResturantRegisterStatus;
        $this->ResturantRegisterType=$ResturantRegisterType;
        $this->ResturantRegisterPicPathPrefix=$ResturantRegisterPicPathPrefix;
        return self::MartchEmail($this->ResturantRegisterEmail);
    }
    private function MartchEmail($GetEmail){
        $RepatedMail=0;
        $getArray=json_decode(parent::SearchUser($GetEmail));
        foreach ($getArray as $key=>$subvalueArray){
            foreach($subvalueArray as $subKey=>$value){
                if($subKey==='UserMail'){
                    if($value===$GetEmail){
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
        if($stmt=$this->DataBaseCon->prepare("INSERT INTO User (UserID,UserMail,UserPassWord,UserStatus,UserType) VALUES (?,?,?,?,?)")){
            $stmt->bind_param('issis',$this->ResturantRegisterID,$this->ResturantRegisterEmail,md5(base64_encode($this->ResturantRegisterPass)),$this->ResturantRegisterStatus,$this->ResturantRegisterType);
            $stmt->execute();
            $stmt->close();
            $condition1=1;
        }

        if($stmt=$this->DataBaseCon->prepare("INSERT INTO Restaurants (UserID,RestID,ResAddedTime) VALUES (?,?,?)")){
            $ResID='R'.$this->ResturantRegisterID;
            $stmt->bind_param('iss',$this->ResturantRegisterID,$ResID, date("Y-m-d H:i:s"));
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
        $this->ResAvailabilityTag=serialize($ResAvailabilityTag);
        $this->ResCuisineTag=serialize($ResCuisineTag);
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
        if($stmt=$this->DataBaseCon->prepare("UPDATE User SET UserName=?, UserPhone=? WHERE UserID=?")){
            $stmt->bind_param('sii',$this->ResContactName,$this->ResContactPhone,$this->ResUID);
            $stmt->execute();
            $stmt->close();
            $Condition1=1;
        }
        if($stmt=$this->DataBaseCon->prepare("UPDATE Restaurants SET ResName=?, ResAddress=?, ResRootAddress=?, ResAvailability=?, ResCuisine=?, ResOpenTime=?,ResRating=?,ResReview=? WHERE RestID=?")){
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
        $condition1=false;
        $condition2=false;
        if($stmt=$this->DataBaseCon->prepare("UPDATE Restaurants SET ResPicPath=? WHERE RestID=? AND UserID=?")){
            $stmt->bind_param('ssi',$ResPhotoPath,$ResID,$UID);
            $stmt->execute();
            $stmt->close();
            $condition1 = true;
        }
        else {
            $condition1 = false;
        }

        //insert pic into user list
        if($stmt=$this->DataBaseCon->prepare("UPDATE User SET UserPhotoPath=? WHERE UserID=?")){
            $stmt->bind_param('si',$ResPhotoPath,$UID);
            $stmt->execute();
            $stmt->close();
            $condition2 = true;
        }
        else {
            $condition2 = false;
        }



        if($condition1 && $condition2){
            return 'Successed';
        }
        else{
            return 'Error';
        }


    }



//fetch the all keys and values from Restaruant table by sepcial parameter
    public function GetRestaruantWithParm($ResID){
        if($stmt=$this->DataBaseCon->prepare("SELECT * FROM Restaurants WHERE RestID=?")){
            $stmt->bind_param('s',$ResID);
            $stmt->execute();
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
        if($stmt=$this->DataBaseCon->prepare("SELECT ResName FROM Restaurants WHERE RestID=?")){
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
        if($stmt=$this->DataBaseCon->prepare("SELECT * FROM Restaurants")){
            $stmt->execute();
            //$stmt->bind_result();
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

    //fetch Restaruant filter
    public function FetchResFilter($loaction,$searchValue){
        $object=array();
            if($stmt=$this->DataBaseCon->prepare("SELECT RestID,ResName,ResOpenTime,ResAddress,ResRootAddress,ResPicPath,ResPicWidth,ResPicHeight,ResRating,ResAvailability,ResCuisine,ResReview,UserID FROM Restaurants WHERE ResName LIKE ? AND ResRootAddress=? AND ResReview=1")){
            $stmt->bind_param("ss",$param,$loaction);
            $param = "%{$searchValue}%";
            $stmt->execute();
            $stmt->bind_result($RestID,$ResName,$ResOpenTime,$ResAddress,$ResRootAddress,$ResPicPath,$ResPicWidth,$ResPicHeight,$ResRating,$ResAvailability,$ResCuisine,$ResReview,$UserID);
            $object=array();
            while($stmt->fetch()){
                $tmp=array("RestID"=>$RestID,"ResName"=>$ResName,"ResOpenTime"=>unserialize($ResOpenTime),"ResAddress"=>$ResAddress,"ResRootAddress"=>$ResRootAddress,"PicPath"=>$ResPicPath,"PicWidth"=>$ResPicWidth,"PicHeight"=>$ResPicHeight,"ResRating"=>$ResRating,"AvailabilityTags"=>unserialize($ResAvailability),"CuisineTags"=>unserialize($ResCuisine),"ResReview"=>$ResReview,"UserID"=>$UserID);
                array_push($object,$tmp);
            }
            $stmt->close();
            return $object;
        }
    }


    //fetch restraruant with normall array
    public function FetchRestaruant(){
        $object=array();
        if($stmt=$this->DataBaseCon->prepare("SELECT RestID,ResName,ResOpenTime,ResAddress,ResRootAddress,ResPicPath,ResPicWidth,ResPicHeight,ResRating,ResAvailability,ResCuisine,ResReview,UserID FROM Restaurants WHERE ResReview=1")){
            $stmt->execute();
            $stmt->bind_result($RestID,$ResName,$ResOpenTime,$ResAddress,$ResRootAddress,$ResPicPath,$ResPicWidth,$ResPicHeight,$ResRating,$ResAvailability,$ResCuisine,$ResReview,$UserID);
            $object=array();
            while($stmt->fetch()){
                $tmp=array("RestID"=>$RestID,"ResName"=>$ResName,"ResOpenTime"=>unserialize($ResOpenTime),"ResAddress"=>$ResAddress,"ResRootAddress"=>$ResRootAddress,"PicPath"=>$ResPicPath,"PicWidth"=>$ResPicWidth,"PicHeight"=>$ResPicHeight,"ResRating"=>$ResRating,"AvailabilityTags"=>unserialize($ResAvailability),"CuisineTags"=>unserialize($ResCuisine),"ResReview"=>$ResReview,"UserID"=>$UserID);
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


    public function ReturnResNameOfCuisine($GetCuisineArray){
        foreach ($GetCuisineArray as $RootKey=>$subArray){
            foreach ($subArray as $key=>$value){
                if($key==='CuisineRestID'){
                    if(count($this->FetchRestaruantName($value))>0){
                        $GetCuisineArray[$RootKey]=array_merge($GetCuisineArray[$RootKey],$this->FetchRestaruantName($value));
                    }
                }
            }
        }
        return $GetCuisineArray;
    }


    //return restaurant that contains location
    public function ReturnResLocation($locationName){
        if($stmt=$this->DataBaseCon->prepare("SELECT RestID,ResName,ResOpenTime,ResAddress,ResRootAddress,ResPicPath,ResPicWidth,ResPicHeight,ResRating,ResAvailability,ResCuisine,ResReview,ResAddedTime FROM Restaurants WHERE ResRootAddress=? AND ResReview=?")){
            $object=array();
            $Rereview=1;
            $stmt->bind_param('si',$locationName,$Rereview);
            $stmt->execute();
            $stmt->bind_result($RestID,$ResName,$ResOpenTime,$ResAddress,$ResRootAddress,$ResPicPath,$ResPicWidth,$ResPicHeight,$ResRating,$ResAvailability,$ResCuisine,$ResReview,$ResAddedTime);
            while($stmt->fetch()){
                $tmp=array("RestID"=>$RestID,"ResName"=>$ResName,"ResOpenTime"=>unserialize($ResOpenTime),"ResDetailAddress"=>$ResAddress,"ResRootAddress"=>$ResRootAddress,"PicPath"=>$ResPicPath,"PicWidth"=>$ResPicWidth,"PicHeight"=>$ResPicHeight,"ResRating"=>$ResRating,"AvailabilityTags"=>unserialize($ResAvailability),"CuisineTags"=>unserialize($ResCuisine),"ResReview"=>$ResReview, "ResAddedTime"=>$ResAddedTime);
                array_push($object,$tmp);
            }
            $stmt->close();
            return $object;
        }

    }

    //reutrn restaurant tags
    public function ReturnResTagsOnly($GetResID){
        if($stmt=$this->DataBaseCon->prepare("SELECT ResAvailability,ResCuisine FROM Restaurants WHERE RestID=?")){
            $stmt->bind_param('s',$GetResID);
            $stmt->execute();
            $stmt->bind_result($ResAvailability,$ResCuisine);
            while($stmt->fetch()){
                $tempArray= array('Availability'=>unserialize($ResAvailability),'Cuisine'=>unserialize($ResCuisine));
            }
            $stmt->close();
            return $tempArray;
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
        $this->CurrentCuisineName=strtolower($CurrentCuisineName);
        $this->CurrentCuisineDes=strtolower($CurrentCuisineDes);
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
    public function CuisinePhotoUploadingAndUpdating($CurrentCuid,$PicPath,$DeleteOldPhotoPath,$CuisinePicWidth,$CuisinePicHeight){
        if($stmt=$this->DataBaseCon->prepare("UPDATE Cuisine SET CuPicPath=?, CuPicWidth=?, CuPicHeight=? WHERE CuID=?")){
            $stmt->bind_param('siis',$PicPath,$CuisinePicWidth,$CuisinePicHeight,$CurrentCuid);
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
        if($stmt=$this->DataBaseCon->prepare("SELECT * FROM Cuisine WHERE CuOrder=? AND RestID=?")){
            $stmt->bind_param('is',$GetOrder,$ResID);
            $stmt->execute();
            //$stmt->bind_result();
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
        if($stmt=$this->DataBaseCon->prepare("INSERT INTO Cuisine (CuID,CuName,CuDescr,Availability,CuAvailability,CuCuisine,CuType, CuPrice, RestID, CuReview,CuOrder,Price,CuRating,CuAddedTime) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)")){
            $CuReview=0;
            $CuRating=0;
            $stmt->bind_param('sssssssssiidis',$this->CurrentCusineID,$this->CurrentCuisineName,$this->CurrentCuisineDes,$this->CurrentCuisineAvali,serialize($this->CurrentAvaliTag),serialize($this->CurrentCusinTag),serialize($this->CurrentCusinTypeTag),serialize($this->CurrentCusinPriceTag),$this->CurrentResID,$CuReview,$this->CurrentCusinOrder,$this->CurrentCuisinePrice,$CuRating,date("Y-m-d H:i:s"));
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
            if($stmt=$this->DataBaseCon->prepare("INSERT INTO SecondLevelofCuisine (SeLevelTitle,SeLevelMultiple,CuID) VALUES (?,?,?)")){
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

                if($stmt=$this->DataBaseCon->prepare("UPDATE SecondLevelofCuisine SET SeLevelTitle=?, SeLevelMultiple=? WHERE SecLevelCuID=? AND CuID=?")){
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
                if($stmt=$this->DataBaseCon->prepare("INSERT INTO SecondLevelofCuisine (SeLevelTitle,SeLevelMultiple,CuID) VALUES (?,?,?)")){
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
        if($stmt=$this->DataBaseCon->prepare("SELECT * FROM SecondLevelofCuisine WHERE CuID=?")){
            $stmt->bind_param('s',$getCuid);
            $stmt->execute();
            //$stmt->bind_result();
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
        if($stmt=$this->DataBaseCon->prepare("SELECT * FROM SecondLevelofCuisine WHERE SecLevelCuID=?")){
            $stmt->bind_param('i',$getUniqeID);
            $stmt->execute();
            //$stmt->bind_result();
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
        if($stmt=$this->DataBaseCon->prepare("DELETE FROM SecondLevelofCuisine WHERE SecLevelCuID=?")){
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
        if($stmt=$this->DataBaseCon->prepare("UPDATE SecondLevelofCuisine SET SeLevelMultiple=? WHERE SecLevelCuID=?")){
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
        if($stmt=$this->DataBaseCon->prepare("DELETE FROM Cuisine WHERE Cuisine.CuID=?")){
            $stmt->bind_param('s',$GetDeleteID);
            $stmt->execute();
            $stmt->close();
            $condition1=1;
        }
        else{
            return 'Error';
        }

        if($stmt=$this->DataBaseCon->prepare("DELETE FROM SecondLevelofCuisine WHERE SecondLevelofCuisine.CuID=?")){
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
        if($stmt=$this->DataBaseCon->prepare("UPDATE Cuisine SET CuName=?,CuDescr=?, Price=?, Availability=?, CuAvailability=?, CuCuisine=?, CuType=?, CuPrice=? WHERE CuID=?")){
            $stmt->bind_param('ssdssssss',strtolower($UpCurrentCuisineName),strtolower($UpCurrentCuisineDes),$UpCurrentCuisinePrice,$UpCurrentCuisineAvali,serialize($CurrentAvaliTag),serialize($CurrentCusinTag),serialize($CurrentCusinTypeTag),serialize($CurrentCusinPriceTag),$UpCurrentCusineID);
            $stmt->execute();
            $stmt->close();
            return 'Update successful';
        }
        else{
            return 'Error';
        }
    }

    //accoding to cuisine id return cuisine stuff
    public function ReturnCuisinestuff($cuisineID){
       $tmp=[];
        if($stmt=$this->DataBaseCon->prepare("SELECT CuID,CuName,CuDescr,CuPicPath,CuPicWidth,CuPicHeight,Availability,CuAvailability,CuCuisine,CuType,CuPrice,CuRating,CuReview,Price,CuAddedTime FROM Cuisine WHERE CuID=?")){
           $stmt->bind_param('s',$cuisineID);
           $stmt->execute();
           $stmt->bind_result($CuID,$CuName,$CuDescr,$CuPicPath,$CuPicWidth,$CuPicHeight,$Availability,$CuAvailability,$CuCuisine,$CuType,$CuPrice,$CuRating,$CuReview,$Price,$CuAddedTime);
            while($stmt->fetch()){
                $tmp=array('CuisineID'=>$CuID,'CuisineName'=>$CuName,'CuisineDescription'=>$CuDescr,'PicPath'=>$CuPicPath,'PicWidth'=>$CuPicWidth,'PicHeight'=>$CuPicHeight,'CuisineAvailability'=>$Availability,'CuisineAvailabilityTag'=>unserialize($CuAvailability),'CuisineCuisineTag'=>unserialize($CuCuisine),'CuisineTypeTag'=>unserialize($CuType),'CuisinePriceTag'=>unserialize($CuPrice),'CuisineRating'=>$CuRating,'CuisineReview'=>$CuReview,'CuisinePrice'=>$Price,'CuAddedTime'=>$CuAddedTime);
            }
           $stmt->close();

           $GetSecondLevel=$this->ReturnSecondLevelbyCuID($tmp['CuisineID']);
           $finalReturn=array_merge($tmp,$GetSecondLevel);
            return $finalReturn;
        }
    }


    //return normal dataset of cuisine
    private function ReturnDataOfNormalCuisine($getResID){
        if($stmt=$this->DataBaseCon->prepare("SELECT CuOrder,Availability,CuName,CuPicPath,CuDescr,Price,CuAvailability,CuCuisine,CuType,CuPrice,CuID,CuAddedTime FROM Cuisine WHERE RestID=? ORDER BY CuOrder")){
            $stmt->bind_param('s',$getResID);
            $stmt->execute();
            $stmt->bind_result($CuOrder,$Availability,$CuName,$CuPicPath,$CuDescr,$Price,$CuAvailability,$CuCuisine,$CuType,$CuPrice,$CuID,$CuAddedTime);
            $result = $stmt->get_result();
            $object=array();
            while($row=$result->fetch_assoc()){
                array_push($object,$row);
            }
            $stmt->close();
            return json_encode($object);
        }
    }

    /**
     * @param $getResID
     * @param $getSpecCuID
     *
     * @return array
     */

    public function ReturnCuisinewithResIDandReview($getResID,$getSpecCuID){
        $object=array();
        if($stmt=$this->DataBaseCon->prepare("SELECT CuID,CuName,CuDescr,CuPicPath,CuPicWidth,CuPicHeight,Availability,CuAvailability,CuCuisine,CuType,CuPrice,CuRating,RestID,CuOrder,Price,CuAddedTime FROM Cuisine WHERE RestID=? AND CuReview=1 AND CuID !=? ORDER BY CuOrder")){
            $stmt->bind_param('ss',$getResID,$getSpecCuID);
            $stmt->execute();
            $stmt->bind_result($CuID,$CuName,$CuDescr,$CuPicPath,$CuPicWidth,$CuPicHeight,$Availability,$CuAvailability,$CuCuisine,$CuType,$CuPrice,$CuRating,$RestID,$CuOrder,$Price,$CuAddedTime);
            while ($stmt->fetch()){
                $row = array("CuisineID"=>$CuID,"CuisineName"=>$CuName,"CuisineDescription"=>$CuDescr,"PicPath"=>$CuPicPath,'PicWidth'=>$CuPicWidth,'PicHeight'=>$CuPicHeight,"CuisineAvailability"=>$Availability,"AvailabilityTags"=>unserialize($CuAvailability),"CuisineTags"=>unserialize($CuCuisine),"TypeTags"=>unserialize($CuType),"PriceTags"=>unserialize($CuPrice),"CuisineRating"=>$CuRating,"CuisineRestID"=>$RestID,"CuisineOrder"=>$CuOrder,"CuisinePrice"=>$Price,"CuAddedTime"=>$CuAddedTime);
                array_push($object,$row);
            }
            $stmt->close();
            return $object;
        }
    }

    /**
     * @param $getResID
     *
     * @return array
     */
    public function ReturnCuisinewithReviewbyResID($getResID){
        $object=array();
        if($stmt=$this->DataBaseCon->prepare("SELECT CuID,CuName,CuDescr,CuPicPath,CuPicWidth,CuPicHeight,Availability,CuAvailability,CuCuisine,CuType,CuPrice,CuRating,RestID,CuOrder,Price,CuAddedTime FROM Cuisine WHERE RestID=? AND CuReview=1 ORDER BY CuOrder")){
            $stmt->bind_param('s',$getResID);
            $stmt->execute();
            $stmt->bind_result($CuID,$CuName,$CuDescr,$CuPicPath,$CuPicWidth,$CuPicHeight,$Availability,$CuAvailability,$CuCuisine,$CuType,$CuPrice,$CuRating,$RestID,$CuOrder,$Price,$CuAddedTime);
            while ($stmt->fetch()){
                $row = array("CuisineID"=>$CuID,"CuisineName"=>$CuName,"CuisineDescription"=>$CuDescr,"PicPath"=>$CuPicPath,'PicWidth'=>$CuPicWidth,'PicHeight'=>$CuPicHeight,"CuisineAvailability"=>$Availability,"AvailabilityTags"=>unserialize($CuAvailability),"CuisineTags"=>unserialize($CuCuisine),"TypeTags"=>unserialize($CuType),"PriceTags"=>unserialize($CuPrice),"CuisineRating"=>$CuRating,"CuisineRestID"=>$RestID,"CuisineOrder"=>$CuOrder,"CuisinePrice"=>$Price,"CuAddedTime"=>$CuAddedTime);
                array_push($object,$row);
            }
            $stmt->close();
            return $object;
        }
    }

    /**
     * @param $getCuID
     *
     * @return string
     */

    //return second dataset level of cuisine
    private function ReturnDataOfSecondCuisine($getCuID){
        if($stmt=$this->DataBaseCon->prepare("SELECT * FROM Cuisine LEFT JOIN SecondLevelofCuisine ON Cuisine.CuID=SecondLevelofCuisine.CuID WHERE SecondLevelofCuisine.CuID=?")){
            $stmt->bind_param('s',$getCuID);
            $stmt->execute();
            //$stmt->bind_result();
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
        if($stmt=$this->DataBaseCon->prepare("SELECT * FROM Cuisine WHERE CuID=?")){
            $stmt->bind_param('s',$GetCUID);
            $stmt->execute();
            //$stmt->bind_result();
            $result = $stmt->get_result();
            $object=array();
            while($row=$result->fetch_assoc()){
                array_push($object,$row);
            }
            $stmt->close();
            return json_encode($object);
        }
    }

    //return cuisine tags only

    public function ReturnTagsOnly($GetCuid){
        if($stmt=$this->DataBaseCon->prepare("SELECT CuAvailability,CuCuisine,CuType,CuPrice FROM Cuisine WHERE CuID=?")){
            $stmt->bind_param('s',$GetCuid);
            $stmt->execute();
            $stmt->bind_result($CuAvailability,$CuCuisine,$CuType,$CuPrice);
            while($stmt->fetch()){
                $tempArray= array('Availability'=>unserialize($CuAvailability),'Cuisine'=>unserialize($CuCuisine),'Type'=>unserialize($CuType),'Price'=>unserialize($CuPrice));
            }
            $stmt->close();
            return $tempArray;
        }
    }


    //reset and update order of cuisine
    public function RestAndUpdateOrderofCuisine($getArrayOfNewOrder){
        $error=0;
        foreach($getArrayOfNewOrder as $key=>$value){
            if($stmt=$this->DataBaseCon->prepare("UPDATE Cuisine SET CuOrder=? WHERE CuID=?")){
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
        if($stmt=$this->DataBaseCon->prepare("SELECT SeLevelTitle, SeLevelMultiple FROM SecondLevelofCuisine WHERE CuID=?")){
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


    //return cuisine by like query
    public function ReturnAllCuisineByLikeQuery($GetSearchLoaction,$serachValue){
        $tmp=array();
        $param = "%{$serachValue}%";
        if($stmt=$this->DataBaseCon->prepare("SELECT Cuisine.CuID,Cuisine.CuName,Cuisine.CuDescr,Cuisine.CuPicPath,Cuisine.CuPicWidth,Cuisine.CuPicHeight,Cuisine.Availability,Cuisine.CuAvailability,Cuisine.CuCuisine,Cuisine.CuType,Cuisine.CuPrice,Cuisine.CuRating,Cuisine.RestID,Cuisine.CuOrder,Cuisine.Price,Cuisine.CuAddedTime FROM Restaurants LEFT JOIN Cuisine ON Restaurants.RestID = Cuisine.RestID WHERE Restaurants.ResRootAddress=? AND Cuisine.CuName LIKE ? AND Restaurants.ResReview=1 AND Cuisine.CuReview=1")){
            $stmt->bind_param('ss',$GetSearchLoaction,$param);
            $stmt->execute();
            $stmt->bind_result($CuID,$CuName,$CuDescr,$CuPicPath,$CuPicWidth,$CuPicHeight,$Availability,$CuAvailability,$CuCuisine,$CuType,$CuPrice,$CuRating,$RestID,$CuOrder,$Price,$CuAddedTime);
            while($stmt->fetch()){
                $object=array("CuisineID"=>$CuID,"CuisineName"=>$CuName,"CuisineDescription"=>$CuDescr,"PicPath"=>$CuPicPath,"PicWidth"=>$CuPicWidth,"PicHeight"=>$CuPicHeight,"CuisineAvailability"=>$Availability,"AvailabilityTags"=>unserialize($CuAvailability),"CuisineTags"=>unserialize($CuCuisine),"TypeTags"=>unserialize($CuType),"PriceTags"=>unserialize($CuPrice),"CuisineRating"=>$CuRating,"CuisineRestID"=>$RestID,"CuisineOrder"=>$CuOrder,"CuisinePrice"=>$Price, "CuAddedTime"=>$CuAddedTime);
                array_multisort($object);
                array_push($tmp,$object);
            }
            $stmt->close();
            return $tmp;
        }
    }

    //return all cuisine
    private function ReturnAllCuisine(){
        $tmp=array();

        if($stmt=$this->DataBaseCon->prepare("SELECT CuID,CuName,CuDescr,CuPicPath,CuPicWidth,CuPicHeight,Availability,CuAvailability,CuCuisine,CuType,CuPrice,CuRating,RestID,CuOrder,Price,CuAddedTime FROM Cuisine WHERE CuReview=?")){
            $condition=1;
            $stmt->bind_param('i',$condition);
            $stmt->execute();
            $stmt->bind_result($CuID,$CuName,$CuDescr,$CuPicPath,$CuPicWidth,$CuPicHeight,$Availability,$CuAvailability,$CuCuisine,$CuType,$CuPrice,$CuRating,$RestID,$CuOrder,$Price,$CuAddedTime);
            while($stmt->fetch()){
                $object=array("CuisineID"=>$CuID,"CuisineName"=>$CuName,"CuisineDescription"=>$CuDescr,"PicPath"=>$CuPicPath,"PicWidth"=>$CuPicWidth,"PicHeight"=>$CuPicHeight,"CuisineAvailability"=>$Availability,"AvailabilityTags"=>unserialize($CuAvailability),"CuisineTags"=>unserialize($CuCuisine),"TypeTags"=>unserialize($CuType),"PriceTags"=>unserialize($CuPrice),"CuisineRating"=>$CuRating,"CuisineRestID"=>$RestID,"CuisineOrder"=>$CuOrder,"CuisinePrice"=>$Price, "CuAddedTime"=>$CuAddedTime);
                array_multisort($object);
                array_push($tmp,$object);
            }
            $stmt->close();
            return $tmp;
        }
    }


    public function ReturnfinalCuisine($allCuisine){
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

    //Filter cuisine only according to Restaruant
    public function ReturnCuisineOnlyAccordingToRes($ResArray){
        $tmp=array();//set up temp array containter to store the cuisine
        $getAllCuisine=$this->CuisineWithSeondLevel();
        foreach ($ResArray as $key=>$subArray){
            foreach($subArray as $SubKey=>$SubValue){
                if($SubKey==='RestID'){
                    if(count($this->ReturnFindCuisine($SubValue,$getAllCuisine))>0){
                        foreach ($this->ReturnFindCuisine($SubValue,$getAllCuisine) as $insideKey=>$insidevalue){
                            array_push($tmp,$insidevalue);
                        }
                    }

                }
            }


        }
        sort($tmp);
        return $tmp;
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



    //filter promotion
    private function FilterPromotion($CuID){
        if($stmt = $this -> DataBaseCon -> prepare ("SELECT * FROM Featured WHERE FeaturedID=?")){
            $stmt->bind_param('s',$CuID);
            $stmt->execute();
            $result = $stmt->get_result();
            $object=array();
            while($row=$result->fetch_assoc()){
                array_push($object,$row);
            }
            $stmt->close();
            if(count($object)>0){
                return false;
            }
            else{
                return true;
            }
        }
    }



    //list cuisine into table
    public function listCuisineTable($getResid){
        $GetNormalDataset=json_decode(self::ReturnDataOfNormalCuisine($getResid));
        echo '<table class="table table-striped" id="CusinesTable">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>Order</th>';
        echo '<th>Availability</th>';
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
                if($key==='Availability'){
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
                    echo "<td><div class='btn-group dropup'><button class='btn TableButtonStyle ShowTags dropdown-toggle' data-toggle='dropdown' id='$value' type='button'>Show Tags</button><button class='btn TableButtonStyle dropdown-toggle' data-toggle='dropdown'><span class='caret'></span></button><ul class='dropdown-menu'>";
                    foreach (self::ReturnTagsOnly($value) as $TagKeys=>$Tagvalue){
                        echo "<li><a tabindex='-1'>$TagKeys:";

                        foreach($Tagvalue as $insideKey=>$uniqueKey){
                            if (isset($uniqueKey)){
                            echo ' "'.$uniqueKey.'" ';
                            }
                        }
                        echo "</a></li>";
                    }
                    echo '</ul></td>';

                    if(count(json_decode(self::ReturnDataOfSecondCuisine($value)))>0){
                        echo "<td><div class='btn-group dropup'><button class='btn TableButtonStyle dropdown-toggle' data-toggle='dropdown'>Edit&Show</button>  <button class='btn TableButtonStyle dropdown-toggle' data-toggle='dropdown'><span class='caret'></span></button><ul class='dropdown-menu dropdown-menu-Cuisine-table'><li><a tabindex='-1' id='$value' class='EditSecondLevel'>Edits Second Level</a></li></ul></div>";
                    }
                    else{
                        echo "<td><button class='btn TableButtonStyle AddSecondLevel' id='$value' type='button'>Add Second Level</button></td>";
                    }
                    echo '<td>';
                    echo '<div class="form-inline">';
                    echo "<button class='button subbutton subAddNewBotton EditCusine' id='$value' type='button' >Edit</button> ";
                    echo "<button class='button text-right button-delete' id='$value' type='button'>Delete</button>";
                        if($this -> FilterPromotion($value)){
                        echo "  <i class='fa fa-plus addedtoPromotion'></i>";
                        }


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
        header('Content-type: image/jpeg');
        imagejpeg($dst_r,$finalSavePath,$jpeg_quality);
        //ratio img
        $imaginfoArray=getimagesize($finalSavePath);
        $OldImgWidth=$imaginfoArray[0];
        $OldImgHeight=$imaginfoArray[1];
        $NewHeight=$OldImgHeight/$OldImgWidth*223;
        $img_r = imagecreatefromjpeg($finalSavePath);
        $dst_r = ImageCreateTrueColor(223,$NewHeight);
        imagecopyresampled($dst_r,$img_r,0,0,0,0,223,$NewHeight,$OldImgWidth,$OldImgHeight);
        header('Content-type: image/jpeg');
        imagejpeg($dst_r,$finalSavePath,$jpeg_quality);

        //return path
        $ReturnFullPath=$returPath.$changedName;
        if($WaterMarkerStatus==='yes'){
            $waterMarker=new waterMarker($getpath);
            $waterMarker->waterInfo($changedName,'WaterMarker/WaterMarker.png',$WaterMarkerPositon,"WaterMarker",20);
            unlink($finalSavePath);
            return  json_encode(array('CuisinePicPath' => $returPath.'WaterMarker'.$changedName, 'CuisinePicWidth' => $OldImgWidth, 'CuisinePicHeight' => $NewHeight));
        }
        else if($WaterMarkerStatus==='no'){
            return json_encode(array('CuisinePicPath' => $ReturnFullPath, 'CuisinePicWidth' => $OldImgWidth, 'CuisinePicHeight' => $NewHeight));

        }



    }


}



/***********************************************Favourite********************************************************/
class favourite{
    private $DataBaseCon=null;
    public function __construct($DataBaseCon){
        $this->DataBaseCon=$DataBaseCon;
    }

    /**
     *
     * return favourite that current userID has
     * @param $UserID
     * @param $Status
     *
     * @return array
     */
    public function returnCuisineID($UserID,$Status){
        $result=[];
        if($stmt=$this->DataBaseCon->prepare("SELECT CuID FROM Userfavorite WHERE UserID=? AND FavoriteStatus=?")){
           $stmt->bind_param('si',$UserID,$Status);
           $stmt->execute();
           $stmt->bind_result($CuID);
           while ($stmt->fetch()){
               array_push($result,$CuID);
           }
           $stmt->close();
           return $result;

        }
    }

    /**
     * confrim current user and currnet Cuisine ID are exeisted
     * @param $userID
     * @param $CuisineID
     *
     * @return bool
     */
    private function ConfirmExesited($userID,$CuisineID){
        if($stmt=$this->DataBaseCon->prepare("SELECT * FROM Userfavorite WHERE UserID=? AND CuID=?")){
            $stmt->bind_param('ss',$userID,$CuisineID);
            $stmt->execute();
            //$stmt->bind_result();
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


    /**
     * get favoriteStatus
     */
    public function ConfirmExesitedByFavorite(){
        if($stmt=$this->DataBaseCon->prepare("SELECT UserID,CuID FROM Userfavorite WHERE FavoriteStatus=1")){
            $stmt->execute();
            $stmt->bind_result($UserID,$CuID);
            while($stmt -> fetch()){
                $object[] = array('UserID_CuID'=>$UserID.'_'.$CuID);
            }
            $stmt->close();
            if(count($object)>0){
            return json_encode($object);
            }
            else{
            return json_encode(array('UserID_CuID'=>'none'));
            }

        }
    }


    /**
     * @param $userID
     * @param $cuID
     */
    public function ConfirmFavorite($userID,$cuID){

        if($stmt=$this->DataBaseCon->prepare("SELECT * FROM Userfavorite WHERE UserID=? AND CuID=? AND FavoriteStatus=1")){
            $stmt->bind_param('ss',$userID,$cuID);
            $stmt->execute();
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

    /**
     *
     * added to favorite
     * @param $userID
     * @param $CuisineID
     * @param $FavoriteStatus
     *
     * @return string
     */

    public function addedtoFavorite($userID,$CuisineID,$FavoriteStatus){
        if($this->ConfirmExesited($userID,$CuisineID)){
            if($stmt=$this->DataBaseCon->prepare("UPDATE Userfavorite SET FavoriteStatus=? WHERE UserID=? AND CuID=?")){
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
            if($stmt=$this->DataBaseCon->prepare("INSERT INTO Userfavorite (UserID,CuID,FavoriteStatus) VALUES (?,?,?)")){
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


/*************************************** cuisine comment**********************************************/
class CuisineComemnt{
    private $DataBaseCon=null;
    public function __construct($DataBaseConnetcion){
        $this->DataBaseCon=$DataBaseConnetcion;
    }

    /**
     * Fetch the count of comments of current restaurant
     * @param $currentResID
     *
     * @return array
     */
    private function FecthResCountOfComment ($currentResID){
        if($stmt=$this->DataBaseCon->prepare("SELECT COUNT(*) AS TOTAL FROM RestaurantsComments WHERE RestID=? AND RescoReview=1")){
            $stmt->bind_param('s',$currentResID);
            $stmt->execute();
            $stmt->bind_result($TOTAL);
            while($stmt->fetch()){
                $tmp=array('TotalComments'=>$TOTAL);
            }
            $stmt->close();
            return $tmp;
        }
    }


    /**
     * Fetch count of commnets of current Cuisine
     * @param $currentCuID
     */
    private function FetchCuisineCountOfComment($currentCuID){
        if($stmt=$this->DataBaseCon->prepare("SELECT COUNT(*) AS TOTAL FROM CuisineComment WHERE CuID=? AND CucoReview=1")){
           $stmt->bind_param('s',$currentCuID);
           $stmt->execute();
           $stmt->bind_result($TOTAL);
           while($stmt->fetch()){
               $tmp=array('TotalComments'=>$TOTAL);
           }
           $stmt->close();
          return $tmp;
        }
    }

    /**
     *  Intergrate Comment with Restaurant
     * @param $GetResArray
     *
     * @return mixed
     */
    public function IntergrateCommentWithRestaruant($GetResArray){
        foreach ($GetResArray as $key => $subArray){
            foreach ($subArray as $subKey => $value){
                if($subKey === 'RestID'){
                    $GetResArray[$key] = array_merge($GetResArray[$key], $this -> FecthResCountOfComment($value));
                }
            }
        }
        return $GetResArray;

    }

    /**
     * Intergrate Comment with Cuisine
     * @param $GetCuisineArray
     */
    public function IntergrateCommentWithCuisine($GetCuisineArray){
        foreach ($GetCuisineArray as $key => $subArray){
            foreach ($subArray as $subKey => $value){
                if($subKey === 'CuisineID'){
                        $GetCuisineArray[$key] = array_merge($GetCuisineArray[$key], $this -> FetchCuisineCountOfComment($value));
                }
            }
        }
       return $GetCuisineArray;

    }

    /**
     * insert Cuisine comment param into database
     * @param $userID
     * @param $cuisineID
     * @param $cuisineCommentID
     * @param $Rating
     * @param $commentContent
     * @param $date
     * @param $like
     * @param $dislike
     * @param $review
     *
     * @return string
     */
    public function getCuisineCommentParam($userID,$cuisineID,$cuisineCommentID,$Rating,$commentContent,$like,$dislike,$review){
        if($stmt=$this->DataBaseCon->prepare("INSERT INTO CuisineComment (UserID,CuID,CuisineCommentID,CuisineComent,CuCommentDate,CuCommentRating,CuCommentLike,CuCommentDislike,CucoReview) VALUES (?,?,?,?,?,?,?,?,?)")){
            $stmt->bind_param('sssssiiii',$userID,$cuisineID,$cuisineCommentID,$commentContent,date("Y-m-d H:i:s"),$Rating,$like,$dislike,$review);
            $stmt->execute();
            $stmt->close();
            //session_start();
            $_SESSION['SetUpCuisineCommentTime'] = time();
            return 'true';
        }
        else {
            return 'false';
        }
    }

    /**
     * insert Restaurant comment into databse
     * @param $userID
     * @param $CurrentResID
     * @param $cuisineCommentID
     * @param $Rating
     * @param $commentContent
     * @param $like
     * @param $dislike
     * @param $review
     */

    public function getResCommentParam($userID,$CurrentResID,$cuisineCommentID,$Rating,$commentContent,$like,$dislike,$review){
        if($stmt=$this->DataBaseCon->prepare("INSERT INTO RestaurantsComments (UserID,RestID,ResCommentID,ResComment,ResCommentDate,ResCommentRating,ResCommentLike,ResCommentDislike,RescoReview) VALUES (?,?,?,?,?,?,?,?,?)")){
            $stmt->bind_param('sssssiiii',$userID,$CurrentResID,$cuisineCommentID,$commentContent,date("Y-m-d H:i:s"),$Rating,$like,$dislike,$review);
            $stmt->execute();
            $stmt->close();
            $temp = $userID. '_' .$CurrentResID;
            $_SESSION['ResStoreCommentRecord'][] = $temp;
            return 'true';
        }
        else {
            return 'false';
        }
    }

    /**
     * Fetch cuisine commment according to cuisineID
     * @param $userID
     * @param $cuisineID
     */
    public function fetchCuisineComment($cuisineID){
        if($stmt=$this->DataBaseCon->prepare("SELECT User.UserName, User.UserPhotoPath, CuisineComment.CuisineCommentID, CuisineComment.CuisineComent, CuisineComment.CuCommentDate, CuisineComment.CuCommentRating, CuisineComment.CuCommentLike, CuisineComment.CuCommentDislike FROM User LEFT JOIN CuisineComment ON User.UserID = CuisineComment.UserID WHERE CuisineComment.CuID=? AND CucoReview=1"))
           $stmt->bind_param('s',$cuisineID);
           $stmt->execute();
           $stmt->bind_result($UserName, $UserPhotoPath, $CuisineCommentID, $CuisineComent, $CuCommentDate, $CuCommentRating, $CuCommentLike, $CuCommentDislike);
           while($stmt->fetch()){
            $tmp[]=array('UserName'=>$UserName, 'UserPhotoPath'=>$UserPhotoPath, 'CuisineCommentID'=>$CuisineCommentID, 'CuisineComent'=>$CuisineComent, 'CuCommentDate'=>$CuCommentDate, 'CuCommentRating'=>$CuCommentRating, 'CuCommentLike'=>$CuCommentLike, 'CuCommentDislike'=>$CuCommentDislike);
           }
           $stmt->close();
           return $tmp;

    }

    /**
     * Fetch cuisine commment according to ResID
     * @param $ResID
     *
     * @return array
     */
    public function fetchResComment($ResID){
        if($stmt=$this->DataBaseCon->prepare("SELECT User.UserName, User.UserPhotoPath, RestaurantsComments.ResCommentID, RestaurantsComments.ResComment, RestaurantsComments.ResCommentDate, RestaurantsComments.ResCommentRating, RestaurantsComments.ResCommentLike, RestaurantsComments.ResCommentDislike FROM User LEFT JOIN RestaurantsComments ON User.UserID = RestaurantsComments.UserID WHERE RestaurantsComments.RestID=? AND RescoReview=1"))
            $stmt->bind_param('s',$ResID);
        $stmt->execute();
        $stmt->bind_result($UserName, $UserPhotoPath, $ResCommentID, $ResComment, $ResCommentDate, $ResCommentRating, $ResCommentLike, $ResCommentDislike);
        while($stmt->fetch()){
            $tmp[]=array('UserName'=>$UserName, 'UserPhotoPath'=>$UserPhotoPath, 'ResCommentID'=>$ResCommentID, 'RestaurantsComments'=>$ResComment, 'ResCommentDate'=>$ResCommentDate, 'ResCommentRating'=>$ResCommentRating, 'ResCommentLike'=>$ResCommentLike, 'ResCommentDislike'=>$ResCommentDislike);
        }
        $stmt->close();
        return $tmp;
    }

    /**
     * trying to return the boolean that wheather has same user id and ResID more than once.
     * @param $UserID
     * @param $ResID
     */
    public function ReturnCommentRecordCompared($UserID,$ResID){
        $tmpRecord = $UserID. '_' .$ResID;
        if (!isset($_SESSION['ResStoreCommentRecord'])) {
            $_SESSION['ResStoreCommentRecord'] = array();
        }

        $tmpArray = $_SESSION['ResStoreCommentRecord'];
        if(in_array($tmpRecord, $tmpArray)){
            return true;
        }
        else{
            return false;
        }
    }



}

/***********************************************Comment like or dislike******************************************/
class ThumbLikeOrDislike{
    private $DataBaseCon=null;
    public function __construct($DataBaseConnetcion){
        $this->DataBaseCon=$DataBaseConnetcion;
    }

    /**
     * Get Paramters to distingush like or dislike
     */
    public function GetThumbsDistingush($thumbLikeOrDislike,$CurrentUserID,$CurrentCommmentID,$CommentType){
        $tmpVariable = $CurrentUserID.'_'.$CurrentCommmentID.'_'.$thumbLikeOrDislike;
         if (in_array($tmpVariable,$_SESSION['RepeatVote'])){
            return json_encode(array('Error'=>1, 'info'=>'You already vote this cuisine!'));
          }
        else{
            if ($thumbLikeOrDislike === 'like'){
                 return $this -> InsertLike($CurrentUserID,$CurrentCommmentID,$CommentType);
            }
            elseif($thumbLikeOrDislike ==='dislike'){
                 return $this -> InsertDislike($CurrentUserID,$CurrentCommmentID,$CommentType);
            }
        }

    }

    /**
     * @param $CurrentUserID
     * @param $CurrentCommmentID
     * @param $CommentType
     *
     * @return string
     */
    private function InsertLike($CurrentUserID,$CurrentCommmentID,$CommentType){
        if ($CommentType === 'CuisineComment'){
            return $this -> _Like_CuisineComment($CurrentUserID,$CurrentCommmentID);
        }
        elseif ($CommentType === 'RestaurantsComments'){
            return $this -> _Like_RestaurantComment($CurrentUserID,$CurrentCommmentID);
        }

    }

    /**
     * @param $CurrentUserID
     * @param $CurrentCommmentID
     * @param $CommentType
     */
    private function InsertDislike($CurrentUserID,$CurrentCommmentID,$CommentType){
       if ($CommentType === 'CuisineComment'){
           return $this -> _Dislike_CuisineComment($CurrentUserID,$CurrentCommmentID);
       }
       elseif ($CommentType === 'RestaurantsComments'){
           return $this -> _Dislike_RestaurantComment($CurrentUserID,$CurrentCommmentID);
       }
    }


    /**
     * insert 1 dislike into the database according to commentID from CuisineComment
     * @param $CurrentUserID
     * @param $CurrentCommmentID
     *
     * @return string
     */
    private function _Dislike_CuisineComment($CurrentUserID,$CurrentCommmentID){
        $dislike = intval($this->getCountOfLikeOrDislikeFromCuisineComment($CurrentCommmentID)[0]['CuCommentDislike']);
        if($stmt = $this -> DataBaseCon -> prepare("UPDATE CuisineComment SET CuCommentDislike=? WHERE CuisineCommentID=?")){
            $tmp = $dislike+1;
            $stmt -> bind_param('is',$tmp,$CurrentCommmentID);
            $stmt -> execute();
            $stmt -> close();
            $Array = array('Error'=>0, 'dislike'=>1, 'ReturntCount'=>$tmp,'info'=>'Thank you for given a thumb to this comment!');
            $_SESSION['RepeatVote'][] = $CurrentUserID.'_'.$CurrentCommmentID.'_dislike';
            return json_encode($Array);
        }
    }


    /**
     * insert 1 dislike into the database according to commentID from RestaurantComment
     * @param $CurrentUserID
     * @param $CurrentCommmentID
     *
     * @return string
     */
    private function _Dislike_RestaurantComment($CurrentUserID,$CurrentCommmentID){
        $dislike = intval($this->getCountOfLikeOrDislikeFromCuisineComment($CurrentCommmentID)[0]['ResCommentDislike']);
        if($stmt = $this -> DataBaseCon -> prepare("UPDATE RestaurantsComments SET ResCommentDislike=? WHERE ResCommentID=?")){
            $tmp = $dislike+1;
            $stmt -> bind_param('is',$tmp,$CurrentCommmentID);
            $stmt -> execute();
            $stmt -> close();
            $Array = array('Error'=>0, 'dislike'=>1, 'ReturntCount'=>$tmp,'info'=>'Thank you for given a thumb to this comment!');
            $_SESSION['RepeatVote'][] = $CurrentUserID.'_'.$CurrentCommmentID.'_dislike';
            return json_encode($Array);
        }
    }




    /**
     * insert a like to cuisine comment
     * @param $CurrentUserID
     * @param $CurrentCommmentID
     *
     * @return string
     */
    private function _Like_CuisineComment($CurrentUserID,$CurrentCommmentID){
        $like = intval($this->getCountOfLikeOrDislikeFromCuisineComment($CurrentCommmentID)[0]['CuCommentLike']);
        if($stmt = $this -> DataBaseCon -> prepare("UPDATE CuisineComment SET CuCommentLike=? WHERE CuisineCommentID=?")){
            $tmp = $like+1;
            $stmt -> bind_param('is',$tmp,$CurrentCommmentID);
            $stmt -> execute();
            $stmt -> close();
            $Array = array('Error'=>0, 'like'=>1, 'ReturntCount'=>$tmp,'info'=>'Thank you for given a thumb to this comment!');
            $_SESSION['RepeatVote'][] = $CurrentUserID.'_'.$CurrentCommmentID.'_like';
            return json_encode($Array);
        }
    }


    /**
     * insert a like to restaruant comment
     * @param $CurrentUserID
     * @param $CurrentCommmentID
     *
     * @return string
     */
    private function _Like_RestaurantComment($CurrentUserID,$CurrentCommmentID){
        $like = intval($this->getCountOfLikeOrDislikeFromResComment($CurrentCommmentID)[0]['ResCommentLike']);
        if($stmt = $this -> DataBaseCon -> prepare("UPDATE RestaurantsComments SET ResCommentLike=? WHERE ResCommentID=?")){
            $tmp = $like+1;
            $stmt -> bind_param('is',$tmp,$CurrentCommmentID);
            $stmt -> execute();
            $stmt -> close();
            $Array = array('Error'=>0, 'like'=>1, 'ReturntCount'=>$tmp,'info'=>'Thank you for given a thumb to this comment!');
            $_SESSION['RepeatVote'][] = $CurrentUserID.'_'.$CurrentCommmentID.'_like';
            return json_encode($Array);
        }
    }


    /**
     * Gets Current like or dislike count from CuisineComment
     */
    private function getCountOfLikeOrDislikeFromCuisineComment($CurrentCommmentID){
        if($stmt=$this->DataBaseCon->prepare("SELECT CuCommentDislike,CuCommentLike FROM CuisineComment WHERE CuisineCommentID=?")){
           $stmt->bind_param('s',$CurrentCommmentID);
           $stmt->execute();
           $stmt->bind_result($CuCommentDislike,$CuCommentLike);
            while($stmt->fetch()){
               $ReturnArray[]=array('CuCommentDislike' => $CuCommentDislike,'CuCommentLike' => $CuCommentLike);
            }
           $stmt->close();
           return $ReturnArray;
        }
    }

    /**
     * Gets Current like or dislike count from RestaurantsComments
     * @param $CurrentCommmentID
     */
    private function getCountOfLikeOrDislikeFromResComment($CurrentCommmentID){
        if($stmt=$this->DataBaseCon->prepare("SELECT ResCommentDislike,ResCommentLike FROM RestaurantsComments WHERE ResCommentID=?")){
            $stmt->bind_param('s',$CurrentCommmentID);
            $stmt->execute();
            $stmt->bind_result($ResCommentDislike,$ResCommentLike);
            while($stmt->fetch()){
                $ReturnArray[]=array('ResCommentDislike' => $ResCommentDislike,'ResCommentLike' => $ResCommentLike);
            }
            $stmt->close();
            return $ReturnArray;
        }
    }


}

/**************************************************order*********************************************************/
class order{
    private $DataBaseCon=null;
    public function __construct($DataBaseCon){
        $this->DataBaseCon=$DataBaseCon;
    }




    /************************************************Temp order********************************/

    /**
     * this function is changed while user chagnes the count or price in that cuisine
     * @param $tempOrderID
     * @param $NewCount
     * @param $NewPrice
     */
    public function updateCurrentSubTempOrder($tempOrderID,$NewCount,$NewPrice){

        if($stmt = $this -> DataBaseCon -> prepare ("UPDATE Order_temp SET Temp_OrderCuCount = ?, Temp_OrderCuPrice = ? WHERE Temp_OrderID = ?")){
            $stmt -> bind_param('ids',$NewCount,$NewPrice,$tempOrderID);
            $stmt -> execute();
            $stmt->close();
        }

    }



    /**
     * Get Temp items is accoridng to current userID
     * @param $UserID
     *
     * @return mixed
     */
    public function GetTempItemsFromUserID($UserID){
        if($stmt = $this -> DataBaseCon -> prepare ("SELECT UserID,Temp_OrderID,CuID,ResID,Temp_OrderCuName,Temp_OrderCuSecondLevel,Temp_OrderCuPicPath,Temp_OrderCuPrice,Temp_OrderCuCount,Temp_OrderDate FROM Order_temp WHERE UserID = ?")){
            $stmt -> bind_param('s',$UserID);
            $stmt -> execute();
            $stmt -> bind_result($UserID,$Temp_OrderID,$CuID,$ResID,$Temp_OrderCuName,$Temp_OrderCuSecondLevel,$Temp_OrderCuPicPath,$Temp_OrderCuPrice,$Temp_OrderCuCount,$Temp_OrderDate);
            while($stmt -> fetch()){
                $object[] = array('UserID' => $UserID, 'Temp_OrderID' => $Temp_OrderID, 'CuID' => $CuID, 'ResID' => $ResID, 'Temp_OrderCuName' => $Temp_OrderCuName, 'Temp_OrderCuSecondLevel'=> unserialize($Temp_OrderCuSecondLevel),'Temp_OrderCuPicPath' => $Temp_OrderCuPicPath, 'Temp_OrderCuPrice' => $Temp_OrderCuPrice, 'Temp_OrderCuCount' => $Temp_OrderCuCount, 'Temp_OrderDate' => $Temp_OrderDate);
            }
            $stmt->close();
            return json_encode($object);
        }
    }

    /**
     * Delete temp order by Temp_OrderID
     * @param $TempOrderID
     *
     * @return string
     */

    public function cancelTempOrderItem($TempOrderID){
        if($stmt = $this -> DataBaseCon -> prepare ("DELETE FROM Order_temp WHERE Temp_OrderID = ?")){
           $stmt -> bind_param('s',$TempOrderID);
           $stmt -> execute();
           $stmt -> close();
           return json_encode(array('Deleted' => 1));
        }

    }



    /**
     * Get total sum of cuisine of current user
     * @param $UserID
     *
     * @return mixed
     */
    public function GetTotalCountOfAccodringToUserID($UserID){
        if($stmt = $this -> DataBaseCon -> prepare ("SELECT SUM(Temp_OrderCuCount) AS count FROM Order_temp WHERE UserID = ?")){
            $stmt -> bind_param('s',$UserID);
            $stmt -> execute();
            $stmt -> bind_result($count);
            while($stmt -> fetch()){
                $object = $count;
            }
            $stmt->close();
            if($object === null ){
                $object = 0;
            }
            return json_encode($object);
        }
    }

    /**
     * fetch temp paramters
     * @param $userID
     * @param $cuID
     */
    public function AddedTOATempOrder($userID,$temOderID,$cuID,$currenResID,$currentCuName,$currentCuPicPath,$currentPrice,$currentCuSecondLevel){
        if(count($this -> checkTempOrder($userID,$cuID,serialize($currentCuSecondLevel))) === 0){
            $getTempOrderID = $temOderID;
            $getTemp_OrderCuCount = 1;
            $getTemp_OrderDate = date("Y-m-d H:i:s");

            if($stmt = $this -> DataBaseCon -> prepare("INSERT INTO Order_temp (UserID, Temp_OrderID, CuID, ResID,Temp_OrderCuName,Temp_OrderCuSecondLevel,Temp_OrderCuPicPath, Temp_OrderCuPrice, Temp_OrderCuCount, Temp_OrderDate) VALUES (?,?,?,?,?,?,?,?,?,?)")){
                $stmt -> bind_param('sssssssdis',$userID,$getTempOrderID,$cuID,$currenResID,$currentCuName,serialize($currentCuSecondLevel),$currentCuPicPath,$currentPrice,$getTemp_OrderCuCount,$getTemp_OrderDate);
                $stmt -> execute();
                $stmt -> close();
                return json_encode(array('sucess' => 1));
            }
        }
        else{
          return  $this -> updateTempOrder ($userID,$cuID,$currentPrice,serialize($currentCuSecondLevel));
        }
    }





    /**
     * Calculate the Deliver fee
     */
    public function CaculatedDeliverFee($USERID){
        if($USERID!==""){
            $OldTotalPrice = json_decode($this -> fetchTotalPrice($USERID)) -> result;
            $GenerateDeliveryFee = $this -> feeDistinguish($OldTotalPrice);
            $GetExtraFee = $this -> fetchTheNumberOfRest($USERID);
            $finalDeliverFee = intval($GenerateDeliveryFee) + intval($GetExtraFee);
            return json_encode(array('ReturnedDeliveryFee' =>1, 'finalDeliverFee' => $finalDeliverFee, 'CuisineFee'=>$GenerateDeliveryFee, 'ExtraFee'=>$GetExtraFee));
        }
        else{
            return json_encode(array('ReturnedDeliveryFee' =>1, 'finalDeliverFee' => 0));

        }

    }


    /**
     *fetch the total price from the table of Order_temp
     */
    public function fetchTotalPrice($USERID){
        if($stmt = $this -> DataBaseCon -> prepare("SELECT SUM(Temp_OrderCuPrice) AS Total FROM Order_temp WHERE UserID=?")){
            $stmt -> bind_param('s',$USERID);
            $stmt -> execute();
            $stmt -> bind_result($Total);
            while($stmt -> fetch()){
                $object = $Total;
            }
            $stmt -> close();

            return json_encode(array('success' => 1,'result' => $object));
        }


    }


    /**
     *
     * Distinguish different fee
     * @param $totalprice
     *
     * @return string
     */
    private function feeDistinguish($totalprice){
        $getFormatTotalprice = number_format((float)$totalprice, 2, '.', '');
        if($getFormatTotalprice === 0.00){
            return '0';
        }
        else if($getFormatTotalprice > 0.00 && $getFormatTotalprice < 29.99){
            return '3';
        }
        else if($getFormatTotalprice > 30.00 && $getFormatTotalprice < 49.99){ // if current total price is between 30.00 and 49.99
            return '4';
        }
        else if($getFormatTotalprice > 50.00 && $getFormatTotalprice < 69.99){// if current total price is from 50.00 to 69.99
            return '5';
        }
        else if($getFormatTotalprice > 70.00 && $getFormatTotalprice < 100.00){ // if current total price has scope between 70.00 and 100.00
            return '6';
        }
        else if($getFormatTotalprice > 100.99){
            return '7';
        }

    }

    /**
     * fetch the number of restaurants in Order_temp
     * return the count that displays how many different resurants
     */
    private function fetchTheNumberOfRest($USERID) {
        if($stmt = $this -> DataBaseCon -> prepare("SELECT COUNT(ResID) AS different FROM Order_temp WHERE UserID =? GROUP BY ResID")){
            $stmt -> bind_param('s',$USERID);
            $stmt -> execute();
            $stmt -> bind_result($different);
            while($stmt -> fetch()){
                $object = $different;
            }
            $stmt -> close();

            return $object;
        }
    }











    /**
     * checking exeisting record
     * @param $userID
     * @param $cuID
     */
    private function checkTempOrder($userID,$cuID,$CusecondLevel){

        if($stmt = $this -> DataBaseCon -> prepare ("SELECT * FROM Order_temp WHERE UserID = ? AND CuID = ? AND Temp_OrderCuSecondLevel=?")){
           $stmt -> bind_param('sss',$userID,$cuID,$CusecondLevel);
           $stmt -> execute();
           $result = $stmt->get_result();
           $object=array();
           while($row=$result->fetch_assoc()){
                array_push($object,$row);
           }
           $stmt->close();
           return $object;
        }

    }

    /**
     * Updating the record for temp order
     * @param $userID
     * @param $cuID
     * @param $currentPrice
     */
    private function updateTempOrder($userID,$cuID,$currentPrice,$currentSecondLevel){
        $getCuprice = $this -> checkTempOrder ($userID, $cuID,$currentSecondLevel)[0]['Temp_OrderCuPrice'];
        $getCount = $this -> checkTempOrder ($userID, $cuID,$currentSecondLevel)[0]['Temp_OrderCuCount'];
        //passed parameters
        $newPrice = $getCuprice + $currentPrice;
        $newCount = $getCount + 1;
        if($stmt = $this -> DataBaseCon -> prepare ("UPDATE Order_temp SET Temp_OrderCuPrice = ?, Temp_OrderCuCount = ? WHERE  UserID=? AND CuID = ?")){
           $stmt -> bind_param('diss',$newPrice, $newCount, $userID, $cuID );
           $stmt -> execute();
           $stmt -> close();
        }
        return json_encode(array('update' => 1));

    }
}



/****************************************** Promotion *************************************************/
class Promotion{
    private $DataBaseCon=null;
    public function __construct($DataBaseCon){
        $this->DataBaseCon=$DataBaseCon;
    }

    /**
     * @param $GetFeaturedID
     * @param $GetFeaturedType
     *
     * @return string
     */
    public function CuisinePromotion($GetFeaturedID,$GetFeaturedType){
        if($this -> AddedPromotion($GetFeaturedID, $GetFeaturedType)){
            return json_encode(array('status'=>'successed'));
        }
        else{
            return json_encode(array('status'=>'failured'));

        }

    }

    /**
     * @param $GetFeaturedID
     * @param $GetFeaturedType
     *
     * @return bool
     */
    private function AddedPromotion($GetFeaturedID,$GetFeaturedType){
        if($stmt = $this -> DataBaseCon -> prepare ("INSERT INTO Featured (FeaturedID,Type) VALUES (?,?)")){
            $stmt -> bind_param('ss',$GetFeaturedID, $GetFeaturedType);
            $stmt -> execute();
            $stmt -> close();
            return true;
        }
        else{
            return false;
        }
    }


    public function RequestingDelete($ID){
        if($stmt = $this -> DataBaseCon -> prepare ("UPDATE Featured SET RequestingDel=1 WHERE FeaturedID=?")){
            $stmt -> bind_param('s',$ID);
            $stmt -> execute();
            $stmt -> close();
            return json_encode(array('status'=>'successed'));
        }
        else{
            return json_encode(array('status'=>'failured'));
        }
    }

    /**
     * @return array
     */

    public function FetchPromotionDataWithRestaruant($ResID){
        if($stmt = $this -> DataBaseCon -> prepare ("SELECT Restaurants.RestID,Restaurants.ResName,Restaurants.ResPicPath, Restaurants.ResAddress, Restaurants.ResRootAddress, Featured.Type, Featured.Status, Featured.RequestingDel FROM Restaurants INNER JOIN Featured ON Restaurants.RestID=Featured.FeaturedID WHERE Restaurants.RestID=? AND Restaurants.ResReview=1")){
            $stmt -> bind_param('s',$ResID);
            $stmt -> execute();
            $stmt -> bind_result($RestID,$ResName,$ResPicPath,$ResAddress,$ResRootAddress,$Type,$Status,$RequestingDel);
            while($stmt -> fetch()){
                $array[] = array('ResName'=>$ResName,'ResPicPath'=>$ResPicPath,'ResAddress'=>$ResAddress.', '.$ResRootAddress,'Type'=>$Type,'RestID'=>$RestID,'Status'=>$Status,'RequestingDel'=>$RequestingDel);
            }
            $stmt -> close();
            return $array;
        }
    }

    /**
     * @return array
     */

    private function FetchPromotionDataWithRestaruant_noPa(){
        if($stmt = $this -> DataBaseCon -> prepare ("SELECT Restaurants.RestID,Restaurants.ResName,Restaurants.ResPicPath, Restaurants.ResAddress, Restaurants.ResRootAddress, Featured.Type, Featured.Status, Featured.RequestingDel FROM Restaurants INNER JOIN Featured ON Restaurants.RestID=Featured.FeaturedID WHERE Restaurants.ResReview=1")){
            $stmt -> execute();
            $stmt -> bind_result($RestID,$ResName,$ResPicPath,$ResAddress,$ResRootAddress,$Type,$Status,$RequestingDel);
            while($stmt -> fetch()){
                $array[] = array('RestID'=>$RestID,'ResPicPath'=>$ResPicPath, 'ResName'=>$ResName,'ResAddress'=>$ResAddress.', '.$ResRootAddress,'Type'=>$Type,'Status'=>$Status,'RequestingDel'=>$RequestingDel);

            }
            $stmt -> close();
            return $array;
        }
    }


    /**
     *
     * Fetch promotion data cuisines only
     * @param $ResID
     *
     * @return array
     */

    private function FetchPromotionDataWithCuisines($ResID){
        if($stmt = $this -> DataBaseCon -> prepare ("SELECT Cuisine.CuID, Cuisine.CuName, Cuisine.CuDescr, Cuisine.CuPicPath, Cuisine.Price, Featured.Type, Featured.Status, Featured.RequestingDel FROM Cuisine INNER JOIN Featured ON Cuisine.CuID=Featured.FeaturedID WHERE Cuisine.RestID = ? AND Cuisine.CuReview=1")){
            $stmt -> bind_param('s',$ResID);
            $stmt -> execute();
            $stmt -> bind_result($CuID,$CuName,$CuDescr,$CuPicPath,$Price,$Type,$Status,$RequestingDel);
            while($stmt -> fetch()){
                $array[] = array('Status'=>$Status,'CuName'=>$CuName,'CuDescr'=>$CuDescr,'CuPicPath'=>$CuPicPath,'Price'=>$Price,'Type'=>$Type,'CuID'=>$CuID,'RequestingDel'=>$RequestingDel);
            }
            $stmt -> close();
            return $array;
        }

    }


    /**
     * @return array
     */
    private function FetchPromotionDataWithCuisines_noPa(){
        if($stmt = $this -> DataBaseCon -> prepare ("SELECT Cuisine.CuID, Cuisine.CuName, Cuisine.CuDescr, Cuisine.CuPicPath, Cuisine.Price, Featured.Type, Featured.Status, Featured.RequestingDel FROM Cuisine INNER JOIN Featured ON Cuisine.CuID=Featured.FeaturedID WHERE Cuisine.CuReview=1")){
            $stmt -> bind_param('s',$ResID);
            $stmt -> execute();
            $stmt -> bind_result($CuID,$CuName,$CuDescr,$CuPicPath,$Price,$Type,$Status,$RequestingDel);
            while($stmt -> fetch()){
                $array[] = array('CuID'=>$CuID,'CuPicPath'=>$CuPicPath,'CuName'=>$CuName,'CuDescr'=>$CuDescr,'Price'=>$Price,'Type'=>$Type,'Status'=>$Status,'RequestingDel'=>$RequestingDel);
            }
            $stmt -> close();
            return $array;
        }

    }



    /**
     * @param $getResID
     */
    public function listPromotion($getResID){
        $array = $this -> FetchPromotionDataWithCuisines($getResID);
        echo '<table class="table table-striped" id="CusinesTable">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>Name</th>';
        echo '<th>Description</th>';
        echo '<th>Picture</th>';
        echo '<th>Price</th>';
        echo '<th>Operation</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        foreach ($array as $Rootkey=>$SubArray){
            if($SubArray['Status'] === 0){
            echo "<tr class='warning'>";
            }
            elseif($SubArray['Status'] === 1){
            echo "<tr class='success'>";

            }
            foreach ($SubArray as $key=>$value){
                if($key==='CuName'){
                    echo "<td class='CuName' id='$value'><div class='TablePreventOverflow' title='$value'>$value</div></td>";
                }
                if($key==='CuDescr'){
                    echo "<td><div class='TablePreventOverflow' title='$value'>$value</div></td>";
                }
                if($key==='CuPicPath'){
                        echo "<td><a href='$value' target='_blank'><img style='width:50px;height:50px' src='$value'></a></td>";
                }

                if($key==='Price'){
                    echo '<td>$'.$value.'</td>';
                }


                if($key==='CuID'){
                    echo '<td>';
                    if($SubArray['RequestingDel'] === 0){
                        echo "<button class='button text-right Requesting-delete' id='$value' type='button'>Pending...</button>";
                    }
                    elseif($SubArray['RequestingDel'] === 1){
                        echo "<button class='button text-right' type='button'>Requesting to Cancel ...</button>";
                    }


                    echo '</td>';

                }


            }
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';

    }







    //CMS only for cuisine
    public function FeaturedManagementTable_cuisine(){
        $array = $this -> FetchPromotionDataWithCuisines_noPa();
        echo '<table class="table table-striped">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>Operation</th>';
        echo '<th>Picture</th>';
        echo '<th>Name</th>';
        echo '<th>Description</th>';
        echo '<th>Price</th>';
        echo '<th>Type</th>';
        echo '<th>Status</th>';
        echo '<th>Deleting</th>';

        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        foreach ($array as $Rootkey=>$SubArray){
            echo '<tr>';
            foreach ($SubArray as $key=>$value){
                if($key==='CuID'){
                    echo '<td>';
                    echo '<label class="checkbox">';
                    echo "<input id='$value' type='checkbox'>";
                    echo '</label>';


                    echo '</td>';

                }
                if($key==='CuPicPath'){
                    echo "<td><a href='$value' target='_blank'><img style='width:50px;height:50px' src='$value'></a></td>";
                }

                if($key==='CuName'){
                    echo "<td class='CuName' id='$value'><div class='TablePreventOverflow' title='$value'>$value</div></td>";
                }
                if($key==='CuDescr'){
                    echo "<td><div class='TablePreventOverflow' title='$value'>$value</div></td>";
                }

                if($key==='Price'){
                    echo '<td>$'.$value.'</td>';
                }
                if($key==='Type'){
                    echo '<td>'.$value.'</td>';
                }
                if($key==='Status'){
                    if($value === 0){
                    echo '<td>InActive</td>';
                    }
                    elseif($value === 1){
                    echo '<td>Active</td>';
                    }
                }

                if($key==='RequestingDel'){
                    if($value === 0){
                    echo '<td>None</td>';
                    }
                    elseif($value === 1){
                    echo '<td>Yes</td>';
                    }
                }




            }
            echo '</tr>';
        }

        echo '</tbody>';

        echo '</table>';
        echo "<button class='btn text-right ' type='button'>Active</button>";

    }




    public function FeaturedManagementTable_Restaruant(){

        $array = $this -> FetchPromotionDataWithRestaruant_noPa();
        echo '<table class="table table-striped">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>Operation</th>';
        echo '<th>Picture</th>';
        echo '<th>Name</th>';
        echo '<th>Address</th>';
        echo '<th>Type</th>';
        echo '<th>Status</th>';
        echo '<th>Deleting</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        foreach ($array as $Rootkey=>$SubArray){
            echo '<tr>';
            foreach ($SubArray as $key=>$value){
                if($key==='RestID'){
                    echo '<td>';
                    echo '<label class="checkbox">';
                    echo "<input id='$value' type='checkbox'>";
                    echo '</label>';
                    echo '</td>';

                }
                if($key==='ResPicPath'){
                    echo "<td><a href='$value' target='_blank'><img style='width:50px;height:50px' src='$value'></a></td>";
                }

                if($key==='ResName'){
                    echo "<td class='CuName' id='$value'><div class='TablePreventOverflow' title='$value'>$value</div></td>";
                }

                if($key==='ResAddress'){
                    echo '<td>$'.$value.'</td>';
                }
                if($key==='Type'){
                    echo '<td>'.$value.'</td>';
                }
                if($key==='Status'){
                    if($value === 0){
                        echo '<td>InActive</td>';
                    }
                    elseif($value === 1){
                        echo '<td>Active</td>';
                    }
                }
                if($key==='RequestingDel'){
                    if($value === 0){
                        echo '<td>None</td>';
                    }
                    elseif($value === 1){
                        echo '<td>Yes</td>';
                    }
                }



            }
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
        echo "<button class='btn text-right' type='button'>Active</button>";

    }
}



/********************************************Co - Mobile end ****************************************************/
//Manager class that will manager the relationship between manager and delivery
class _ManagerDeliverer{
    private $DataBaseCon=null;
    public function __construct($DataBaseCon){
        $this->DataBaseCon=$DataBaseCon;
    }

    /**
     *
     * Get paramters then insert into database
     * @param $Manager_DelivererID
     * @param $Manager_DeliverEmail
     * @param $Manager_DeliverPassword
     * @param $Manager_Deliver_Name
     * @param $Type
     */
    public function RegisterManagerOrDeliverer($Manager_DelivererID,$Manager_DeliverEmail,$Manager_DeliverPassword,$Manager_Deliver_Name,$Manager_Deliver_Phone,$Type){
            if($this -> RegisterValidation($Manager_DeliverEmail)){
                if($this -> InsertRegisterData($Manager_DelivererID,$Manager_DeliverEmail,$Manager_DeliverPassword,$Manager_Deliver_Name,$Manager_Deliver_Phone,$Type)){
                    return json_encode(array('status'=>'successed'));
                }
                else
                {
                    return json_encode(array('status'=>'failured'));
                }
            }
            else{
            return json_encode(array('status'=>'failured'));
              }
    }

    /**
     *
     * @param $Manager_DelivererID
     * @param $Manager_DeliverEmail
     * @param $Manager_DeliverPassword
     * @param $Manager_Deliver_Name
     * @param $Type
     */
    private function InsertRegisterData($Manager_DelivererID,$Manager_DeliverEmail,$Manager_DeliverPassword,$Manager_Deliver_Name,$Manager_Deliver_Phone,$Type){
        $val = 1;
        if($stmt = $this -> DataBaseCon -> prepare ("INSERT INTO User (UserID,UserMail,UserPassWord,UserName,UserPhone,UserType,UserStatus) VALUES (?,?,?,?,?,?,?)")){
            $stmt -> bind_param('isssisi',$Manager_DelivererID, $Manager_DeliverEmail, md5(base64_encode($Manager_DeliverPassword)),$Manager_Deliver_Name,$Manager_Deliver_Phone,$Type,intval($val));
            $stmt -> execute();
            $stmt -> close();
            return true;
        }
        else{
            return false;
        }
    }


    /**
     *
     * validation that is repeated registers
     * @param $Manager_DeliverEmail
     *
     * @return bool
     */
    private function RegisterValidation($Manager_DeliverEmail){
        if($stmt = $this -> DataBaseCon -> prepare ("SELECT * FROM User WHERE UserMail=?")){
            $stmt->bind_param('s',$Manager_DeliverEmail);
            $stmt->execute();
            $result = $stmt->get_result();
            $object=array();
            while($row=$result->fetch_assoc()){
                array_push($object,$row);
            }
            $stmt->close();
            if(count($object)>0){
                return false;
            }
            else{
                return true;
            }
        }
    }

    /**
     *
     * @param $Type
     */
    private function SelectManagerOrDeliverer($Type){
        if($stmt = $this -> DataBaseCon -> prepare ("SELECT UserID, UserName, UserMail, UserPhone, UserType FROM User WHERE UserType=?")){
            $stmt->bind_param('s',$Type);
            $stmt->execute();
            $stmt->bind_result($UserID, $UserName, $UserMail, $UserPhone, $UserType);
            while($stmt -> fetch()){
                $array[]=array('UserID' => $UserID, 'UserName'=> $UserName, 'UserMail' => $UserMail, 'UserPhone' => $UserPhone, 'UserType' => $UserType);
            }
            $stmt->close();
            return $array;
        }
    }













    /**
     * Fetch the paramters then validates them first if okay then insert record else return failure
     * @param $UniqueID
     * @param $Name
     * @param $RootID
     *
     * @return string
     */
    public function FetchParamerAndReadyInsert($UniqueID, $Name, $RootID){
        if($this -> Validation($Name)){
            return $this -> InsertNewManager($UniqueID, $Name, $RootID);
        }
        else{
            return json_encode(array('status'=>'failed'));
        }
    }



    /**
     *
     * This function is getting the paramters from front end and inserts the record into the db
     * @param $Name
     * @param $RootID
     */
    private function InsertNewManager($UniqueID, $Name, $RootID){
        if($stmt = $this -> DataBaseCon -> prepare ("INSERT INTO Manager (ManagerID,Manager,RootID) VALUES (?,?,?)")){
            $stmt -> bind_param('sss',$UniqueID, $Name, $RootID);
            $stmt -> execute();
            $stmt -> close();
            return json_encode(array('status'=>'successed'));
        }
    }

    /**
     *
     * do validation if it is possible
     * @param $Name
     *
     * @return bool
     */
    private function Validation($Name){
        if($stmt = $this -> DataBaseCon -> prepare ("SELECT * FROM Manager WHERE Manager=?")){
            $stmt->bind_param('s',$Name);
            $stmt->execute();
            $result = $stmt->get_result();
            $object=array();
            while($row=$result->fetch_assoc()){
                array_push($object,$row);
            }
            $stmt->close();
            if(count($object)>0){
                return false;
            }
            else{
                return true;
            }
        }
    }


    /**
     * return the whole table
     * @return array
     */
    private function GenerateQueryInfo(){
        if($stmt = $this -> DataBaseCon -> prepare ("SELECT * FROM Manager")){
            $stmt->execute();
            $result = $stmt->get_result();
            $object=array();
            while($row=$result->fetch_assoc()){
                array_push($object,$row);
            }
            $stmt->close();
            return $object;
        }
    }

    /**
     * This function is only displying the view of Manager table that comes from User table
     */
    public function qViewManagerOrDelivererTable($type){
           echo  '<table class="table table-striped">';
           echo  '<thead>';
           echo  '<tr>';
           echo  '<th>User ID</th>';
           echo  '<th>User Name</th>';
           echo  '<th>User Mail</th>';
           echo  '<th>User Type</th>';
           echo  '<th>Delete</th>';
           echo  '</tr>';
           echo  '</thead>';
           echo  '<tbody>';
           foreach ($this -> SelectManagerOrDeliverer($type) as $index => $subarray){
               echo  '<tr>';
               foreach ($subarray as $key => $value){
                   if($key === 'UserID'){
                       echo '<td class="ManagerID">'.$value.'</td>';
                   }
                   if($key === 'UserMail'){
                       echo '<td>'.$value.'</td>';
                   }
                   if($key === 'UserName'){
                       echo '<td>'.$value.'</td>';
                   }
                   if($key === 'UserPhone'){
                       echo '<td>'.$value.'</td>';
                   }

                   if($key === 'UserType'){
                       echo '<td>'.$value.'</td>';
                   }
               }
               echo '<td><button class="button deleteManager" type="button">Delete</button></td>';
               echo '</tr>';
           }

           echo  '</tbody>';
           echo  '</table>';


    }

    /**
     * This function is only generating the query view by table
     */
    public function qViewTable(){

      echo  '<table class="table table-striped">';
      echo  '<thead>';
      echo  '<tr>';
      echo  '<th>Manager ID</th>';
      echo  '<th>Current Root ID</th>';
      echo  '<th>Manager Name</th>';
      echo  '<th>Change</th>';
      echo  '<th>Delete</th>';
      echo  '</tr>';
      echo  '</thead>';
      echo  '<tbody>';
      foreach ($this -> GenerateQueryInfo() as $index => $subarray){
          echo  '<tr>';
          foreach ($subarray as $key => $value){
              if($key === 'ManagerID'){
                  echo '<td class="ManagerID">'.$value.'</td>';
              }
              if($key === 'RootID'){
                  echo '<td>'.$value.'</td>';
              }
              if($key === 'Manager'){
                  echo '<td>'.$value.'</td>';
              }

          }
          echo '<td><button class="button ChangeManager" type="button">Change</button></td>';
          echo '<td><button class="button deleteManager" type="button">Delete</button></td>';
          echo '</tr>';
      }

     echo  '</tbody>';
     echo  '</table>';
    }

    /**
     * Delete current Manager according ID
     * @param $getID
     *
     * @return string
     */
    public function DeleteMnager($getID){
        if($stmt = $this -> DataBaseCon -> prepare ("DELETE FROM User WHERE UserID=? ")){
            $stmt -> bind_param('i',$getID);
            $stmt -> execute();
            $stmt -> close();
            return json_encode(array('status'=>'successed'));
        }
        else{
            return json_encode(array('status'=>'failed'));
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

    /**
     * According to UserID and password to return the info
     * @param $RquestUserID
     * @param $RquestionPass
     */
    public function ReturnUserInfo($RequestUserMail,$RequestPass,$FacebookID,$RequestType){
        $UserClass=new User($this -> DataBaseCon);
        $UserInfoArray = $UserClass -> ReturnValiationOfUserPass($RequestUserMail,$RequestPass,$FacebookID,$RequestType);
        if (count($UserInfoArray)>0){
            return json_encode($UserInfoArray);
        }
        else if(count($UserInfoArray)===0){
            return json_encode(array('UserID' => $RequestUserID, 'Authorization' => 'fail'));
        }
    }

    /**
     *
     * Get paramters from search and return the relative json data
     * @param $GetSearchValue
     * @param $GetType
     * @param $startCount
     * @param $count
     */
    public function ReturnSearchResult($GetSearchLoaction,$GetSearchValue,$GetType,$startCount,$count){
        if($GetType === 'Default'){
            return $this -> DefaultSearch($GetSearchLoaction,$GetSearchValue,$startCount,$count);
        }
        if($GetType === 'Cuisines'){
            return $this -> CuisineSearchOnly($GetSearchLoaction,$GetSearchValue,$startCount,$count);
        }
        if($GetType === 'Restaurants'){
            return $this -> RestaurantSearchOnly($GetSearchLoaction,$GetSearchValue,$startCount,$count);
        }
        if($GetType === 'Tags'){
            return $this -> TagesSearchOnly($GetSearchLoaction,$GetSearchValue,$startCount,$count);
        }
    }


    /**
     * Return restaurants only by location name
     * @param $LocationName
     * @param $startCount
     * @param $limitedCount
     * @param $AvailabilityTagsArray
     * @param $CuisineTagsArray
     */

    public function ReturnRestaurantOnlyByLocation($LocationName,$startCount,$limitedCount,$AvailabilityTagsArray,$CuisineTagsArray){
        $RestartuantClass = new Restartuant($this -> DataBaseCon);
        $CuisineComemnt = new CuisineComemnt($this -> DataBaseCon);
        $GetAllRes = $RestartuantClass -> ReturnResLocation($LocationName);
        $GetAllResWithComment = $CuisineComemnt -> IntergrateCommentWithRestaruant($GetAllRes);
        $FinalResult = $this -> filtertags($AvailabilityTagsArray,$CuisineTagsArray,null,null,$GetAllResWithComment);
        $ReturnResult = $this -> returnLimitedRecord($FinalResult,$startCount,$ReturnCount);

        return json_encode($ReturnResult);

    }



    /**
     * Return Cuisine according to location
     * @param $locationName
     * @param $startCount
     * @param $ReturnCount
     * @param $AvailabilityTagsArray
     * @param $CuisineTagsArray
     * @param $TypeTagsArray
     * @param $PriceTagsArray
     */


    public function ReturnCusineAccordingToLocation($locationName,$startCount,$ReturnCount,$AvailabilityTagsArray,$CuisineTagsArray,$TypeTagsArray,$PriceTagsArray){
        $CuisineClass = new Cuisine($this -> DataBaseCon);
        $RestartuantClass = new Restartuant($this -> DataBaseCon);
        $CuisineComemnt = new CuisineComemnt($this -> DataBaseCon);
        $GetAllRes = $RestartuantClass -> ReturnResLocation($locationName);
        $GetAllResWithComment = $CuisineComemnt -> IntergrateCommentWithRestaruant($GetAllRes);
        $GetResult = $CuisineClass -> ReturnCuisineOnlyAccordingToRes($GetAllResWithComment);
        $GetIntergrateComments = $CuisineComemnt -> IntergrateCommentWithCuisine($GetResult);
        $FinalResult = $this -> filtertags($AvailabilityTagsArray,$CuisineTagsArray,$TypeTagsArray,$PriceTagsArray,$GetIntergrateComments);
        $ReturnResult = $this -> returnLimitedRecord($FinalResult,$startCount,$ReturnCount);
        return json_encode($ReturnResult);

    }


    /**
     * return Restaurant and cuisine by location
     * @param $locationName
     * @param $startCount
     * @param $ReturnCount
     * @param $AvailabilityTagsArray
     * @param $CuisineTagsArray
     * @param $TypeTagsArray
     * @param $PriceTagsArray
     *
     * @return string
     */

    public function ReturnResAndCusineAccordingToLocation($locationName,$startCount,$ReturnCount,$AvailabilityTagsArray,$CuisineTagsArray,$TypeTagsArray,$PriceTagsArray){
        $CuisineClass=new Cuisine($this->DataBaseCon);
        $RestartuantClass=new Restartuant($this->DataBaseCon);
        $CuisineComemnt = new CuisineComemnt($this -> DataBaseCon);
        $GetAllRes=$RestartuantClass->ReturnResLocation($locationName);
        $GetAllResWithComment = $CuisineComemnt -> IntergrateCommentWithRestaruant($GetAllRes);
        $GetResult=$CuisineClass->ReturnCuisineAccordingToRes($GetAllResWithComment);
        $GetIntergrateComments = $CuisineComemnt -> IntergrateCommentWithCuisine($GetResult);
        $ReturnResult=$this->filtertags($AvailabilityTagsArray,$CuisineTagsArray,$TypeTagsArray,$PriceTagsArray,$GetIntergrateComments);
        $FinalResult=$this->returnLimitedRecord($ReturnResult,$startCount,$ReturnCount);
        return json_encode($FinalResult);
    }

    /**
     * return Restaurant and cuisine together
     * @return string
     */

    public function RestaurantAndcuisine(){
        $CuisineClass=new Cuisine($this->DataBaseCon);
        $RestartuantClass=new Restartuant($this->DataBaseCon);
        //get Cuisine and its SecondLevel
        $getCuisineWithSecondLevel=$CuisineClass->CuisineWithSeondLevel();
        $CuisineAndRestaurants=$RestartuantClass->RestartuantProcess($getCuisineWithSecondLevel);
        return json_encode($CuisineAndRestaurants);
    }

    /**
     * return Current restaurant's cuisines without speci cuisineID
     * @param $Resid
     * @param $CuisineID
     * @param $startCount
     * @param $ReturnCount
     * @return string
     */
    public function ReturnCurrentRestaurantCuisine($Resid,$CuisineID,$startCount,$ReturnCount){
        $CuisineClass=new Cuisine($this->DataBaseCon);
        $RestartuantClass=new Restartuant($this->DataBaseCon);
        $CuisineComemnt = new CuisineComemnt($this -> DataBaseCon);
        $GetCuisineOfRes = $CuisineClass->ReturnCuisinewithResIDandReview($Resid,$CuisineID);
        $GetFinalCuisine = $CuisineClass->ReturnfinalCuisine($GetCuisineOfRes);//combine the second level
        $GetFinalCuisineAndResName = $RestartuantClass->ReturnResNameOfCuisine($GetFinalCuisine);
        $GetIntergrateComments = $CuisineComemnt -> IntergrateCommentWithCuisine($GetFinalCuisineAndResName);
        $ReturnResult=$this->returnLimitedRecord($GetIntergrateComments,$startCount,$ReturnCount);
        return json_encode($ReturnResult);
    }

    /**
     * Return all cuisine according to sepcial ResID, and if filter has been chosen then do the filter things before return final json array
     * @param $Resid
     * @param $startCount
     * @param $ReturnCount
     * @param $AvailabilityTagsArray
     * @param $CuisineTagsArray
     */
    public function ReturnAllCuisineAccordingToResID($Resid,$startCount,$ReturnCount,$AvailabilityTagsArray,$CuisineTagsArray,$TypeTagsArray,$PriceTagsArray){
        $CuisineClass=new Cuisine($this->DataBaseCon);
        $RestartuantClass=new Restartuant($this->DataBaseCon);
        $CuisineComemnt = new CuisineComemnt($this -> DataBaseCon);
        $AllFirstCuisine= $CuisineClass -> ReturnCuisinewithReviewbyResID($Resid);
        $GetFinalCuisine = $CuisineClass->ReturnfinalCuisine($AllFirstCuisine);//combine the second level
        $GetIntergrateComments = $CuisineComemnt -> IntergrateCommentWithCuisine($GetFinalCuisine);
        $ReturnResult=$this->filtertags($AvailabilityTagsArray,$CuisineTagsArray,$TypeTagsArray,$PriceTagsArray,$GetIntergrateComments);
        $FinalResult=$this->returnLimitedRecord($ReturnResult,$startCount,$ReturnCount);
        return json_encode($FinalResult);
    }

    /**
     * return My favourite and status is 1
     * @param $UserID
     * @param $Status
     *
     * @return string
     */

    public function ReturnMyFavourite($UserID,$Status){
        $Favoriteclass=new favourite($this->DataBaseCon);
        $GetCuisineID=$Favoriteclass->returnCuisineID($UserID,$Status);
        $getFinalFavouriteCuisine=$this->LoopCuisineID($GetCuisineID);
        return json_encode($getFinalFavouriteCuisine);
    }

    /**
     * Return Cuisine comments
     * @param $UserID
     * @param $CuID
     */
    public function ReturnCommentOfCuisine($CuID,$CurrentCount,$limitedCount){
         $CuisineComemntclass = new CuisineComemnt($this->DataBaseCon);
         $getTotalCommentClass = $CuisineComemntclass-> fetchCuisineComment($CuID);
         $ReturnResult=$this->returnLimitedRecord($getTotalCommentClass,$CurrentCount,$limitedCount);
         return json_encode($ReturnResult);
    }

    /**
     * Return Restaurant comments
     * @param $ResID
     * @param $CurrentCount
     * @param $limitedCount
     *
     * @return string
     */
    public function ReturnCommentOfRes($ResID,$CurrentCount,$limitedCount){
        $CuisineComemntclass = new CuisineComemnt($this->DataBaseCon);
        $getTotalCommentClass = $CuisineComemntclass-> fetchResComment($ResID);
        $ReturnResult=$this->returnLimitedRecord($getTotalCommentClass,$CurrentCount,$limitedCount);
        return json_encode($ReturnResult);
    }

    /*****************************************private function *********************************/



    /**
     * return search result by default
     * @param $GetSearchValue
     * @param $startCount
     * @param $count
     */
    private function DefaultSearch($GetSearchLoaction,$GetSearchValue,$startCount,$count){
        //decaler the new class
        $CuisineClass = new Cuisine($this->DataBaseCon);
        $RestartuantClass = new Restartuant($this->DataBaseCon);
        $CuisineComemnt = new CuisineComemnt($this -> DataBaseCon);
        $InitialLocationSelectClass=new InitialLocationSelect($this -> DataBaseCon);
        //get Restaurants that belonged to 'Search loaction';
        $GetAllRes = $RestartuantClass->FetchResFilter($InitialLocationSelectClass->GetsRootLocalName($GetSearchLoaction),$GetSearchValue);//get all restaurant that corresponds to query condition
        $GetAllResWithComment = $CuisineComemnt -> IntergrateCommentWithRestaruant($GetAllRes);
        //cuisine only
        $GetResult = $CuisineClass -> ReturnAllCuisineByLikeQuery($InitialLocationSelectClass->GetsRootLocalName($GetSearchLoaction), $GetSearchValue);//get all cuisines without second level
        $GetCuisine = $CuisineClass -> ReturnfinalCuisine($GetResult); //get all cuisine with second level
        $GetFinalCuisineAndResName = $RestartuantClass->ReturnResNameOfCuisine($GetCuisine);
        $GetIntergrateComments = $CuisineComemnt -> IntergrateCommentWithCuisine($GetFinalCuisineAndResName);
        // combine the restaurants and cuisines
        $finalReturn = array_merge($GetAllResWithComment,$GetIntergrateComments);
        if(count($finalReturn)===0){
            return $this -> TagesSearchOnly($GetSearchLoaction,$GetSearchValue,$startCount,$count); //Tages Search only
        }
        elseif(count($finalReturn)>0){
            $InsectArray = array_intersect ($finalReturn,json_decode($this -> TagesSearchOnly($GetSearchLoaction,$GetSearchValue,$startCount,$count)));
            $DifferArry = array_diff ($finalReturn,json_decode($this -> TagesSearchOnly($GetSearchLoaction,$GetSearchValue,$startCount,$count)));
            $ReturnArray = array_merge ($InsectArray,$DifferArry);
            $FinalReturnResult=$this->returnLimitedRecord($ReturnArray,$startCount,$count);
            return json_encode($FinalReturnResult);
        }


    }


    /**
     * Return cuisine result only
     * @param $GetSearchValue
     * @param $startCount
     * @param $count
     */
    private function CuisineSearchOnly($GetSearchLoaction, $GetSearchValue,$startCount,$count){
        $CuisineClass = new Cuisine($this->DataBaseCon);
        $RestartuantClass = new Restartuant($this->DataBaseCon);
        $CuisineComemnt = new CuisineComemnt($this -> DataBaseCon);
        $InitialLocationSelectClass=new InitialLocationSelect($this -> DataBaseCon);
        $GetResult = $CuisineClass->ReturnAllCuisineByLikeQuery($InitialLocationSelectClass->GetsRootLocalName($GetSearchLoaction),$GetSearchValue);//get all cuisines without second level
        $GetCuisine = $CuisineClass -> ReturnfinalCuisine($GetResult); //get all cuisine with second level
        $GetFinalCuisineAndResName = $RestartuantClass->ReturnResNameOfCuisine($GetCuisine);
        $GetIntergrateComments = $CuisineComemnt -> IntergrateCommentWithCuisine($GetFinalCuisineAndResName);
        $FinalResult=$this->returnLimitedRecord($GetIntergrateComments,$startCount,$count);
        return json_encode($FinalResult);

    }


    /**
     * Return restaurant result only
     * @param $GetSearchValue
     * @param $startCount
     * @param $count
     *
     * @return string
     */
    private function RestaurantSearchOnly($GetSearchLoaction, $GetSearchValue,$startCount,$count){
        $RestartuantClass = new Restartuant($this->DataBaseCon);
        $CuisineComemnt = new CuisineComemnt($this -> DataBaseCon);
        $InitialLocationSelectClass=new InitialLocationSelect($this -> DataBaseCon);
        $GetAllRes = $RestartuantClass->FetchResFilter($InitialLocationSelectClass->GetsRootLocalName($GetSearchLoaction),$GetSearchValue);//get all restaurant that corresponds to query condition
        $GetAllResWithComment = $CuisineComemnt -> IntergrateCommentWithRestaruant($GetAllRes);
        $FinalResult=$this->returnLimitedRecord($GetAllResWithComment,$startCount,$count);
        return json_encode($FinalResult);
    }


    /**
     * Return Tages search only
     * @param $GetSearchValue
     * @param $startCount
     * @param $count
     */
    private function TagesSearchOnly($GetSearchLoaction,$GetSearchValue,$startCount,$count){
        $CuisineClass=new Cuisine($this->DataBaseCon);
        $RestartuantClass=new Restartuant($this->DataBaseCon);
        $CuisineComemnt = new CuisineComemnt($this -> DataBaseCon);
        $InitialLocationSelectClass=new InitialLocationSelect($this -> DataBaseCon);

        $GetAllRes = $RestartuantClass->ReturnResLocation($InitialLocationSelectClass->GetsRootLocalName($GetSearchLoaction));//get all restaurant that corresponds to query condition
        $GetAllResWithComment = $CuisineComemnt -> IntergrateCommentWithRestaruant($GetAllRes);
        $GetResult=$CuisineClass->ReturnCuisineAccordingToRes($GetAllResWithComment);
        $GetIntergrateComments = $CuisineComemnt -> IntergrateCommentWithCuisine($GetResult);
        $returndata = $this -> TagesCompared ($GetIntergrateComments,$GetSearchValue);
        $FinalResult=$this->returnLimitedRecord($returndata,$startCount,$count);
        return json_encode($FinalResult);
    }

    /**
     *
     */
    private function TagesCompared($array,$GetSearchValue){
       $temp = [];
        foreach ($array as $key => $subArray){
            foreach ($subArray as $subkey => $subArrayvalue){
                if($subkey === 'AvailabilityTags'){
                    foreach ($subArrayvalue as $value){
                        if (strtoupper($GetSearchValue) === strtoupper($value)){
                            array_push($temp,$subArray);
                        }
                    }
                }

                if($subkey === 'CuisineTags'){
                    foreach ($subArrayvalue as $value){
                        if (strtoupper($GetSearchValue) === strtoupper($value)){
                            array_push($temp,$subArray);
                        }
                    }
                }
                if($subkey === 'TypeTags'){
                    foreach ($subArrayvalue as $value){
                        if (strtoupper($GetSearchValue) === strtoupper($value)){
                            array_push($temp,$subArray);
                        }
                    }
                }
                if($subkey === 'PriceTags'){
                    foreach ($subArrayvalue as $value){
                        if (strtoupper($GetSearchValue) === strtoupper($value)){
                            array_push($temp,$subArray);
                        }
                    }
                }

            }
        }
        return $temp;
    }

    /**
     * @param $GetCuisineID
     * @return array
     */
    private function LoopCuisineID($GetCuisineID){
        $favouriteCuisine=[];
        $CuisineClass=new Cuisine($this->DataBaseCon);
        foreach ($GetCuisineID as $value){
            array_push($favouriteCuisine,$CuisineClass->ReturnCuisinestuff($value));
        }
        return $favouriteCuisine;

    }

    /**
     * @param $Tmp
     * @param $array
     *
     * @return bool
     */
    private function doubleDeepCompare($Tmp,$array){
        if(count($array)>0){
            foreach ($array as $value){
                if(in_array($value,$Tmp)){
                        return true;
                }
            }
            return false;
        }
        else{
            return true;
        }
}

    /**
     * @param $TmpAvailabilityTags
     * @param $AvailabilityTagsArray
     * @param $TmpCuisineTags
     * @param $CuisineTagsArray
     * @param $TmpTypeTags
     * @param $TypeTagsArray
     * @param $TmpPriceTags
     * @param $PriceTagsArray
     *
     * @return bool
     */
    private function deepCompare($TmpAvailabilityTags,$AvailabilityTagsArray,$TmpCuisineTags,$CuisineTagsArray,$TmpTypeTags,$TypeTagsArray,$TmpPriceTags,$PriceTagsArray){
        //default 'OR' relationship is false; (same tags)
        $OrRs_Availability=false;
        $OrRs_Cuisine=false;
        $OrRs_Type=false;
        $OrRs_Price=false;

        //or relationship in availability

        $OrRs_Availability = $this->doubleDeepCompare($TmpAvailabilityTags,$AvailabilityTagsArray);
        $OrRs_Cuisine = $this->doubleDeepCompare($TmpCuisineTags,$CuisineTagsArray);
        $OrRs_Type = $this->doubleDeepCompare($TmpTypeTags,$TypeTagsArray);
        $OrRs_Price = $this->doubleDeepCompare($TmpPriceTags,$PriceTagsArray);
        if($OrRs_Availability && $OrRs_Cuisine && $OrRs_Type && $OrRs_Price){
            return true;
        }
        else{
            return false;
        }



    }

    /**
     * @param $AvailabilityTagsArray
     * @param $CuisineTagsArray
     * @param $TypeTagsArray
     * @param $PriceTagsArray
     * @param $subArray
     *
     * @return bool
     */
    private function foreachComparedTages($AvailabilityTagsArray,$CuisineTagsArray,$TypeTagsArray,$PriceTagsArray,$subArray){
        $TmpAvailabilityTags = [];
        $TmpCuisineTags = [];
        $TmpTypeTags = [];
        $TmpPriceTags = [];
        foreach ($subArray as $key=>$value){
            if($key==='AvailabilityTags'){
                $TmpAvailabilityTags = $value;
            }
            if($key==='CuisineTags'){
                $TmpCuisineTags = $value;
            }
            if($key==='TypeTags'){
                $TmpTypeTags = $value;
            }
            if($key==='PriceTags'){
                $TmpPriceTags = $value;
            }
        }

        return $this->deepCompare($TmpAvailabilityTags,$AvailabilityTagsArray,$TmpCuisineTags,$CuisineTagsArray,$TmpTypeTags,$TypeTagsArray,$TmpPriceTags,$PriceTagsArray);


    }

    /**
     * @param $AvailabilityTagsArray
     * @param $CuisineTagsArray
     * @param $TypeTagsArray
     * @param $PriceTagsArray
     * @param $ReturnedArray
     *
     * @return array
     */

    private function filtertags($AvailabilityTagsArray,$CuisineTagsArray,$TypeTagsArray,$PriceTagsArray,$ReturnedArray){
        if(count($AvailabilityTagsArray)>0 || count($CuisineTagsArray)>0 || count($TypeTagsArray)>0 || count($PriceTagsArray)>0){
            $newArray=[];
            foreach ($ReturnedArray as $key=>$subArray){
                    if($this->foreachComparedTages($AvailabilityTagsArray,$CuisineTagsArray,$TypeTagsArray,$PriceTagsArray,$subArray)){
                        array_push($newArray,$subArray);
                }
            }
            return $newArray;
        }
        else{
            return $ReturnedArray;
        }


    }


    /**
     * @param $array
     * @param $startCount
     * @param $limit
     *
     * @return array
     */
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