<?php include 'header.php'?>
<?php
session_start();
if (isset($_SESSION['RootID']) && isset($_SESSION['SubID'])){
$InitialLocationSelectClass->hiddenInitialLocation();
//according RootID and SubID to get their names
$_SESSION['RootLocation']=$InitialLocationSelectClass->GetsRootLocalName($_SESSION['RootID']);
$_SESSION['SubLocation']=$InitialLocationSelectClass->GetsSubLocalName($_SESSION['RootID'],$_SESSION['SubID']);
?>
<input type="hidden" id="RootID" value="<?php echo $_SESSION['RootID']?>">
<input type="hidden" id="SubID" value="<?php echo $_SESSION['SubID']?>">
<input type="hidden" id="RootLocationName" value="<?php echo $_SESSION['RootLocation']?>">
<input type="hidden" id="SubLocationName" value="<?php echo $_SESSION['SubLocation']?>">
<input type="hidden" id="CurrentLoginedUserID" value="<?php echo $_SESSION['LoginedUserID']?>">

    <!--Ad zone-->
<?php require_once 'AdZone.php'?>
    <!--order zone-->
<div class="container-fluid" id="ScrollTopPosition">

    <div class="row-fluid">
        <section>
            <div class="span9 tabzone hidden-phone">
                <div class="tabbable"> <!-- Only required for left/right tabs -->
                    <ul class="nav nav-tabs tabMain">
                        <li class="active"><a href="order?RootID=<?php echo $_SESSION['RootID']?>&SubID=<?php echo $_SESSION['SubID']?>">Featured</a></li>
                        <li><a href="#Restaurants"  id="Restaurants-tab">Restaurants</a></li>
                        <li><a href="#Dishes"  id="Dishes-tab">Dishes</a></li>
                    </ul>
                    <div class="tab-content tabContent"><!--tab selection-->
                        <div class="tab-pane fade in active">
                            <div id="Cuisine-Detail-page">
                                <input type="hidden" id="GetCurrentCuID" value="<?php echo $_GET['CuisineID']?>">
                                <input type="hidden" id="GetCurrentResID" value="<?php echo $_GET['CuResID']?>">
                                <div class="row-fluid FeatureTopBackground">
                                    <div class="spa12 limitedWidth">
                                        <div class="span3"><img src="<?php echo $_GET['CuisinePicpath']?>" class="img-polaroid"></div>
                                        <div class="span5">
                                            <section><!--Title and resturant-->
                                                <h4 class="h4Title" id="CuisineName"><?php echo $_GET['CuisineName']?></h4>
                                                <p>by <i><a><?php echo $_GET['CuisineResName']?></a></i></p>
                                            </section>

                                            <section>
                                                <ul class="inline inlineLeftPadding">
                                                    <?php
                                                    $Array=explode(',',$_GET['CuisineAvaliabilityTag']);
                                                    foreach ($Array as $value){
                                                        echo "<li><button class='btn btn-mini' type='button'>$value</button></li>";
                                                    }
                                                    $Array=explode(',',$_GET['CuisinePriceTag']);
                                                    foreach ($Array as $value){
                                                        echo "<li><button class='btn btn-mini' type='button'>$value</button></li>";
                                                    }
                                                    $Array=explode(',',$_GET['CuisineCuisineTag']);
                                                    foreach ($Array as $value){
                                                        echo "<li><button class='btn btn-mini' type='button'>$value</button></li>";
                                                    }
                                                    $Array=explode(',',$_GET['CuisineTypeTag']);
                                                    foreach ($Array as $value){
                                                        echo "<li><button class='btn btn-mini' type='button'>$value</button></li>";
                                                    }
                                                    ?>
                                                </ul>

                                            </section>

                                            <section><!--description-->
                                                <div class="row-fluid">
                                                    <div class="span12">
                                                        <p id="CuisineDescriptWrap"><?php echo $_GET['CuisineDesc']?></p><h6><a id="ClickReadMore">..Read More</a></h6>

                                                    </div>

                                                </div>

                                                <div class="row-fluid">
                                                    <div class="span12">
                                                        <h5>Your Rating:</h5>
                                                        <h4>
                                                            <ul class="inline inlineLeftPadding">
                                                                <li><i class="fa CuisineCommentStar fa-star-o"></i></li>
                                                                <li><i class="fa CuisineCommentStar fa-star-o"></i></li>
                                                                <li><i class="fa CuisineCommentStar fa-star-o"></i></li>
                                                                <li><i class="fa CuisineCommentStar fa-star-o"></i></li>
                                                                <li><i class="fa CuisineCommentStar fa-star-o"></i></li>
                                                            </ul>
                                                        </h4>
                                                    </div>
                                                </div>
                                            </section>
                                        </div>

                                        <div class="span4 text-center rightFeature"><!--rightRestaurants with price, stars and so on-->
                                            <h2>$<?php echo number_format(floatval(preg_replace("/[^-0-9\.]/","",$_GET['CuisinePrice'])),2,".", "")?></h2>
                                            <h2>
                                                <ul class="inline" id="rightRestaurants_heartAndPlus">
                                                    <?php if($_GET['CuisineWhetherFavorite']==='0'){
                                                        echo "<li><i class='AddedToFavorite fa fa-heart-o'></i></li>";
                                                    }
                                                    elseif($_GET['CuisineWhetherFavorite']==='1'){
                                                        echo "<li><i class='AddedToFavorite fa fa-heart'></i></li>";
                                                    }

                                                    if($_GET['CuisineWhetherInCart']==='0'){
                                                        echo "<li><i class='AddedToCart fa fa-plus'></i></li>";
                                                    }
                                                    elseif($_GET['CuisineWhetherInCart']==='1'){
                                                        echo "<li><i class='AddedToCart fa fa-shopping-cart'></i></li>";
                                                    }
                                                    ?>

                                                </ul>
                                            </h2>

                                            <h4>
                                                <ul class="inline" id="rightRestaurantsStars">
                                                    <?php
                                                    $TotalStar=5;//total stars are 5s
                                                    $CountStar=$_GET['CuisineRating'];//This will contain hwo many entire stars have been used
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
                                            <p>10 Comments</p>
                                            <h3><i id="Navcomments" class="fa fa-arrow-circle-down"></i></h3>
                                        </div>

                                    </div><!--ends-->
                                </div>

                                <div class="row-fluid FeaturedImage" id="Cuisine-Waterfall"><div class="span12 otherdishes"><h4>Other dishes from <i id="OtherDisResName"><?php echo $_GET['CuisineResName']?></i></h4></div>
                                    <!--wafterfall-->
                                    <div class="row-fluid" ><!--image parts-->
                                        <div class="span12 hidden-phone FeaturedImage">

                                            <div class="Imagetiles-detail" role="main" >
                                                <ul id="ReleventCuisine" class="Imagetiles">

                                                    <!-- These are our grid blocks -->
                                                </ul>
                                                <div class="Ajax-loading"><img src="<?php echo GlobalPath.'/assets/framework/img/ajax-loader.gif'?>"></div>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                    <!--Comments-->
                                    <div class="row-fluid" id="ClickToComment">
                                            <div class="span12">
                                                <ul class="nav nav-pills nav-stacked commentMarginBottom">
                                                </ul>
                                                <div class="Ajax-loading"><img src="<?php echo GlobalPath.'/assets/framework/img/ajax-loader.gif'?>"></div>

                                            </div>

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
