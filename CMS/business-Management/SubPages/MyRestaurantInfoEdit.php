<div class="row-fluid">
    <form id="MyRestaurant">
        <div class="span12 text-left">
            <h4 class="text-left">Basic Infomation</h4>
            <div class="form-horizontal">
                <!--Restarurant ID-->
                <div class="control-group">
                    <label class="control-label">Restarurant ID:</label>
                    <div class="controls text-left">
                        <input type="text" class="span8" id="RestaruantID" value="<?php echo $_SESSION['RestaruantID'];?>" disabled>
                    </div>
                </div>
                <!--Restarurant Name-->
                <div class="control-group">
                    <label class="control-label">Restarurant Name:</label>
                    <div class="controls text-left">
                        <input type="text" class="span8" id="RestarurantName" value="<?php echo $Res[0]->ResName;?>">
                    </div>
                </div>
                <!--Restarurant Address-->
                <div class="control-group">
                    <label class="control-label">Restarurant Address:</label>
                    <div class="controls text-left">
                        <input type="text" class="span8" id="RestarurantAddress" value="<?php echo $Res[0]->ResAddress;?>">
                        <?php echo $LocationClass->GetRootLocationBySelectOption();?>
                    </div>
                </div>

                <!--Restarurant Contact Name-->
                <div class="control-group">
                    <label class="control-label">Contact Name:</label>
                    <div class="controls text-left">
                        <input type="text" class="span8" id="RestarurantContactName" value="<?php echo $UserAndRes[0]->UserName;?>">
                    </div>
                </div>

                <!--Restarurant Contact Number-->
                <div class="control-group">
                    <label class="control-label">Contact Number:</label>
                    <div class="controls text-left">
                        <input type="text" class="span8" id="RestarurantContactNumber" value="<?php echo $UserAndRes[0]->UserPhone;?>">
                    </div>
                </div>

                <!--Restarurant Email-->
                <div class="control-group">
                    <label class="control-label">Email:</label>
                    <div class="controls text-left">
                        <input type="text" class="span8" id="RestarurantEmail" value="<?php echo $UserAndRes[0]->UserMail;?>" disabled>
                    </div>
                </div>
                <!--Restarurant Tags-->
                <div class="control-group">
                    <label class="control-label">Restarurant Tags:</label>
                    <div class="controls text-left">
                        Avaliability
                        <?php echo $TagsClass->OupPutTagBySelecOption("Availability","client_b2c.CuisineTags");?>
                        Cuisine
                        <?php echo $TagsClass->OupPutTagBySelecOption("Cuisine","client_b2c.CuisineTags");?>
                        <span style="color:#c09853">Notes: Please selecting your tags carefully</span>

                    </div>
                </div>

                <!--Open hours-->
                <div class="control-group">
                    <label class="control-label">Opening Hour:</label>
                    <div class="controls text-left">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th></th>
                                <th>From</th>
                                <th>To</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>

                                <td id="Sunday">Sunday</td>
                                <td><input type="text" id="SunFrom" class="TimePicker TimeInputWiOutBoder" value="<?php echo $ResOpenUnSer->Sunday[0];?>"></td>
                                <td><input type="text" id="SunTo"  class="TimePicker TimeInputWiOutBoder" value="<?php echo $ResOpenUnSer->Sunday[1];?>"></td>
                            </tr>
                            <tr>
                                <td>Monday</td>
                                <td><input type="text" id="MonFrom" class="TimePicker TimeInputWiOutBoder" value="<?php echo $ResOpenUnSer->Monday[0];?>"></td>
                                <td><input type="text" id="MonTo" class="TimePicker TimeInputWiOutBoder" value="<?php echo $ResOpenUnSer->Monday[1];?>"></td>
                            </tr>
                            <tr>
                                <td>Tuesday</td>
                                <td><input type="text" id="TueFrom" class="TimePicker TimeInputWiOutBoder" value="<?php echo $ResOpenUnSer->Tuesday[0];?>"></td>
                                <td><input type="text" id="TueTo" class="TimePicker TimeInputWiOutBoder" value="<?php echo $ResOpenUnSer->Tuesday[1];?>"></td>
                            </tr>
                            <tr>
                                <td>Wednesday</td>
                                <td><input type="text" id="WedFrom" class="TimePicker TimeInputWiOutBoder" value="<?php echo $ResOpenUnSer->Wednesday[0];?>"></td>
                                <td><input type="text" id="WedTo" class="TimePicker TimeInputWiOutBoder" value="<?php echo $ResOpenUnSer->Wednesday[1];?>"></td>
                            </tr>
                            <tr>
                                <td>Thursday</td>
                                <td><input type="text" id="ThFrom" class="TimePicker TimeInputWiOutBoder" value="<?php echo $ResOpenUnSer->Thursday[0];?>"></td>
                                <td><input type="text" id="ThTo" class="TimePicker TimeInputWiOutBoder" value="<?php echo $ResOpenUnSer->Thursday[1];?>"></td>
                            </tr>
                            <tr>
                                <td>Friday</td>
                                <td><input type="text" id="FriFrom" class="TimePicker TimeInputWiOutBoder" value="<?php echo $ResOpenUnSer->Friday[0];?>"></td>
                                <td><input type="text" id="FriTo" class="TimePicker TimeInputWiOutBoder" value="<?php echo $ResOpenUnSer->Friday[1];?>"></td>
                            </tr>
                            <tr>
                                <td>Saturday</td>
                                <td><input type="text" id="SatFrom" class="TimePicker TimeInputWiOutBoder" value="<?php echo $ResOpenUnSer->Saturday[0];?>"></td>
                                <td><input type="text" id="SatTo" class="TimePicker TimeInputWiOutBoder" value="<?php echo $ResOpenUnSer->Saturday[1];?>"></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
            <button id="MyRestaruantSubmit" class="button" type="submit">Submit</button>

        </div>
    </form>


    <div class="row-fluid"><div class="span12"></div></div>
    <div class="row-fluid">
        <div class="span12 text-left">
            <?php if(!empty($Res[0]->ResPicPath)):?>
                <h4 class="text-left">Restaurant's photo upload (You already uploaded photo for your restaruant)</h4>
            <?php else:?>
                <h4 class="text-left">Restaurant's photo upload</h4>
            <?php endif?>
            <div class="form-horizontal">
                <!--Restarurant Photo-->
                <div class="control-group">
                    <label class="control-label">Photo:</label>
                    <div class="controls text-left">
                        <input type="text" style="position:absolute" id="RestaurantImagePath" placeholder="Broswer file">
                        <input type="hidden" id="gobalPath" value="<?php echo GlobalPath;?>">
                        <form id="BusinessPhotoForm" method="POST" enctype="multipart/form-data">
                            <input type="file" name="Input_Restaurantavatar" style="opacity:0; position:relative" id="Input_Restaurantavatar">
                            <br>
                            <button type="button" id="submitPic" class="btn">Upload</button>
                            <br>
                        </form>
                        <?php if(empty($Res[0]->ResPicPath)):?>
                            <img id="RestaruantPic" data-src="holder.js/260x180" alt="260x180" style="width: 260px; height: 180px;margin-top: -82px;margin-left: 290px;margin-bottom:19px;" src="data:image/png;base64,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">
                        <?php else:?>
                            <img id="RestaruantPic" data-src="holder.js/260x180" alt="260x180" style="width: 260px; height: 180px;margin-top: -82px;margin-left: 290px;margin-bottom:19px;" src="<?php echo $Res[0]->ResPicPath;?>">
                        <?php endif?>

                        <label class="alert alert-info">*The photo represents the restaruant, only png, gif, jpg are accepted</label>
                    </div>
                    <button id="UploadRestaurantPhoto" class="button" type="submit">Submit</button>

                </div>
            </div>
        </div>
    </div>



</div>