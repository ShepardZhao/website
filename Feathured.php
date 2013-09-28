    <div class="row-fluid" id="FeathuredInterface">

        <div class="span2 ContentRight">
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
                <li>
                    <ul class="nav nav-pills ContentRightList TagType TagWidthOverflow"><!--Type-->
                        <li>
                            <a>Soup</a>
                        </li>
                        <li><a>Pizza</a></li>
                        <li><a>Vegetarian</a></li>
                        <li><a>Haial</a></li>
                        <li><a>sandwich</a></li>
                        <li><a>Seafood</a></li>
                        <li><a>Snack</a></li>
                        <li><a>Pie</a></li>

                    </ul>
                </li>
                <li>
                    <ul class="nav nav-pills ContentRightList TagPrice TagWidthOverflow"><!--price-->

                        <li><a>$0-$5</a></li>
                        <li><a>$10-$15</a></li>
                        <li><a>$15-$20</a></li>
                        <li><a>$20-$30</a></li>
                        <li><a>$30-$40</a></li>
                        <li><a>More than $40</a></li>


                    </ul>
                </li>
            </ul>
        </div>

        <div class="row-fluid" id="AjaxWaterFall-NoParam"><!--image parts-->
          <?php
          $_POST['mode']=$_POST['getMode'];
          include "Common-waterfall.php";
          ?>
        </div>



    </div>







