<?php require_once '../../header.php'?>
<?php session_start(); if(isset($_GET['CustomerID'])&&isset($_SESSION['LoginedUserID'])):?>
<script src="<?php echo GlobalPath;?>/cms/customer-Management/Customer.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo GlobalPath;?>/CMS/customer-Management/style.css" />
<div class="container-fluid Customer-margin">
    <div class="row-fluid">
        <div class="span3">
            <div class="span3 well sidebar-nav" data-spy="affix">
                <ul class="nav nav-list">
                    <li class="nav-header"><a href="#MyOrder" data-toggle="tab">My Order</a></li>
                    <li class="nav-header"><a href="#MyFaveourites" data-toggle="tab">My Faveourites</a></li>
                    <li class="nav-header"><a href="#MyAddressBook" data-toggle="tab">My Address Book</a></li>
                    <li class="nav-header"><a href="#MyRewardPoints" data-toggle="tab"> My Reward Points</a></li>
                    <li class="nav-header"><a href="#MyPrpfile" data-toggle="tab"> My Profile</a></li>        
                </ul>
            </div><!--/.well -->
        </div><!--/span-->
        <div class="span9 rightContent">
            <div class="tab-content">
                <div class="tab-pane active" id="MyOrder">
                    <p>This area displays My order</p>
                </div>

                <div class="tab-pane" id="MyFaveourites">
                    <p>This area displays My MyFaveourites</p>
                </div>
                <div class="tab-pane" id="MyAddressBook">
                    <ul class="nav nav-pills">

                        <li>
                            <address>
                                <strong>Twitter, Inc.</strong><br>
                                795 Folsom Ave, Suite 600<br>
                                San Francisco, CA 94107<br>
                                <abbr title="Phone">P:</abbr> (123) 456-7890
                            </address>
                            <label class="radio">
                                <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked>
                               Default Address
                            </label>
                        </li>
                        <li>
                            <address>
                                <strong>Twitter, Inc.</strong><br>
                                795 Folsom Ave, Suite 600<br>
                                San Francisco, CA 94107<br>
                                <abbr title="Phone">P:</abbr> (123) 456-7890
                            </address>
                            <label class="radio">
                                <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2" >
                                Default Address
                            </label>
                        </li>

                        <li>
                            <address>
                                <strong>Twitter, Inc.</strong><br>
                                795 Folsom Ave, Suite 600<br>
                                San Francisco, CA 94107<br>
                                <abbr title="Phone">P:</abbr> (123) 456-7890
                            </address>
                            <label class="radio">
                                <input type="radio" name="optionsRadios" id="optionsRadios3" value="option3" >
                                Default Address
                            </label>
                        </li>
                        <li>
                            <address>
                                <strong>Twitter, Inc.</strong><br>
                                795 Folsom Ave, Suite 600<br>
                                San Francisco, CA 94107<br>
                                <abbr title="Phone">P:</abbr> (123) 456-7890
                            </address>
                            <label class="radio">
                                <input type="radio" name="optionsRadios" id="optionsRadios4" value="option4" >
                                Default Address
                            </label>
                        </li>


                    </ul>

                </div>
                <div class="tab-pane " id="MyRewardPoints">
                    <p>This area displays My MyRewardPoints</p>
                </div>
                <!--My Profile start-->
                <div class="tab-pane" id="MyPrpfile">
				<div class="row-fluid">


				<div class="span12 text-center">
				<h4 class="text-left">Basic Profile Setting</h4>
				<div class="form-horizontal">
				<!--Customer ID-->
				<div class="control-group">
				    <label class="control-label">Customer ID:</label>
				    <div class="controls text-left">
				      <input type="text" class="span8" id="CustomerID" disabled value="<?php echo $_SESSION['LoginedUserID'];?>">
				    </div>
				  </div>
				<!--Customer Name-->
				<div class="control-group">
				    <label class="control-label">Full Name:</label>
				    <div class="controls text-left">
				      <input type="text" class="span8" id="CustomerName" value="<?php echo $LoginedInClass->GetUsersLoginInfo($_SESSION['LoginedUserID'])->UserName?>" placeholder="Please input your Full Name">
				    </div>
				  </div>  
				 <!--Customer First Name-->
				 <div class="control-group">
				     <label class="control-label">First Name:</label>
				     <div class="controls text-left">
				       <input type="text" class="span8" id="CustomerFirstName" value="<?php echo $LoginedInClass->GetUsersLoginInfo($_SESSION['LoginedUserID'])->UserFirstName;?>" placeholder="Please input your First Name">
				     </div>
				   </div>
				   
				   <!--Customer Last Name-->
				   <div class="control-group">
				       <label class="control-label">Last Name:</label>
				       <div class="controls text-left">
				         <input type="text" class="span8" id="CustomerLastName" value="<?php echo $LoginedInClass->GetUsersLoginInfo($_SESSION['LoginedUserID'])->UserLastName?>" placeholder="Please input your Last Name">
				       </div>
				     </div>
				   
				   <!--Customer Phone-->
				   <div class="control-group">
				       <label class="control-label">Phone:</label>
				       <div class="controls text-left">
				         <input type="text" class="span8" id="CustomerPhone" value="<?php echo $LoginedInClass->GetUsersLoginInfo($_SESSION['LoginedUserID'])->UserPhone?>" placeholder="Please input your phone here">
				         
				       </div>
				     </div>

                    <!--Customer Mail-->
                    <div class="control-group warning">
                        <label class="control-label">Mail:</label>
                        <div class="controls text-left">
                            <?php if($LoginedInClass->GetUsersLoginInfo($_SESSION['LoginedUserID'])->UserType==='Facebook'):?>
                            <input type="text" class="span8" id="CustomerMail" value="<?php echo $LoginedInClass->GetUsersLoginInfo($_SESSION['LoginedUserID'])->UserMail?>" disabled>
                            <?php else:?>
                            <input type="text" class="span8" id="CustomerMail" value="<?php echo $LoginedInClass->GetUsersLoginInfo($_SESSION['LoginedUserID'])->UserMail?>" placeholder="Please your new mail for login">
                            <span class="help-inline">Be careful: you may change your login mail address</span>
                            <?php endif?>
                        </div>
                    </div>

                    <!--Customer Address-->
                    <div class="control-group">
                        <label class="control-label">Address(not for delivery):</label>
                        <div class="controls text-left">
                            <input type="text" class="span8" id="CustomerPhone" value="<?php echo $LoginedInClass->GetUsersLoginInfo($_SESSION['LoginedUserID'])->UserPhone?>" placeholder="Please input your address here">

                        </div>
                    </div>

				   </div>

                    <div class="control-group text-left">
                        <div class="controls">
                            <button id="BasicCustomerButton" class="button" type="button">Update</button>
                        </div>
                    </div>
                </div>

                    <div class="row-fluid">
                        <div class="span12"></div>
                    </div>
                    <hr>
                    <?php if($LoginedInClass->GetUsersLoginInfo($_SESSION['LoginedUserID'])->UserType!=='Facebook'):?>
                    <!-----------------------------------------------customer password change---------------------------->
                    <div class="row-fluid">
                    <div class="span12 text-center">
                        <h4 class="text-left">Password Changing</h4>
                        <div class="form-horizontal">
                            <!--Customer Address-->
                            <div class="control-group warning">
                                <label class="control-label">Old Password:</label>
                                <div class="controls text-left">
                                    <input type="password" class="span8" id="Old_Password" placeholder="Please input your old password">
                                </div>
                            </div>

                            <div class="control-group warning">
                                <label class="control-label">New Password:</label>
                                <div class="controls text-left">
                                    <input type="password" class="span8" id="New_password" placeholder="Please input your New password">
                                </div>
                            </div>
                        </div>
                        <div class="control-group text-left">
                            <div class="controls">
                                <button id="ChangePasswordButton" class="button" type="button">Change</button>
                            </div>
                        </div>
                        </div>
                    </div>


                        <hr>
                    <div class="row-fluid">
                        <div class="span12"></div>
                    </div>
                   <?php endif?>
            <?php if($LoginedInClass->GetUsersLoginInfo($_SESSION['LoginedUserID'])->UserType!=='Facebook'):?>
                    <!-------------------------------------upload customer avatar-------------------------------------------->
                    <div class="form-horizontal">
                    <h4>Upload your avatar</h4>
                    <div class="row-fluid">
                     <div class="span12">
                     <!--Customer Photo-->
                     <div class="control-group">
                         <label class="control-label">Photo:</label>
                         <div class="controls text-left">
                                 <input type="text" style="position:absolute" id="AdministratorImagePath" placeholder="Broswer file">
                                 <input type="hidden" id="gobalPath" value="<?php echo GlobalPath;?>">

                                 <form id="adminForm" method="POST" enctype="multipart/form-data">
                                     <input type="file" name="Input_Customeravatar" style="opacity:0; position:relative" id="Input_Customeravatar">
                                     <br>
                                     <button type="button" id="submitPic" class="btn">Upload</button>
                                 </form>
                                 <label class="alert alert-info">*The photo will be used on comment, only png, gif, jpg are accepted</label>
                         </div>
                         <button id="avatarButton" class="button" type="button">Upload</button>

                     </div>

                     </div>
                 </div>
                 </div>
           <?php endif?>


                </div>

				
				</div>


                </div>



            </div>
            <div class="bottonPng"></div>

        </div>

    </div><!--/row-->


</div><!--/.fluid-container-->

<?php else:?>
<?php require_once '../../Login-Logout/login-Error.php';?>
<?php endif?>

<?php require_once '../../footer.php'?>
