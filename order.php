<?php include 'header.php'?>

<?php
    if (isset($_GET['RootID']) && isset($_GET['SubID'])){
        $InitialLocationSelectClass->hiddenInitialLocation();
        session_start();
        //according RootID and SubID to get their names
        $_SESSION['RootID']=$_GET['RootID'];
        $_SESSION['SubID']=$_GET['SubID'];
        $_SESSION['RootLocation']=$InitialLocationSelectClass->GetsRootLocalName($_GET['RootID']);
        $_SESSION['SubLocation']=$InitialLocationSelectClass->GetsSubLocalName($_GET['RootID'],$_GET['SubID']);
?>
    <input type="hidden" id="RootID" value="<?php echo $_GET['RootID']?>">
    <input type="hidden" id="SubID" value="<?php echo $_GET['SubID']?>">
    <input type="hidden" id="RootLocationName" value="<?php echo $_SESSION['RootLocation']?>">
    <input type="hidden" id="SubLocationName" value="<?php echo $_SESSION['SubLocation']?>">
    <input type="hidden" id="CurrentLoginedUserID" value="<?php echo $_SESSION['LoginedUserID']?>">

 <!--Ad zone-->
 <?php require_once 'AdZone.php'?>
 <!--order zone-->
<div class="container-fluid" id="ScrollTopPosition">

<div class="row-fluid">
    <section>
    <div class="span9 tabzone hidden-phone	">
        <div class="tabbable"> <!-- Only required for left/right tabs -->
            <ul class="nav nav-tabs tabMain">
                <li class="active"><a href="order?RootID=<?php echo $_GET['RootID']?>&SubID=<?php echo $_GET['SubID']?>">Featured</a></li>
                <li><a href="#Restaurants" data-toggle="tab" id="Restaurants-tab">Restaurants</a></li>
                <li><a href="#Dishes" data-toggle="tab" id="Dishes-tab">Dishes</a></li>
            </ul>
            <div class="tab-content tabContent"><!--tab selection-->
                <div class="tab-pane fade in active">
                    <?php include 'Feathured.php'?>
                </div>
                <div class="tab-pane fade" id="Restaurants">
                    <?php include 'Restaurants.php'?>
                </div>
                <div class="tab-pane fade" id="Dishes">
                    <?php include 'Dishes.php'?>
                </div>
            </div>
        </div>

    </div>
    </section>
    <!--right order status siderbar-->
   <?php include 'siderbar.php'?>

</div>

</div>

<?php
    }
else if($_GET['RootID']==='' || $_GET['SubID']===''){//if RootID or SubID is not set then pop out location selection window
?>
    <?php
    echo $InitialLocationSelectClass->GetLocation('NoParam');
    ?>

<?php
}
?>
 <script src="<?php echo GlobalPath;?>/assets/framework/js/order.js"></script>
<?php include 'footer.php'?>