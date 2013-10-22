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




<!--the list of restaurants-->

<div class="row-fluid">
 <div class="span12">
    <div class="accordion" id="accordion2">
        <div class="accordion-group ListReGroup">
            <div class="accordion-heading ListHeading">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne" >
                <div class="row-fluid innerHeading">
                    <div class="span2 text-right">
                      <img style="width:130px;height:130px;" src="">
                    </div>
                    <div class="span4 text-left">
                       <h4 class="RestaurantsName" id="123">Pancake on the Rocks</h4>
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
                </a>

            </div>
            <div id="collapseOne" class="accordion-body collapse in">
                <div class="accordion-inner innerList" id="RestaurantsID">

                    <!--getComment Model-->
                    <?php
                    $_POST['Restaurants1']="RestaurantsID";

                    include 'Common-comments.php';

                    ?>

                </div>
            </div>
        </div>
        <div class="accordion-group ListReGroup">
            <div class="accordion-heading ListHeading">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo">

                    <div class="row-fluid innerHeading">
                        <div class="span2 text-right">
                            <img style="width:130px;height:130px;" src="">
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

                </a>
            </div>
            <div id="collapseTwo" class="accordion-body collapse">
                <div class="accordion-inner innerList">
                  <!--getComment Model-->
                </div>
            </div>
        </div>
    </div>
</div>
</div>



</div>