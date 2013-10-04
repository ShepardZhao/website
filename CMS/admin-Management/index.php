<?php require_once '../GobalConnection.php';
session_start();
if (isset($_SESSION['LoginedAdmministratorName']) && $_SESSION['LoginedAdmministratorName']===$UserClass->ReadAdministraorInfo()['UserName']){


?>
<!DOCTYPE html>
<html>
<head>
    <meta charset=UTF-8" />
    <title>B2C-Administrator CMS</title>
    <!--below part is about ckeitor-->
    <!--other css and jquery links-->
    <link rel="stylesheet" href="ckeditor/sample.css" type="text/css" media="screen" />

    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo GlobalPath;?>/assets/framework/css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?php echo GlobalPath;?>/assets/framework/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="css/reset.css" type="text/css" media="screen" />
    <!-- Jquery CSS funtion-->
    <script src="<?php echo GlobalPath;?>/assets/framework/js/jquery-1.10.2.js"></script>
    <script src="<?php echo GlobalPath;?>/assets/framework/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="../Commons-js/ajaxfileupload.js" type="text/javascript"></script>
    <script src="js/CMS-AJAX.v1.0.js" type="text/javascript"></script>
    <script src="ckeditor/ckeditor.js" type="text/javascript"></script>



</head>
<body>
<div class="wrap">
    <div class="row-fluid">
        <div class="span2" id="sidebar">

                <div id="sidebar-wrapper">
                    <br>
                    <!-- Sidebar Profile links -->
                    <div id="profile-links">Hello, <?php echo $_SESSION['LoginedAdmministratorName'];?><br>Your login time is <?php echo  date("d-m-y H:i:s");?></a><br />
                        <a href="<?php echo GlobalPath;?>" title="Visit the WebSite">Visit The WebSite</a> | <a href="logoff.php" title="Logoff">Logo Off</a> </div>
                    <ul id="main-nav">
                        <!-- Accordion Menu -->
                        <li> <a class="nav-top-item">System Management</a>
                        <ul class="Nav-list">
                         <li id="BasicInfo-clicked"><a title="Basic Info Management" >Basic Info Management</a></li>
                        </li>
                    </ul>

                    <li> <a href="#" class="nav-top-item ">
                            <!-- Add the class "current" to current menu item -->
                            Location Management </a>
                        <ul class="Nav-list">
                            <li id="addsLocation-clicked"><a title="Added new location including level one and level two">Adds and Manages Location</a></li><!--Added location-->
                        </ul>
                    </li>

                    <li> <a href="#" class="nav-top-item ">
                            <!-- Add the class "current" to current menu item -->
                            Tags</a>
                        <ul class="Nav-list">
                            <li id="Tags-clicked"><a title="Manage And add tags">Tags Setting</a></li><!--Added&Manage Tags-->
                        </ul>
                    </li>


                    <li> <a href="#" class="nav-top-item ">
                            <!-- Add the class "current" to current menu item -->
                            Manage Restaurants&Cuisines </a>
                        <ul class="Nav-list">
                            <li id="Restaurants-clicked"><a title="Displayed All Restaurants">Restaurants List</a></li><!--Restaurants list that shows all restaurants that located at database-->
                            <li id="Cuisines-clicked"><a title="Displayed All Cuisine">Cuisines List</a></li><!--Restaurants list that shows all restaurants that located at database-->

                        </ul>
                    </li>



                    <li> <a href="#" class="nav-top-item">User Management </a>
                        <ul class="Nav-list">
                            <li><a id="Admin-clicked"  title="Change the password of Administraotr or other things">Administrator Management</a></li>
                            <li><a id="UserList-clicked" title="User List">User List</a></li><!--List all user by list-->
                        </ul>
                    </li>

                    <li> <a href="#" class="nav-top-item">Mail </a>
                        <ul class="Nav-list">
                            <li><a id="MailSetting-clicked"  title="Change the password of Administraotr or other things">Mail Setting</a></li>
                        </ul>
                    </li>


                    </ul>
                    <!-- End #main-nav -->

                </div>
        </div>

        <!-- End #sidebar -->
        <div class="span10" id="main-content">
              <div id="initialPage">
                <table class="table table-bordered">
                   <thead>
                   <tr class="thead">
                       <td><h4>System Info</h4></td>
                       <td></td>

                   </tr>
                   </thead>
                    <tbody>
                   <tr>
                       <td class="subHead">Web Url</td>
                       <td class="subtr"><?php echo GlobalPath;?></td>
                   </tr>
                    <tr>
                        <td class="subHead">Current Logined User</td>
                        <td ><?php  echo $_SESSION['LoginedAdmministratorName'];?></td>
                    </tr>
                    <tr>
                        <td class="subHead">System Status</td>
                        <td><?php echo $BasicSettingClass->pushSettingData()['WebStatus'];?></td>
                    </tr>
                    <tr>
                        <td class="subHead">Server Address</td>
                        <td><?php $BasicSystemInfoClass->_SysInformationDisply('SERVER_ADDR');?></td>
                    </tr>
                    <tr>
                        <td class="subHead">System Vsersion</td>
                        <td><?php $BasicSystemInfoClass->_SysInformationDisply('SERVER_NAME');?></td>
                    </tr>
                    <tr>
                        <td class="subHead">System Port</td>
                        <td><?php $BasicSystemInfoClass->_SysInformationDisply('SERVER_PORT');?></td>
                    </tr>
                    <tr>
                        <td class="subHead">System Time</td>
                        <td><?php $BasicSystemInfoClass->_SysTime();?></td>
                    </tr>
                    <tr>
                        <td class="subHead">Absolute Path</td>
                        <td><?php $BasicSystemInfoClass->_SysInformationDisply('DOCUMENT_ROOT');?></td>
                    </tr>
                    <tr>
                        <td class="subHead">Operate System</td>
                        <td><?php $BasicSystemInfoClass->_SysInformationDisply('SERVER_SOFTWARE');?></td>
                    </tr>

                    <tr>
                        <td class="subHead">Client IP</td>
                        <td><?php $BasicSystemInfoClass->_SysInformationDisply('REMOTE_ADDR');?></td>
                    </tr>

                    <tr>
                        <td class="subHead">Client Port</td>
                        <td><?php $BasicSystemInfoClass->_SysInformationDisply('REMOTE_PORT');?></td>
                    </tr>
                    </tbody>
                </table>
            </div>








<!--------------------------------------------------basic info------------------------------------------------->
             <div id="basicInfo">
                 <div class="row-fluid">
                 <div class="span12">
                <div class="divhead"><h4><i class="icon-list-ul">  Basic System Management</i><h4></div>
                    <div class="basicInfo-box">
                        <div class="form-horizontal">

                         <div class="control-group">
                             <label class="control-label" >The Name Of website:</label>
                             <div class="controls">
                                 <input type="text"  class="inputBg" id="SiteName" value="<?php echo $BasicSettingClass->pushSettingData()['WebTitle'];?>">
                             </div>
                         </div>



                             <div class="control-group">
                                 <label class="control-label">The Description of WebSite:</label>
                                 <div class="controls">
                                     <textarea rows="3" id="SiteDescr"><?php echo $BasicSettingClass->pushSettingData()['WebDescription'];?></textarea>
                                 </div>
                             </div>


                                 <div class="control-group">
                                     <label class="control-label">Site Url:</label>
                                     <div class="controls">
                                         <input type="text" id="SiteUrl" value="<?php echo $BasicSettingClass->pushSettingData()['WebUrl'];?>">
                                     </div>
                                 </div>

                            <div class="control-group">
                                <label class="control-label">Email:</label>
                                <div class="controls">
                                    <input type="text" id="SiteEmail" value="<?php echo $BasicSettingClass->pushSettingData()['EMail'];?>">
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">Policy:</label>
                                <div class="controls">
                                    <textarea class="span12" style="height:100px" id="SitePolicy"><?php echo $BasicSettingClass->pushSettingData()['WebPolicy'];?></textarea>
                                </div>
                            </div>



                                 <div class="control-group">
                                     <label class="control-label">SiteStatus:</label>
                                     <div class="controls">
                                         <select id="SiteStatus" class="span2 inputBg">
                                             <option>Running</option>
                                             <option>Stop</option>
                                         </select>
                                     </div>
                                 </div>
                                 <button id="BasicInforSaving" class="button" type="button">Save</button>
                          </div>



                    </div>
                 </div>

                 </div>

             </div>

<!-----------------------------------------Admin Management------------------------------------------>

    <div id="adminMangement">
            <div class="row-fluid">
                <div class="span12">
                    <div class="divhead"><h4><i class="icon-list-ul">  Administrator Management</i><h4></div>
                <div class="basicInfo-box">
                    <div class="form-horizontal">
                        <div class="control-group">
                            <label class="control-label">Administrator ID:</label>
                            <div class="controls">
                                <input type="text" id="Input_AdministratorID" disabled value='<?php  echo $UserClass->ReadAdministraorInfo()['UserID'];?>' >
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Administrator Name:</label>
                            <div class="controls">
                                <input type="text" id="Input_Administrator" value='<?php  echo $UserClass->ReadAdministraorInfo()['UserName'];?>'>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Administrator Password:</label>
                            <div class="controls">
                                <input type="password" id="inputPassword" placeholder="Please input new password here">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Administrator Email:</label>
                            <div class="controls">
                                <input type="text" id="Input_AdministratorEmail" value="<?php echo $BasicSettingClass->pushSettingData()['EMail'];?>" disabled>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Administrator Phone:</label>
                            <div class="controls">
                                <input type="text" id="Input_AdministratorPhone" placeholder="Please input administrator's phone">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">User Type:</label>
                            <div class="controls">
                                <input type="text" id="Input_FixedAdministratorType" Value="Administrator" disabled>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Please upload Administrator's photo</label>
                            <div class="controls">
                                <input type="text" style="position:absolute" id="AdministratorImagePath" placeholder="Broswer file">
                                <input type="hidden" id="gobalPath" value="<?php echo GlobalPath;?>">

                                <form id="adminForm" method="POST" enctype="multipart/form-data">
                                <input type="file" name="Input_AdministratorPhoto" style="opacity:0; position:relative" id="Input_AdministratorPhoto">
                                <br>
                                 <button type="button" id="submitPic" class="btn">Upload</button>
                                </form>
                                <label>*The photo will be used on comment, only png, gif, jpg are accepted</label>
                            </div>
                        </div>

                        <button id="SubmitAdministratorInfo" class="button" type="button">Submit</button>

                    </div>

                </div>
                </div>

    </div>
        </div>
<!-----------------------------------------Location Management------------------------------------------>
     <!-- adds Location-->
  <div id="addsLocation">
      <div class="row-fluid">
          <div class="span12">
              <div class="divhead"><h4><i class="icon-list-ul">  Please Added Location below</i><h4></div>
              <div class="basicInfo-box">
                  <div class="form-horizontal">
                      <div class="control-group">
                          <label class="control-label" >Please Input Root Location:</label>
                          <div class="controls">
                              <input type="text"  id="RootLocation" class="input-xlarge" name="RootLocation" placeholder="i.e: Sydney Hospital">
                              <input type="text"  id="RootLocationID" class="input" name="RootLocationID" placeholder="RR:The Root Location ID">

                          </div>
                          <br>
                          <button id="AddMoreSubLocation" class="button" type="button">More</button>
                      </div>

                      <div class="alert alertFont">
                          <button type="button" class="close" data-dismiss="alert">&times;</button>
                          <strong>Notes:</strong> Add Root Location first, then You may be able to add second level of location below
                      </div>

                          <div id="MarkRootLocation" class="control-group">
                              <label class="control-label">Sub Location:</label>
                              <div class="controls">
                                  <input type="text" class="input-xlarge" name="SubLocation[]" placeholder="i.e: one of sub levels of locations" >
                                  <input type="text" class="input" name="SubLocationID[]" placeholder="XX: The sub location ID" >

                              </div>
                          </div>
                          </div>

                          <button id="AddLocationButton" class="button" type="button">Add</button>


                  </div>

              </div>
          </div>
          <div class="row-fluid">
              <div class="span12"></div>
                <div id="LocationlistTable">
                   <?php $LocationClass->CmsDisplay();?><!--Locaiton Class that displays the all location from the database-->
                </div>

           </div>


      </div>



<!-----------------------------------------------User List---------------------------------------------------->
              <div id="UserList">
              <div class="row-fluid">
                 <div class="span12">
                     <div class="divhead"><h4><i class="icon-list-ul"> User List</i><h4></div>
                     <div class="basicInfo-box">

                     <table class="table table-striped" id="UserTableList" >
                         <thead>
                         <tr>
                             <th>User Pic</th>
                             <th>User ID</th>
                             <th>User Name</th>
                             <th>User phone</th>
                             <th>User Mail</th>
                             <th>user Points</th>
                             <th>User Type</th>
                             <th>Delete</th>
                         </tr>
                         </thead>
                         <tbody>
                         <tr>
                             <td>id</td>
                             <td>Mark</td>
                             <td>Otto</td>
                             <td>@mdo</td>
                             <td>Mark</td>
                             <td>Otto</td>
                             <td>@mdo</td>
                             <td> <input type="checkbox" class='checkboxclass' value="">
                             </td>
                         </tr>

                         </tbody>
                     </table>

                </div>
                 </div>
              </div>
              </div>



              <!---------------------------Mail setting--------------------------->
              <div id="Mail_Setting">
                  <div class="row-fluid">
                      <div class="span12">
                          <div class="divhead"><h4><i class="icon-list-ul">  The construct of User's valid Email</i><h4></div>
                          <div class="basicInfo-box">
                              <input class="input-xlarge" id='ConstructOfActiveMail' type="text" disabled value="<?php echo $BasicSettingClass->pushSettingData()['EMail'];?>">
                              <input class="input-xxlarge" id='TitleOfConstructOfActiveMail' type="text" value="<?php echo $MailsettingClass->GetMailContentViaParam('ActivactionMail')['UserMailTitle'];?>" placeholder="Please put title here (i.e: Please Click below link to complete activation)">
                              <br>
                              <textarea class="ckeditor" cols="80" id="ConstructOfActiveMailContent" name="ConstructOfActiveMailContent" rows="10"><?php echo $MailsettingClass->GetMailContentViaParam('ActivactionMail')['UserMailConstructer'];?></textarea>
                              <script>
                                  CKEDITOR.replace('ConstructOfActiveMailContent');//active the Ckeditor plugs via element
                              </script>
                              <br>
                              <div class="alert alertFont">This part only build the construction of User's Mail that works on when user completed registertion and needed mail to valid</div>
                              <button id="ConstructOfActiveMailButton" class="button" type="button">Submit</button>

                          </div>
                      </div>
                  </div>
              </div>






              <!-----------------------------------------------Tags Management---------------------------------------------------->
             <div id="TagsManagement">
                     <div class="row-fluid">
                         <div class="span12">
          <!---------------------------Restaurants's tag---------------------->
                             <div class="divhead"><h4><i class="icon-list-ul">  Restaurants's Tags Setting</i><h4></div>
                             <div class="basicInfo-box">
                                 <div class="row-fluid">
                                        <div class="span5 offset1">

                                            <div class="input-prepend">
                                                <span class="add-on">Availability</span>
                                                <input class="span7" id="InputResAvailability" type="text" placeholder="New Availability">

                                            </div>
                                            <div id="RestaurantAvailabilityTagsList">
                                            <?php $TagsClass->outPutRestaurantTags("Availability","B2C.RestaurantTags");?>
                                            </div>
                                            <br>
                                            <button id="AddResAvailabilityButton" class="button" type="button">Add</button>
                                            <button id="RemoveResAvailabilityButton" class="button" type="button">Reomve</button>

                                        </div>


                                     <div class="span5 offset1">
                                         <div class="input-prepend">
                                             <span class="add-on">Cuisine</span>
                                             <input class="span9" id="InputResCuisine" type="text" placeholder="New Cuisine">

                                         </div>
                                         <div id="RestaurantCuisineTagsList">
                                         <?php $TagsClass->outPutRestaurantTags("Cuisine","B2C.RestaurantTags");?>
                                         </div>
                                         <br>
                                         <button id="AddResCuisineButton" class="button" type="button">Add</button>
                                         <button id="RemoveResCuisineButton" class="button" type="button">Remove</button>

                                     </div>

                                 </div>
                             </div>
                         </div>

            <!---------------------------Cuisine tags--------------------------->
                         <div id="display_info" class="row-fluid"><div class="span12"></div></div>
                         <div class="row-fluid">
                         <div class="span12">
                             <div class="divhead"><h4><i class="icon-list-ul">  Cuisine's Tags Setting</i><h4></div>
                             <div class="basicInfo-box">
                                 <div class="row-fluid">
                                     <div class="span5 offset1">

                                         <div class="input-prepend">
                                             <span class="add-on">Availability</span>
                                             <input class="span7" id="InputCuisAvailability" type="text" placeholder="New Availabilty">

                                         </div>
                                         <div id="CuisineAvailabilityTagsList">
                                         <?php $TagsClass->outPutRestaurantTags("Availability","B2C.CuisineTags");?>
                                         </div>
                                         <br>
                                         <button id="AddCuisAvailabilityButton" class="button" type="button">Add</button>
                                         <button id="RemoveCuisAvailabilityButton" class="button" type="button">Reomve</button>

                                     </div>


                                     <div class="span5 offset1">
                                         <div class="input-prepend">
                                             <span class="add-on">Cuisine</span>
                                             <input class="span9" id="InputCuisCuisine" type="text" placeholder="New Cuisine">

                                         </div>
                                         <div id="CuisineCuisineTagsList">
                                         <?php $TagsClass->outPutRestaurantTags("Cuisine","B2C.CuisineTags");?>
                                         </div>
                                         <br>
                                         <button id="AddCuisCuisineButton" class="button" type="button">Add</button>
                                         <button id="RemoveCuisCuisineButton" class="button" type="button">Remove</button>

                                     </div>
                                     <div class="row-fluid"><div class="span12"></div></div>

                                    <div class="row-fluid">
                                     <div class="span5 offset1">
                                         <div class="input-prepend">
                                             <span class="add-on">Type</span>
                                             <input class="span9" id="InputCuisType" type="text" placeholder="New Type">

                                         </div>
                                         <div id="CuisineTypeTagsList">
                                         <?php $TagsClass->outPutRestaurantTags("Type","B2C.CuisineTags");?>
                                         </div>
                                         <br>
                                         <button id="AddCuisTypeButton" class="button" type="button">Add</button>
                                         <button id="RemoveCuisTypeButton" class="button" type="button">Remove</button>

                                     </div>

                                        <div class="span5 offset1">
                                            <div class="input-prepend">
                                                <span class="add-on">Price</span>
                                                <input class="span9" id="InputCuisPirce" type="text" placeholder="New Price">

                                            </div>
                                            <div id="CuisinePriceTagsList">
                                            <?php $TagsClass->outPutRestaurantTags("Price","B2C.CuisineTags");?>
                                            </div>
                                            <br>
                                            <button id="AddCuisPriceButton" class="button" type="button">Add</button>
                                            <button id="RemoveCuisPriceButton" class="button" type="button">Remove</button>

                                        </div>


                                    </div>





                                 </div>
                              </div>

                         </div>

                         </div>

                         </div>

             </div>

<!------------------------------------------------------------------------------------------------------------------>

        </div>
        <!-- End #main-content -->


         </div>

    </div>

</div>













</body>


</html>


<?php
}
else {
    $LoginClass->ReLogin();
}
?>

















