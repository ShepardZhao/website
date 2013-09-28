    <div class="row-fluid FeatureTopBackground" ><!--restaurant top starts-->
        <div class="spa12 limitedWidth">
            <div class="span3"><img src="sample-images/image_1.jpg" class="img-polaroid"></div>
            <div class="span5">
                <section><!--Title and resturant-->
                    <h4 class="h4Title">Chocolate pancake with extra cream</h4>
                    <p>by <i><a>Pancake on the Rocks</a></i></p>
                </section>

                <section><!-button-->
                    <ul class="inline  TagWidthOverflow inlineLeftPadding">
                        <li><button class="btn btn-mini" type="button">Facebook</button></li>
                        <li><button class="btn btn-mini" type="button">Twetter</button></li>
                    </ul>

                </section>

                <section><!--description-->
                    <div class="row-fluid">
                        <div class="span12">
                            <p>Nullam quis risus eget urna mollis ornare vel eu leo. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nullam id dolor id nibh ultricies vehicula.</p>
                        </div>

                    </div>

                    <div class="row-fluid">
                        <div class="span12">
                            <h4>
                                <ul class="inline inlineLeftPadding">
                                    <li><h5>Your Rating</h5></li>
                                    <li><i class="icon-star-empty"></i></li>
                                    <li><i class="icon-star-empty"></i></li>
                                    <li><i class="icon-star-empty"></i></li>
                                    <li><i class="icon-star-empty"></i></li>
                                    <li><i class="icon-star-empty"></i></li>
                                </ul>
                            </h4>
                        </div>
                    </div>
                </section>



            </div>

            <div class="span4 text-center rightFeature"><!--rightRestaurants with price, stars and so on-->
                <h2>$19.00</h2>
                <h2>
                    <ul class="inline" id="rightRestaurants_heartAndPlus">
                        <li><i class="icon-heart-empty"></i></li>
                        <li><i class="icon-plus"></i></li>

                    </ul>
                </h2>

                <h4>
                    <ul class="inline" id="rightRestaurantsStars">
                        <li><i class="icon-star"></i></li>
                        <li><i class="icon-star"></i></li>
                        <li><i class="icon-star"></i></li>
                        <li><i class="icon-star"></i></li>
                        <li><i class="icon-star"></i></li>
                    </ul>

                </h4>
                <p>10 Comments</p>
                <h3><i id="Navcomments" class="icon-circle-arrow-down"></i></h3>
            </div>

        </div><!--ends-->

    </div>

    <div class="row-fluid" id="ClickToComment">
        <?php
        $_POST['mode']=$_POST['getMode'];
        include "Common-waterfall.php";
        ?>

    </div>



