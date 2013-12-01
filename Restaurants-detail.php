<?php include 'header.php'?>
<?php
if (isset($_SESSION['RootID']) && isset($_SESSION['SubID'])){
    $InitialLocationSelectClass->hiddenInitialLocation();
//according RootID and SubID to get their names
    $_SESSION['RootLocation']=$InitialLocationSelectClass->GetsRootLocalName($_SESSION['RootID']);
    $_SESSION['SubLocation']=$InitialLocationSelectClass->GetsSubLocalName($_SESSION['RootID'],$_SESSION['SubID']);
    ?>
    <input type="hidden" id="RootID" value="<?php echo $_SESSION['RootID']?>">
    <input type="hidden" id="SubID" value="<?php echo $_SESSION['SubID']?>">
    <input type="hidden" id="RestID" value="<?php echo $_GET['RestID']?>">
    <input type="hidden" id="ResName" value="<?php echo $_GET['ResName']?>">
    <input type="hidden" id="ResPicPath" value="<?php echo $_GET['ResPicPath']?>">
    <input type="hidden" id="ResAvailabilityTags" value="<?php echo $_GET['ResAvailabilityTags']?>">
    <input type="hidden" id="ResCuisineTags" value="<?php echo $_GET['ResCuisineTags']?>">
    <input type="hidden" id="ResCuisineTags" value="<?php echo $_GET['ResCuisineTags']?>">



    <!--Ad zone-->
    <?php require_once 'AdZone.php'?>
    <!--order zone-->
    <div class="container-fluid" id="ScrollTopPosition">

        <div class="row-fluid">
            <section>
                <div class="span9 tabzone hidden-phone">
                    <div class="tabbable"> <!-- Only required for left/right tabs -->
                        <ul class="nav nav-tabs tabMain">
                            <li><a href="Feathured?RootID=<?php echo $_SESSION['RootID']?>&SubID=<?php echo $_SESSION['SubID']?>">Featured</a></li>
                            <li><a href="#Restaurants"  id="Restaurants-tab">Restaurants</a></li>
                            <li><a href="Dishes?RootID=<?php echo $_SESSION['RootID']?>&SubID=<?php echo $_SESSION['SubID']?>"  id="Dishes-tab">Dishes</a></li>
                        </ul>
                        <div class="tab-content tabContent"><!--tab selection-->
                            <div class="tab-pane fade in active">
                                <div class="Restaurants-detail">
                                    <div class="row-fluid innerHeading">
                                        <div class="span2 text-right">
                                            <img style="width:130px;height:130px;" src="http://10.1.1.9/B2C/assets/framework/img/pic.jpeg">
                                        </div>
                                        <div class="span4 text-left">
                                            <h4>Pancake on the Rocks</h4>
                                            <p>
                                            <ul class="inline  TagWidthOverflow inlineLeftPadding">
                                                <li><button class="btn btn-mini" type="button">Facebook</button></li>
                                                <li><button class="btn btn-mini" type="button">Twetter</button></li>
                                            </ul>
                                            </p>

                                            <h6 class="resetColor">Open Time: 15:00 - 20:00</h6>
                                            <h4>
                                                <ul class="inline inlineLeftPadding resetColor">
                                                    <li><h5>Your Rating</h5></li>
                                                    <li><i class="icon-star-empty"></i></li>
                                                    <li><i class="icon-star-empty"></i></li>
                                                    <li><i class="icon-star-empty"></i></li>
                                                    <li><i class="icon-star-empty"></i></li>
                                                    <li><i class="icon-star-empty"></i></li>
                                                </ul>
                                            </h4>
                                        </div>
                                        <div class="span4 text-center resetColor" id="toppadding">
                                            <h4>
                                                <ul class="inline " id="rightRestaurantsStars ">
                                                    <li><i class="icon-star"></i></li>
                                                    <li><i class="icon-star"></i></li>
                                                    <li><i class="icon-star"></i></li>
                                                    <li><i class="icon-star"></i></li>
                                                    <li><i class="icon-star"></i></li>
                                                </ul>

                                            </h4>
                                            <p class="resetColor">10 Comments</p>
                                            <h3><i id="Navcomments" class="resetColor icon-circle-arrow-down"></i></h3>


                                        </div>
                                        <div class="offset2 pull-right"></div>

                                    </div>


                                    <div class="row-fluid restaurants-detailBg">
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

                                                        <ul class="nav nav-pills ContentRightList TagAvailable TagWidthOverflow"><!--Availablity-->
                                                            <li>
                                                                <a>Available</a>
                                                            </li>
                                                            <li><a>11AM - 1PM</a></li>
                                                            <li><a>4PM - 8PM</a></li>
                                                            <li><a>1PM - 4PM</a></li>
                                                        </ul>
                                                    </li>
                                                    <li>
                                                        <ul class="nav nav-pills ContentRightList TagCuisine TagWidthOverflow"><!--Cuisine-->
                                                            <li>
                                                                <a>Itanlian</a>
                                                            </li>
                                                            <li><a>Chinese</a></li>
                                                            <li><a>Japanese</a></li>
                                                            <li><a>Indian</a></li>
                                                            <li><a>Korean</a></li>
                                                            <li><a>Australian</a></li>
                                                            <li><a>Cantonese</a></li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                            </div>

                                        </div>

                                    </div>

                                    <div class="row-fluid">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h1 class="left-position" id="Feathred-left-position"> <i class="fa fa-arrow-circle-left"></i></h1>

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
<script src="<?php echo GlobalPath;?>/assets/framework/js/DetailCuisine.js"></script>

<?php include 'footer.php'?>


