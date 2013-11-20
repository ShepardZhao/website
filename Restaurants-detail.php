<?php
$picId=$_POST['RestuarntID'];
if(isset($picId)){
?>

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
        <?php
        $_POST['mode']="mode3";
        include 'Common-waterfall.php';

        ?>
    </div>




<?php }?>