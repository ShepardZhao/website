<?php require_once '../../header.php'?>
<?php $InitialLocationSelectClass->hiddenInitialLocation();?>
<?php if(!empty($_GET['CustomerID'])&&!empty($_SESSION['LoginedUserID'])):?>
    <script src="<?php echo GlobalPath;?>/CMS/Commons-js/ajaxfileupload.js" type="text/javascript"></script>
    <script src="<?php echo GlobalPath;?>/CMS/customer-Management/Customer.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo GlobalPath;?>/CMS/customer-Management/style.css" />
    <div class="container-fluid Customer-margin">
        <div class="row-fluid">
            <!--sidebar--->
            <?php require_once 'SubPages/sidebar.php'?>
            <div class="span9 rightContent">
                <div class="tab-content">
                    <div class="tab-pane active" id="MyOrder">
                        <p>This area displays My order</p>
                    </div>

                    <div class="tab-pane" id="MyFaveourites">
                        <?php require_once 'SubPages/MyFavourite.php'?>
                    </div>
                    <div class="tab-pane" id="MyAddressBook">
                        <?php require_once 'SubPages/MyAddressBook.php'?>
                    </div>
                    <div class="tab-pane " id="MyRewardPoints">
                        <p>This area displays My MyRewardPoints</p>
                    </div>
                    <!--My Profile start-->
                    <div class="tab-pane" id="MyProfile">
                        <?php require_once 'SubPages/MyProfile.php'?>


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
