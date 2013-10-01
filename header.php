<?php require_once 'CMS/GobalConnection.php'; ?>
<!--facebook connection-->
<?php
session_start();
$facebook = new Facebook(array(
    'appId'  => '422446111188481',
    'secret' => '2bd1f1a4a93855a30c661f52b39a01c9',
));

// See if there is a user from a cookie
$user = $facebook->getUser();

if ($user) {
    try {
        // Proceed knowing you have a logged in user who's authenticated.
        $user_profile = $facebook->api('/me');
        $logoutUrl = $facebook->getLogoutUrl();

        if($RegisterUserClass->MatchUserFacebookID($user_profile['id'])===1){
            $LoginedInClass->FacebookLogininWithSession($user_profile['id'],$user_profile['name']);
        }else{$RegisterUserClass->DirectlyRegisterFacebook($user_profile['id'],$user_profile['name'],$user_profile['first_name'],$user_profile['last_name'],$user_profile['email'],$userPhoto,1,'Facebook');}
        //saving facebook user's info into database
    } catch (FacebookApiException $e) {
        $user = null;
    }
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo $BasicSettingClass->pushSettingData()['WebDescription'];?>">
    <!--above needs to be changed-->
    <title></title>
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo GlobalPath;?>/assets/framework/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo GlobalPath;?>/assets/framework/css/customer.v1.0.css" />
    <link rel="stylesheet" media="screen and (max-width: 500px)" href="<?php echo GlobalPath;?>/assets/framework/css/mobile.css" type="text/css" /><!--mobile css-->
    <link rel="stylesheet" href="<?php echo GlobalPath;?>/assets/framework/css/font-awesome.min.css">
    <!-- include jQuery -->
    <script src="<?php echo GlobalPath;?>/assets/framework/js/jquery-1.10.2.js"></script>
    <script src="<?php echo GlobalPath;?>/assets/framework/js/bootstrap.min.js" type="text/javascript"></script>



</head>
<body>
<header><!--header begin-->
<div class="navbar navbar-fixed-top ">
  <div class="header">
    <div class="container-fluid">
      <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class=" brand" href="<?php echo GlobalPath;?>/index.php" alt="home"><img src="<?php echo GlobalPath;?>/assets/framework/front-images/logo.png" /></a>
      <div class="nav-collapse collapse">

              <?php if ( !isset($_SESSION['LoginedUserID'])):?>
          <ul class="nav nav-pills headNav pull-right ">

          <li>
                  <div class="btn-group">

                     <button onclick="fb_login()" class="setUpFacebook radius"  type="button" id="FacebookLogin" ><i class="icon-facebook icon-white"></i> SignUp with Facebook</button>

                  </div>

              </li>
              <li>
                  <div class="btn-group">
                      <button  class="setUp radius" id="SignUp" type="button" data-toggle="modal"  >Sign Up
                      </button>
                  </div>
              </li>
              <li>
                  <div class="btn-group">
                      <button  class="dropdown-toggle setUp radius" type="button" data-toggle="dropdown">Sign In <i class="icon-sort-down icon-white"></i>
                      </button>
                      <ul class="dropdown-menu pull-right">
                            <div id="login-area">
                              <div class="control-group input-group">
                                  <div class="controls">
                                      <div class="input-prepend ">
                                          <span class="add-on"><i class="icon-envelope"></i></span>
                                          <input type="email" id="inputEmail" placeholder="Email">
                                      </div>
                                  </div>
                              </div>
                              <div class="control-group input-group">
                                  <div class="controls">
                                      <div class="input-prepend ">
                                          <span class="add-on"><i class="icon-lock"></i></span>
                                          <input type="password" id="inputPassword" placeholder="Password">
                                      </div>
                                  </div>
                              </div>
                              <div  class="ForgetPassword" data-toggle="modal"><label><h6>Forget Password?</h6></label></div>

                            <div id="infoHead">
                            <div class="input-prepend input-group">
                                  <div class="controls">
                                      <label class="checkbox checkboxSetting">
                                          <input type="checkbox"> Remember me
                                      </label>
                                  </div>
                              </div>

                              <div class="input-prepend input-group Go">

                                  <button type="button" id="loginedInButton">Sign in</button>
                              </div>
                            </div>



                </div>
                      </ul>
                  </div>

              </li>
          </ul>

              <?php elseif(isset($_SESSION['LoginedUserID'])): ?>
          <ul class="nav nav-pills headNav pull-left">
                 <li><div class="btn-group"><div id="search"><input type="text" class="searchItem"  data-provide="typeahead" placeholder="Search Items......." ><img id="searchImg" width=40 height=40 src="<?php echo GlobalPath?>/assets/framework/front-images/search.png "></div> </div></li>
               </ul>
        </div>

                  <ul class="nav nav-pills headNav pull-right">

          <li>
                            <div class="btn-group">
                                <img width=40 height=40 src="<?php echo $_SESSION['LoginedUserPhoto'];?>">
                                <button class="LoginedIn radius dropdown-toggle" data-toggle="dropdown"><?php echo $_SESSION['LoginedUserName'];?> <span class="icon-sort-down icon-white"></span></button>
                                <ul class="dropdown-menu pull-right">
                                    <li><a href="<?php echo GlobalPath;?>/cms/customer-Management/#MyOrder">My Order</a></li>
                                    <li><a href="<?php echo GlobalPath;?>/cms/customer-Management/#MyFaveourites">My Favourites</a></li>
                                    <li><a href="<?php echo GlobalPath;?>/cms/customer-Management/#MyAddressBook">My Address Book</a></li>
                                    <li><a href="<?php echo GlobalPath;?>/cms/customer-Management/#MyAddressBook">My Reward Points</a></li>
                                    <li><a href="<?php echo GlobalPath;?>/cms/customer-Management/?id=<?php echo $_SESSION['LoginedUserID'];?>&#MyPrpfile">My Profile</a></li>

                                    <li class="divider"></li>
                                    <li><a href="<?php echo GlobalPath;?>/register/logoff.php" onclick="fb_logff();">Log Out</a></li>

                                </ul>
                            </div>



                   </li>
              </ul>
              <?php endif ?>
</div>
      </div><!--/.nav-collapse -->
    </div>
  </div>
</div>

</header><!--header end-->