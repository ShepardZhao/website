   <?php require_once 'CMS/GobalConnection.php'?>
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
            <ul class="nav nav-pills nav-stacked ContentRightList TagWrapUI">
                <li>
                    <ul class="nav nav-pills ContentRightList TagAvailable TagWidthOverflow"><!--Availablity-->
                        <?php $OrderSelectionTagsClass->FrontEndDisplayTags("Availability","client_b2c.CuisineTags");?>
                        <i class="TagsArrowDown fa fa-arrow-circle-o-down"></i>
                        <i class="TagsArrowUp fa fa-arrow-circle-o-up"></i>


                    </ul>
                </li>
                <li>
                    <ul class="nav nav-pills ContentRightList TagCuisine TagWidthOverflow"><!--Cuisine-->
                        <?php $OrderSelectionTagsClass->FrontEndDisplayTags("Cuisine","client_b2c.CuisineTags");?>
                        <i class="TagsArrowDown fa fa-arrow-circle-o-down"></i>
                        <i class="TagsArrowUp fa fa-arrow-circle-o-up"></i>
                    </ul>
                </li>
                <li>
                    <ul class="nav nav-pills ContentRightList TagType TagWidthOverflow"><!--Type-->
                        <?php $OrderSelectionTagsClass->FrontEndDisplayTags("Type","client_b2c.CuisineTags");?>
                        <i class="TagsArrowDown fa fa-arrow-circle-o-down"></i>
                        <i class="TagsArrowUp fa fa-arrow-circle-o-up"></i>

                    </ul>
                </li>
                <li>
                    <ul class="nav nav-pills ContentRightList TagPrice TagWidthOverflow"><!--price-->
                        <?php $OrderSelectionTagsClass->FrontEndDisplayTags("Price","client_b2c.CuisineTags");?>
                        <i class="TagsArrowDown fa fa-arrow-circle-o-down"></i>
                        <i class="TagsArrowUp fa fa-arrow-circle-o-up"></i>
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







