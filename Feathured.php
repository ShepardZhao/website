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
        <div class="span10 tagszone">
            <ul class="nav nav-pills nav-stacked ContentRightList TagWrapUI">
                <li>
                <div id="TagAvailableRelative">
                    <ul class="nav nav-pills ContentRightList TagAvailable TagWidthOverflow"><!--Availablity-->
                        <?php $OrderSelectionTagsClass->FrontEndDisplayTags("Availability","client_b2c.CuisineTags");?>
                    </ul>
                <div id="TagAvailablepPosition"><i class="TagsArrowDown fa fa-arrow-circle-o-down"></i><i class="TagsArrowUp fa fa-arrow-circle-o-up"></i></div>
                </div>
                </li>

                <li>
                <div id="TagCuisineRelative">
                    <ul class="nav nav-pills ContentRightList TagCuisine TagWidthOverflow"><!--Cuisine-->
                        <?php $OrderSelectionTagsClass->FrontEndDisplayTags("Cuisine","client_b2c.CuisineTags");?>
                    </ul>
                <div id="TagCuisinePosition"><i class="TagsArrowDown fa fa-arrow-circle-o-down"></i><i class="TagsArrowUp fa fa-arrow-circle-o-up"></i></div>
                </div>
                </li>

                <li>
                <div id="TagTypeRelative">
                    <ul class="nav nav-pills ContentRightList TagType TagWidthOverflow"><!--Type-->
                        <?php $OrderSelectionTagsClass->FrontEndDisplayTags("Type","client_b2c.CuisineTags");?>
                    </ul>
                <div id="TagTypePosition"><i class="TagsArrowDown fa fa-arrow-circle-o-down"></i><i class="TagsArrowUp fa fa-arrow-circle-o-up"></i></div>
                </div>
                </li>

                <li>
                <div id="TagPriceRelative">
                    <ul class="nav nav-pills ContentRightList TagPrice TagWidthOverflow"><!--price-->
                        <?php $OrderSelectionTagsClass->FrontEndDisplayTags("Price","client_b2c.CuisineTags");?>
                    </ul>
                <div id="TagPricePosition"><i class="TagsArrowDown fa fa-arrow-circle-o-down"></i><i class="TagsArrowUp fa fa-arrow-circle-o-up"></i></div>
                </div>
                </li>
            </ul>
        </div>
       <!--below part is showing the feature's waterfall------------->
        <div class="row-fluid" id="AjaxWaterFall-NoParam"><!--image parts-->
            <div id="FeatureMargin" class="span12 hidden-phone FeaturedImage">

                <div class="FeatureImagetiles" role="main" >
                    <ul id="Imagetiles" class="Imagetiles">

                        <!-- These are our grid blocks -->

                    </ul>
                    <div id="Ajax-loading"><img src="<?php echo GlobalPath.'/assets/framework/img/ajax-loader.gif'?>"></div>
                </div>
            </div>
        </div>

    </div>
   <script src="<?php echo GlobalPath;?>/assets/framework/js/order.js"></script>





