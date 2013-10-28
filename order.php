<?php include 'header.php'?>
<?php
    if (isset($_GET['RootID']) && isset($_GET['SubID'])){
        $InitialLocationSelectClass->hiddenInitialLocation();
        session_start();
        //according RootID and SubID to get their names
        $_SESSION['RootLocation']=$InitialLocationSelectClass->GetsRootLocalName($_GET['RootID']);
        $_SESSION['SubLocation']=$InitialLocationSelectClass->GetsSubLocalName($_GET['RootID'],$_GET['SubID']);
?>
    <!--Container-->
     <div class="row-fluid"><!--ad zone-->
         <div class="span12 slideMarign hidden-phone"><!--key line for phone visiable-->
    <div id="myCarousel" class="carousel slide ">
        <ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#myCarousel" data-slide-to="1"></li>
            <li data-target="#myCarousel" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="item active">
                <img src="sample-images/1.jpg" alt="">
                    <div class="carousel-caption">
                    <blockquote>
                     <h3>Grilled Steak</h3>
                     <small>by Hurriance's Grill</small>
                    </blockquote>

                    <!--added to chart and added as in favorite-->
                        <h2>
                        <ul class="inline slidePrice text-right">
                            <li>$10.00</li>

                        </ul>
                         </h2>
                        <h2>
                        <ul class="inline favorite text-right">
                            <li><i class="fa fa-heart-o"></i></li>
                            <li><i class="fa fa-plus"></i></li>

                        </ul>
                         </h2>


                </div>
            </div>
            <div class="item">
                <img src="sample-images/2.jpg" alt="">

            </div>

        </div>

        <a class="left carousel-control" href="#myCarousel" data-slide="prev">‹</a>
        <a class="right carousel-control" href="#myCarousel" data-slide="next">›</a>
    </div>
   </div>
</div>
 <!--order zone-->
<div class="container-fluid">

<div class="row-fluid">
    <section>
    <div class="span9 tabzone hidden-phone	">
        <div class="tabbable"> <!-- Only required for left/right tabs -->
            <ul class="nav nav-tabs tabMain">
                <li class="active"><a href="#Featured" data-toggle="tab" id="Featured-tab">Featured</a></li>
                <li><a href="#Restaurants" data-toggle="tab" id="Restaurants-tab">Restaurants</a></li>
                <li><a href="#Dishes" data-toggle="tab" id="Dishes-tab">Dishes</a></li>
            </ul>
            <div class="tab-content tabContent"><!--tab selection-->
                <div class="tab-pane fade in active" id="Featured">
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
        <h1 class="left-position" id="Feathred-left-position"> <i class="fa fa-arrow-left"></i></h1>

    </div>
    </section>
    <!--right order status siderbar-->
   <?php include 'siderbar.php'?>

</div>

</div>
    <script src="<?php echo GlobalPath;?>/assets/framework/js/customer-Ajax.v1.0.js"></script>

<?php
    }
else if($_GET['RootID']==='' || $_GET['SubID']===''){
?>
    <?php
    echo $InitialLocationSelectClass->GetLocation('NoParam');
    ?>

<?php
}
?>


<?php include 'footer.php'?>