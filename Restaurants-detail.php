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
    <input type="hidden" id="CurrentLoginedUserID" value="<?php echo $_SESSION['LoginedUserID']?>">
    <input type="hidden" id="TabChoose" value="<?php echo $_GET['TabChoose']?>">



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
                            <li><a href="Restaurants?RootID=<?php echo $_GET['RootID']?>&SubID=<?php echo $_GET['SubID']?>"  id="Restaurants-tab">Restaurants</a></li>
                            <li><a href="Dishes?RootID=<?php echo $_SESSION['RootID']?>&SubID=<?php echo $_SESSION['SubID']?>"  id="Dishes-tab">Dishes</a></li>
                        </ul>
                        <div class="tab-content tabContent"><!--tab selection-->
                            <div class="tab-pane fade in active">
                                <div class="Restaurants-detail">
                                    <div class="row-fluid innerHeading">
                                        <div class="span3 text-right">
                                            <img src="<?php echo $_GET['ResPicPath']?>" class="img-polaroid">
                                        </div>
                                        <div class="span5 text-left">
                                            <h4 class="h4Title"><?php echo $_GET['ResName']?></h4>
                                            <p>
                                            <ul class="inline  TagWidthOverflow inlineLeftPadding">
                                                <?php
                                                $Array=explode(',',$_GET['ResAvailabilityTags']);
                                                foreach ($Array as $value){
                                                    echo "<li><button class='btn btn-mini' type='button'>$value</button></li>";
                                                }
                                                $Array=explode(',',$_GET['ResCuisineTags']);
                                                foreach ($Array as $value){
                                                    echo "<li><button class='btn btn-mini' type='button'>$value</button></li>";
                                                }
                                                ?>
                                            </ul>
                                            </p>

                                            <h6 class="resetColor">
                                                <?php
                                                   $TodayDate = date('l');
                                                   $Array = json_decode($_GET['ResOpenTime'],true);
                                                   foreach ($Array as $key => $value){
                                                       if($key === $TodayDate){
                                                           echo 'Open Time: '.$key.' ( '.$value. ' ) ';
                                                       }


                                                   }

                                                ?>


                                            </h6>
                                            <h4>
                                                <ul class="inline inlineLeftPadding resetColor">
                                                    <div class="span12">
                                                        <h5>Your Rating:</h5>
                                                        <h4>
                                                            <ul class="inline inlineLeftPadding">
                                                                <li><i class="fa ResCommentStar fa-star-o"></i></li>
                                                                <li><i class="fa ResCommentStar fa-star-o"></i></li>
                                                                <li><i class="fa ResCommentStar fa-star-o"></i></li>
                                                                <li><i class="fa ResCommentStar fa-star-o"></i></li>
                                                                <li><i class="fa ResCommentStar fa-star-o"></i></li>
                                                            </ul>
                                                        </h4>
                                                    </div>
                                                </ul>
                                            </h4>
                                        </div>
                                        <div class="span3 text-center resetColor" id="toppadding">
                                            <h4>
                                                <ul class="inline " id="rightRestaurantsStars ">
                                                    <?php
                                                    $TotalStar=5;//total stars are 5s
                                                    $CountStar=$_GET['ResRating'];//This will contain hwo many entire stars have been used
                                                    $emptyStar=$TotalStar-$CountStar;//this will display empty stars
                                                    for($i=0;$i<$CountStar;$i++){
                                                        echo "<li><i class='fa fa-star'></i></li>";
                                                    }
                                                    for ($j=0;$j<$emptyStar;$j++){
                                                        echo "<li><i class='fa fa-star-o'></i></li>";

                                                    }

                                                    ?>
                                                </ul>

                                            </h4>
                                            <p class="resetColor"><?php echo $_GET['ResTotalComments']?> Comments</p>
                                            <h3><i id="Navcomments" class="fa fa-arrow-circle-down"></i></h3>

                                        </div>
                                        <div class="offset1 pull-right"></div>

                                    </div>

                                   <div id="ResWaterfall-zone">
                                    <div class="row-fluid restaurants-detailBg">
                                        <div class="span12">
                                            <div class="span2 RestaurantsContentRight">
                                                <div class="ContentWidth">
                                                    <ul class="nav nav-pills nav-stacked ContentLeftList">
                                                        <li>Availability</li>
                                                        <li>Cuisine</li>
                                                        <li>Type</li>
                                                        <li>Price</li>
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
                                                    <li>
                                                        <div id="TagTypeRelative">
                                                            <ul class="nav nav-pills ContentRightList TagType TagWidthOverflow"><!--Type-->
                                                                <?php $OrderSelectionTagsClass->FrontEndDisplayTags("Type","CuisineTags");?>
                                                            </ul>
                                                            <div id="TagTypePosition"><i class="TagsArrowDown fa fa-arrow-circle-o-down"></i><i class="TagsArrowUp fa fa-arrow-circle-o-up"></i></div>
                                                        </div>
                                                    </li>

                                                    <li>
                                                        <div id="TagPriceRelative">
                                                            <ul class="nav nav-pills ContentRightList TagPrice TagWidthOverflow"><!--price-->
                                                                <?php $OrderSelectionTagsClass->FrontEndDisplayTags("Price","CuisineTags");?>
                                                            </ul>
                                                            <div id="TagPricePosition"><i class="TagsArrowDown fa fa-arrow-circle-o-down"></i><i class="TagsArrowUp fa fa-arrow-circle-o-up"></i></div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>

                                        </div>

                                    </div>

                                    <div class="row-fluid">
                                            <!--wafterfall-->
                                            <div class="row-fluid" ><!--image parts-->
                                                <div class="span12 hidden-phone FeaturedImage">

                                                    <div class="Imagetiles-detail" role="main">
                                                        <ul id="RestaurantCuisine" class="Imagetiles" style="margin-top:9px;">

                                                            <!-- These are our grid blocks -->
                                                        </ul>
                                                        <div class="Ajax-loading"><img src="<?php echo GlobalPath.'/assets/framework/img/ajax-loader.gif'?>"></div>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                  </div>
                                    <!--Comments-->
                                    <div class="row-fluid" id="ClickToComment">
                                        <div class="span12">
                                            <ul class="nav nav-pills nav-stacked commentMarginBottom">
                                                <!-- inside waterfall-->
                                            </ul>

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h1 class="left-position" id="Restaurants-left-position"> <i class="fa fa-arrow-circle-left"></i></h1>

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
<script src="<?php echo GlobalPath;?>/assets/framework/js/RestaurantDetailPage.js"></script>


<?php include 'footer.php'?>


