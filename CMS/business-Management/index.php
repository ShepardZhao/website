<?php include '../../header.php'?>
<?php $InitialLocationSelectClass->hiddenInitialLocation();if (!empty($_GET['UID'])&&!empty($_GET['RestID'])):?>
    <?php
    //Basic User Info
    $UserAndRes=json_decode($UserClass->ValidSameUserIDInRestaurant(base64_decode($_GET['UID'])));
    //Basic Restaruant info
    $Res=json_decode($RestartuantClass->GetRestaruantWithParm(base64_decode($_GET['RestID'])));
    $ResOpenUnSer=json_decode($RestartuantClass->explodeTime(unserialize($Res[0]->ResOpenTime)));

    ?>
    <script src="<?php echo GlobalPath;?>/CMS/Commons-js/ajaxfileupload.js" type="text/javascript"></script>
    <script src="<?php echo GlobalPath;?>/CMS/Commons-js/jquery.timepicker.min.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo GlobalPath;?>/CMS/business-Management/Style.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo GlobalPath;?>/CMS/Commons-css/jquery.Jcrop.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo GlobalPath;?>/CMS/Commons-css/chosen.min.css" />
    <script type="text/javascript" src="<?php echo GlobalPath;?>/CMS/Commons-js/jquery.Jcrop.min.js"></script>
    <script src="<?php echo GlobalPath;?>/CMS/Commons-js/chosen.jquery.min.js" type="text/javascript"></script>
    <script src="<?php echo GlobalPath;?>/CMS/business-Management/business.js" type="text/javascript"></script>


    <!--hidden field to store the UID-->
    <input type="hidden" id="HidenUserID" value="<?php echo base64_decode($_GET['UID']);?>">
    <div class="container-fluid business-margin">
        <div class="row-fluid">
            <!--sidebar-->
            <?php require_once 'SubPages/Sidebar.php'?>
            <div class="span10 rightContent">
                <div class="tab-content">
                    <!--My restaurant-->
                    <div class="tab-pane active" id="Dishes">
                        <!--Dishes-->
                        <?php require_once 'SubPages/DishesPack/Dishes.php' ?>
                    </div>

                    <div class="tab-pane" id="Promotion">
                        <!--Promotion-->

                    </div>
                    <!--Orders-->
                    <div class="tab-pane" id="Order">
                        <!--Order-->
                    </div>

                    <div class="tab-pane" id="Review">
                        <!--Review-->
                    </div>

                    <div class="tab-pane" id="Statistics">
                        <!--Statistics-->


                    </div>

                    <div class="tab-pane" id="MyRestaurant">
                        <!--MyRestaurant-->
                        <?php require_once 'SubPages/MyRestaurantInfoEdit.php'?>

                    </div>

                    <div class="tab-pane" id="ContactUs">
                        <!--ContactUs-->
                        <?php require_once 'SubPages/ContactUs.php'?>
                    </div>

                    <div class="tab-pane" id="AccountManagement">
                        <!--Account Management-->
                        <?php require_once 'SubPages/AccountManagement.php'?>
                    </div>



                </div>
                <div class="bottonPng"></div>

            </div>

        </div><!--/row-->


    </div><!--/.fluid-container-->
<?php else:?>
    <?php require_once '../../Login-Logout/login-Error.php';?>
<?php endif ?>
<?php require_once '../../footer.php'?>

