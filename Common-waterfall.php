<?php

//Three switch modes: mode1: initial loading (beginning from Feathured), mode2: click one of waterfall pic and get a returned id and switch between comment and waterfall

//default switch mode is mode1.


$getMode=$_POST['mode'];
if($getMode==="mode1"){
?>

<div id="FeatureMargin" class="span12 hidden-phone FeaturedImage " >

    <div class="Imagemain" role="main">

        <ul class="Imagetiles">
        <!-- These are our grid blocks -->
        <li><div class="TopOptions"><div class="span4"><i class="BackgroundOfStarAndPlus icon-heart-empty"></i></div><div class="span4 blodOfPrice">$20</div><div class="span4"><i class="BackgroundOfStarAndPlus icon-plus"></i> </div></div><img src="sample-images/image_1.jpg"><h6 class="foodName">Beef stuff in the some or something else</h6><h6 id="pic1" class="RetaurantName optionsHide">Beef stuff</h6></li>

    </ul>

</div>
</div>
<?php
}

else if($getMode==="mode2"){

?>
<div class="span12 FeatureBottomBackground">
    <h4>Other Dishes from <a>Pancake on the Rocks</a></h4>
    <div class="row-fluid">

    <div id="FeatureMargin" class="span12 hidden-phone FeaturedImage " >

        <div class="Imagemain" role="main">

            <ul class="Imagetiles">
                <!-- These are our grid blocks -->
                <li><div class="TopOptions"><div class="span4"><i class="BackgroundOfStarAndPlus icon-heart-empty"></i></div><div class="span4 blodOfPrice">$20</div><div class="span4"><i class="BackgroundOfStarAndPlus icon-plus"></i> </div></div><img src="sample-images/image_1.jpg"><h6 class="foodName">Beef stuff in the some or something else</h6><h6 id="pic1" class="RetaurantName optionsHide">Beef stuff</h6><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i></li>
                <li><img src="sample-images/image_3.jpg"><h6>Beef stuff</h6><h6 class="optionsHide">Beef stuff</h6></li>
                <li><img src="sample-images/image_4.jpg"><h6>Beef stuff</h6><h6 class="optionsHide">Beef stuff</h6></li>
                <li><img src="sample-images/image_5.jpg"><h6>Beef stuff</h6><h6 class="optionsHide">Beef stuff</h6></li>
                <li><img src="sample-images/image_6.jpg"><h6>Beef stuff</h6><h6 class="optionsHide">Beef stuff</h6></li>
                <li><img src="sample-images/image_7.jpg"><h6>Beef stuff</h6><h6 class="optionsHide">Beef stuff</h6></li>
                <li><img src="sample-images/image_8.jpg"><h6>Beef stuff</h6><h6 class="optionsHide">Beef stuff</h6></li>
                <li><img src="sample-images/image_9.jpg"><h6>Beef stuff</h6><h6 class="optionsHide">Beef stuff</h6></li>
                <li><img src="sample-images/image_10.jpg"><h6>Beef stuff</h6><h6 class="optionsHide">Beef stuff</h6></li>
                <li><img src="sample-images/image_1.jpg"><h6>Beef stuff</h6><h6 class="optionsHide">Beef stuff</h6></li>
                <li><img src="sample-images/image_2.jpg"><h6>Beef stuff</h6><h6 class="optionsHide">Beef stuff</h6></li>
                <li><img src="sample-images/image_3.jpg"><h6>Beef stuff</h6><h6 class="optionsHide">Beef stuff</h6></li>
                <li><img src="sample-images/image_4.jpg"><h6>Beef stuff</h6><h6 class="optionsHide">Beef stuff</h6></li>
                <li><img src="sample-images/image_5.jpg"><h6>Beef stuff</h6><h6 class="optionsHide">Beef stuff</h6></li>
            </ul>

        </div>
    </div>
    </div>
</div>
<?php }
else if($getMode==="mode3")
{
?>
    <div id="FeatureMargin" class="span12 hidden-phone FeaturedImage">

        <div class="Imagemain" role="main">

            <ul class="Imagetiles">
                <!-- These are our grid blocks -->
                <li><div class="TopOptions"><div class="span4"><i class="BackgroundOfStarAndPlus icon-heart-empty"></i></div><div class="span4 blodOfPrice">$20</div><div class="span4"><i class="BackgroundOfStarAndPlus icon-plus"></i> </div></div><img src="sample-images/image_1.jpg"><h6 class="foodName-Restaurants">Beef stuff in the some or something else</h6><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i></li>
                <li><img src="sample-images/image_3.jpg"><h6>Beef stuff</h6><h6 class="optionsHide">Beef stuff</h6></li>
                <li><img src="sample-images/image_4.jpg"><h6>Beef stuff</h6><h6 class="optionsHide">Beef stuff</h6></li>
                <li><img src="sample-images/image_5.jpg"><h6>Beef stuff</h6><h6 class="optionsHide">Beef stuff</h6></li>
                <li><img src="sample-images/image_6.jpg"><h6>Beef stuff</h6><h6 class="optionsHide">Beef stuff</h6></li>
                <li><img src="sample-images/image_7.jpg"><h6>Beef stuff</h6><h6 class="optionsHide">Beef stuff</h6></li>
                <li><img src="sample-images/image_8.jpg"><h6>Beef stuff</h6><h6 class="optionsHide">Beef stuff</h6></li>
                <li><img src="sample-images/image_9.jpg"><h6>Beef stuff</h6><h6 class="optionsHide">Beef stuff</h6></li>
                <li><img src="sample-images/image_10.jpg"><h6>Beef stuff</h6><h6 class="optionsHide">Beef stuff</h6></li>
                <li><img src="sample-images/image_1.jpg"><h6>Beef stuff</h6><h6 class="optionsHide">Beef stuff</h6></li>
                <li><img src="sample-images/image_2.jpg"><h6>Beef stuff</h6><h6 class="optionsHide">Beef stuff</h6></li>
                <li><img src="sample-images/image_3.jpg"><h6>Beef stuff</h6><h6 class="optionsHide">Beef stuff</h6></li>
                <li><img src="sample-images/image_4.jpg"><h6>Beef stuff</h6><h6 class="optionsHide">Beef stuff</h6></li>
                <li><img src="sample-images/image_5.jpg"><h6>Beef stuff</h6><h6 class="optionsHide">Beef stuff</h6></li>
            </ul>

        </div>
    </div>

<?php }?>


<script src="assets/framework/js/index-waterfall.js"></script>




