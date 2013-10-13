<?php require_once '../GobalConnection.php';session_start();if (isset($_SESSION['LoginedAdmministratorName']) && $_SESSION['LoginedAdmministratorName']===$UserClass->ReadAdministraorInfo()['UserName']){?>
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
    <!----------------------------------------sidebar part------------------------------------------------->
    <?php require_once 'SubPages/Sidebar.php'?>
    </div>
    <!-- End #sidebar -->
    <div class="span10" id="main-content">
    <?php require_once 'SubPages/initialpage.php'?>
    <!-----------------------------------------Restaurant&Cuisines Management------------------------------>
    <!-----------------------------------------Register Restaurant----------------------------------------->
    <?php require_once 'SubPages/Register_restaurant.php'?>
    <!--------------------------------------------------basic info----------------------------------------->
    <?php require_once 'SubPages/Basic_info.php'?>
    <!-----------------------------------------Admin Management-------------------------------------------->
    <?php require_once 'SubPages/Admin_Management.php'?>
    <!-----------------------------------------Location Management----------------------------------------->
    <!-- adds Location-->
    <?php require_once 'SubPages/adds_location.php'?>
    <!-----------------------------------------------User List--------------------------------------------->
    <?php require_once 'SubPages/User_list.php'?>
    <!---------------------------------------------Mail setting-------------------------------------------->
    <?php require_once 'SubPages/Mail_setting.php'?>
    <!-----------------------------------------------Tags Management--------------------------------------->
    <?php require_once 'SubPages/Tags_Management.php'?>
    </div>
    </div>
    <!-- End #main-content -->
    </div>
    </div>
    </div>
    </body>
    </html>
<?php } else {$LoginClass->ReLogin();}?>

















