<?php include 'CMS/Gobal-define.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="An very basic example of how to use the Wookmark jQuery plug-in.">
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
      <a class="brand" href="<?php echo GlobalPath;?>/index.php" alt="home"><img src="<?php echo GlobalPath;?>/assets/framework/front-images/logo.png" /></a>
      <div class="nav-collapse collapse">

          <ul class="nav nav-pills headNav pull-right ">
              <li>
                  <div class="btn-group">
                      <button class="setUpFacebook radius" type="button"><i class="icon-facebook icon-white"></i> SignUp with Facebook</button>
                  </div>

              </li>
              <li>
                  <div class="btn-group">
                      <button  class="setUp radius" id="SignUp" type="button" data-toggle="modal" href="#static" >Sign Up
                      </button>
                  </div>
              </li>
              <li>
                  <div class="btn-group">
                      <button  class="dropdown-toggle setUp radius" type="button" data-toggle="dropdown">Sign In <i class="icon-sort-down icon-white"></i>
                      </button>
                      <ul class="dropdown-menu pull-right">

                          <form class="formOption">
                              <div class="control-group input-group">
                                  <div class="controls">
                                      <div class="input-prepend ">
                                          <span class="add-on"><i class="icon-envelope"></i></span>
                                          <input type="text" id="inputEmail" placeholder="Email">
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
                              <div  class="ForgetPassword"><label><a href="#"><h6>Forget Password?</h6></a></label></div>

                              <div class="input-prepend input-group">
                                  <div class="controls">
                                      <label class="checkbox checkboxSetting">
                                          <input type="checkbox"> Remember me
                                      </label>
                                  </div>
                              </div>

                              <div class="input-prepend input-group Go">

                                  <button type="submit" class="btn btn-success">Sign in</button>
                              </div>


                          </form>


                      </ul>
                  </div>

              </li>
          </ul>
      </div><!--/.nav-collapse -->
    </div>
  </div>
</div>

</header><!--header end-->