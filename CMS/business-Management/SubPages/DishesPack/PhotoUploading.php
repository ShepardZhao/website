<?php require_once '../../../GobalConnection.php'?>
<?php if(isset($_GET['CuID'])):?>
<?php $CuisinePhoto=json_decode($CuisineClass->ReturnDataOfNormalCuisineByID($_GET['CuID']));?>
    <div class="modal-header text-center">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3>Cuisine's Photo uploading</h3>
    </div>
    <div class="modal-body">
        <img id="showsCuisinePhoto" alt="Please select the region that you want to crop" style="width: 100%; height: 100%;" src="<?php echo GlobalPath?>/assets/framework/img/Image_upload_placeholder.jpg">
        <div id="progress_bar"  class="hide" style="padding-top:40%;padding-bottom:40%;">
            <div class="progress progress-striped active">
                <div class="bar" style="width: 100%;"></div>
            </div>
        </div>
            <div class="row-fluid">
            <div class="span12 text-left">
                <br>
               <label class="alert alert-waring">Step 1: You need to upload original photo first</label>
                </div>
                <div class="form-horizontal">
                    <!--Restarurant Photo-->
                    <div class="control-group text-left">
                            <input type="hidden" id="gobalPath" value="<?php echo GlobalPath;?>">

                        <form id="CuisinePhotoForm" method="POST" enctype="multipart/form-data">

                            <input type="file" class="span9" name="Input_Cuisineavatar" style="opacity:0; position:relative;z-index:1000;margin-bottom:9px" id="Input_Cuisineavatar">
                            <input type="text" class="span9" style="position:absolute;left:1em;" id="CuisineImagePath" placeholder="Broswer file">

                            <br>
                                <button type="button" id="submitCuisinePic" class="btn">Upload</button>
                                <br>
                                <br>
                                <input type="hidden" id="GetCurrentCuid" value="<?php echo $_GET['CuID']?>">
                                <input type="hidden" id="absolutePath">
                                <input type="hidden" id="encryptedName">
                                <input type="hidden" id="GetFinalPhotoPath">
                                <input type="hidden"  id="x" name="x" />
                                <input type="hidden"  id="y" name="y" />
                                <input type="hidden"  id="w" name="w" />
                                <input type="hidden"  id="h" name="h" />
                            </form>
                            <label class="alert alert-waring">Step 2: Select the area that you want to use (the selected area has been setup to fixed 240px of  width. After you confirm your selction, you should click bleow 'save' button to save the crop image)</label>

                            <label class="checkbox">
                            <input type="checkbox" id="WaterMarkerCheckbox" value="no">
                                    Whether added WaterMarker
                             </label>

                        <label class="radio offset1 span10" >
                            <input type="radio" name="WaterMarkerPosition"  class="WaterMarkerPosition" value="1"  disabled>
                            WaterMarker Position--1 Top Left
                        </label>

                        <label class="radio offset1 span10" >

                        <input type="radio" name="WaterMarkerPosition"  class="WaterMarkerPosition" value="5" disabled >
                            WaterMarker Position--2 Middle
                        </label>
                        <label class="radio offset1 span10" >
                            <input type="radio" name="WaterMarkerPosition"  class="WaterMarkerPosition" value="3" disabled>
                            WaterMarker Position--3 Top Right
                        </label>
                        <label class="radio offset1 span10" >
                        <input type="radio" name="WaterMarkerPosition" class="WaterMarkerPosition"  value="7" disabled>
                            WaterMarker Position--4 Bottom Left
                        </label>
                        <label class="radio offset1 span10" >

                        <input type="radio" name="WaterMarkerPosition" class="WaterMarkerPosition"  value="9" disabled>
                            WaterMarker Position--5 Bottom Right
                        </label>




                        <div class="row-fluid">
                            <div class="span12">
                        <label class="alert alert-waring">Step 3: You have to select one of above options, then you may exeute step 3 to crop and Preview</label>
                               </div>
                            </div>
                        <button type="button" id="ConfrimSelection" class="btn">Crop</button>
                            <button type="button" id="PreviewSelectedImage" data-toggle="modal" href="#Preview" class="btn" disabled>Preview</button>

                    </div>
                </div>
            </div>


        <div class="control-group text-center">
            <button type="button" id="CuisinePhotoUploading" class="mySubmit"  aria-hidden="true">Save</button>
        </div>
        </div>






    <div id="Preview" class="modal hide fade" tabindex="-1" data-focus-on="input:first">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3>Photo Preivew</h3>
        </div>
        <div class="modal-body">
        <div class="text-center">
            <img id="PreviewCuisinePhoto"/>
        </div>

        </div>

    </div>



<?php else:?>
<?php endif?>