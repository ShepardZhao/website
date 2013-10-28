<div id="TagsManagement">
    <div id="display_info" class="row-fluid"><div class="span12"></div></div>
    <div class="row-fluid">
        <div class="span12">
            <div class="divhead"><h4><i class="fa fa-list-alt">  Cuisine's and Restaurants's Tags Setting</i><h4></div>
            <div class="basicInfo-box">
                <div class="row-fluid">
                    <div class="span5 offset1">

                        <div class="input-prepend">
                            <span class="add-on">Availability</span>
                            <input class="span7" id="InputCuisAvailability" type="text" placeholder="New Availabilty">
                        </div>
                        <div id="CuisineAvailabilityTagsList">
                            <?php $TagsClass->outPutTags("Availability","client_b2c.CuisineTags");?>
                        </div>
                        <br>
                        <button id="AddCuisAvailabilityButton" class="button" type="button">Add</button>
                        <button id="RemoveCuisAvailabilityButton" class="button" type="button">Reomve</button>

                    </div>

                    <div class="span5 offset1">
                        <div class="input-prepend">
                            <span class="add-on">Cuisine</span>
                            <input class="span9" id="InputCuisCuisine" type="text" placeholder="New Cuisine">
                        </div>
                        <div id="CuisineCuisineTagsList">
                            <?php $TagsClass->outPutTags("Cuisine","client_b2c.CuisineTags");?>
                        </div>
                        <br>
                        <button id="AddCuisCuisineButton" class="button" type="button">Add</button>
                        <button id="RemoveCuisCuisineButton" class="button" type="button">Remove</button>

                    </div>
                    <!--notes-->


                    <div class="row-fluid">
                        <div class="span12">
                            <br>
                            <div class="alert alert-info">
                                Notes: The tags of Avaliability and Cuisine are same as been used in the Restaurants's tags
                            </div>
                        </div>
                    </div>

                    <div class="row-fluid">
                        <div class="span5 offset1">
                            <div class="input-prepend">
                                <span class="add-on">Type</span>
                                <input class="span9" id="InputCuisType" type="text" placeholder="New Type">

                            </div>
                            <div id="CuisineTypeTagsList">
                                <?php $TagsClass->outPutTags("Type","client_b2c.CuisineTags");?>
                            </div>
                            <br>
                            <button id="AddCuisTypeButton" class="button" type="button">Add</button>
                            <button id="RemoveCuisTypeButton" class="button" type="button">Remove</button>

                        </div>

                        <div class="span5 offset1">
                            <div class="input-prepend">
                                <span class="add-on">Price</span>
                                <input class="span9" id="InputCuisPirce" type="text" placeholder="New Price">

                            </div>
                            <div id="CuisinePriceTagsList">
                                <?php $TagsClass->outPutTags("Price","client_b2c.CuisineTags");?>
                            </div>
                            <br>
                            <button id="AddCuisPriceButton" class="button" type="button">Add</button>
                            <button id="RemoveCuisPriceButton" class="button" type="button">Remove</button>

                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>