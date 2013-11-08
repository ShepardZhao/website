<?php if($_SERVER['REQUEST_METHOD']==='POST'){?>


       <div class="row-fluid FeatureTopBackground" id="Cuisine-Detail-page">
        <div class="spa12 limitedWidth">
            <div class="span3"><img src="<?php echo $_POST['CuisinePicpath']?>" class="img-polaroid"></div>
            <div class="span5">
                <section><!--Title and resturant-->
                    <h4 class="h4Title"><?php echo $_POST['CuisineName']?></h4>
                    <p>by <i><a><?php echo $_POST['CuisineResName']?></a></i></p>
                </section>

                <section>
                    <ul class="inline  TagWidthOverflow inlineLeftPadding">
                        <li><button class="btn btn-mini" type="button"><?php echo $_POST['CuisineAvaliabilityTag']?></button></li>
                        <li><button class="btn btn-mini" type="button"><?php echo $_POST['CuisinePriceTag']?></button></li>
                        <li><button class="btn btn-mini" type="button"><?php echo $_POST['CuisineCuisineTag']?></button></li>
                        <li><button class="btn btn-mini" type="button"><?php echo $_POST['CuisineTypeTag']?></button></li>

                    </ul>

                </section>

                <section><!--description-->
                    <div class="row-fluid">
                        <div class="span12">
                            <p><?php echo $_POST['CuisineDesc']?></p>
                        </div>

                    </div>

                    <div class="row-fluid">
                        <div class="span12">
                            <h5>Your Rating:</h5>
                            <h4>
                                <ul class="inline inlineLeftPadding">
                                    <li><i class="fa fa-star-o"></i></li>
                                    <li><i class="fa fa-star-o"></i></li>
                                    <li><i class="fa fa-star-o"></i></li>
                                    <li><i class="fa fa-star-o"></i></li>
                                    <li><i class="fa fa-star-o"></i></li>
                                </ul>
                            </h4>
                       </div>
                    </div>
                </section>



            </div>

            <div class="span4 text-center rightFeature"><!--rightRestaurants with price, stars and so on-->
                <h2>$<?php echo number_format(floatval(preg_replace("/[^-0-9\.]/","",$_POST['CuisinePrice'])),2,".", "")?></h2>
                <h2>
                    <ul class="inline" id="rightRestaurants_heartAndPlus">
                       <?php if($_POST['CuisineWhetherFavorite']==='0'){
                           echo "<li><i class='AddedToFavorite fa fa-heart-o'></i></li>";
                            }
                       elseif($_POST['CuisineWhetherFavorite']==='1'){
                           echo "<li><i class='AddedToFavorite fa fa-heart'></i></li>";
                          }

                       if($_POST['CuisineWhetherInCart']==='0'){
                           echo "<li><i class='AddedToCart fa fa-plus'></i></li>";
                       }
                       elseif($_POST['CuisineWhetherInCart']==='1'){
                           echo "<li><i class='AddedToCart fa fa-shopping-cart'></i></li>";
                       }




                       ?>

                    </ul>
                </h2>

                <h4>
                    <ul class="inline" id="rightRestaurantsStars">
                        <?php
                        $TotalStar=5;//total stars are 5s
                        $CountStar=$_POST['CuisineRating'];//This will contain hwo many entire stars have been used
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
                <h3><i id="Navcomments" class="icon-circle-arrow-down"></i></h3>
            </div>

        </div><!--ends-->
           <div class="row-fluid" id="ClickToComment">


           </div>
    </div>



<?php }?>

