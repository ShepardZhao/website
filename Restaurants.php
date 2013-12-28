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
                            <li><a href="Feathured?RootID=<?php echo $_GET['RootID']?>&SubID=<?php echo $_GET['SubID']?>">Featured</a></li>
                            <li  class="active"><a href="Restaurants?RootID=<?php echo $_GET['RootID']?>&SubID=<?php echo $_GET['SubID']?>">Restaurants</a></li>
                            <li><a href="Dishes?RootID=<?php echo $_GET['RootID']?>&SubID=<?php echo $_GET['SubID']?>">Dishes</a></li>
                        </ul>
                        <div class="tab-content tabContent"><!--tab selection-->
                            <div class="tab-pane active">
                                <div class="row-fluid" id="RestaurantsIndex">
                                    <div class="span12">
                                        <div class="span2 RestaurantsContentRight">
                                            <div class="ContentWidth">
                                                <ul class="nav nav-pills nav-stacked ContentLeftList">
                                                    <li>Availability</li>
                                                    <li>Cuisine</li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="span10">
                                            <ul class="nav nav-pills nav-stacked ContentRightList">
                                                <li>
                                                    <div id="TagAvailableRelative">
                                                        <ul class="nav nav-pills ContentRightList TagAvailable TagWidthOverflow"><!--Availablity-->
                                                            <?php $OrderSelectionTagsClass->FrontEndDisplayTags("Availability","CuisineTags");?>
                                                        </ul>
                                                        <div id="TagAvailablepPosition"><i class="TagsArrowDown fa fa-arrow-circle-o-down"></i><i class="TagsArrowUp fa fa-arrow-circle-o-up"></i></div>
                                                    </div>
                                                </li>

                                                <li>
                                                    <div id="TagCuisineRelative">
                                                        <ul class="nav nav-pills ContentRightList TagCuisine TagWidthOverflow"><!--Cuisine-->
                                                            <?php $OrderSelectionTagsClass->FrontEndDisplayTags("Cuisine","CuisineTags");?>
                                                        </ul>
                                                        <div id="TagCuisinePosition"><i class="TagsArrowDown fa fa-arrow-circle-o-down"></i><i class="TagsArrowUp fa fa-arrow-circle-o-up"></i></div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>


                                    <div class="row-fluid">
                                        <div class="span12">
                                            <div class="Restaurant_zone">
                                                <!--the list of restaurants-->
                                            </div>
                                            <div class="Ajax-loading"><img src="<?php echo GlobalPath.'/assets/framework/img/ajax-loader.gif'?>"></div>
                                        </div>
                                    </div>



                                </div>

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
<script src="<?php echo GlobalPath;?>/assets/framework/js/Restaurants.js"></script>
<?php include 'footer.php'?>





