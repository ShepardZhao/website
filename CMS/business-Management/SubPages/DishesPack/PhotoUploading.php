<?php require_once '../../../GobalConnection.php'?>
<?php if(isset($_GET['CuID'])):?>
<?php $CuisinePhoto=json_decode($CuisineClass->ReturnDataOfNormalCuisineByID($_GET['CuID']));?>
    <div class="modal-header text-center">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3>Cuisine's Photo uploading</h3>
    </div>
    <div class="modal-body">
        <img id="showsCuisinePhoto" data-src="holder.js/700" alt="Please select the region that you want to crop" style="width: 100%; height: 100%;" src="data:image/png;base64,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">
          <div class="row-fluid">
            <div class="span12 text-left">
                <br>
               <label class="alert alert-waring">Step 1: You need to upload original photo first</label>
                </div>
                <div class="form-horizontal">
                    <!--Restarurant Photo-->
                    <div class="control-group text-left">
                            <input type="text" class="span9" style="position:absolute" id="CuisineImagePath" placeholder="Broswer file">
                            <input type="hidden" id="gobalPath" value="<?php echo GlobalPath;?>">
                            <form id="CuisinePhotoForm" method="POST" enctype="multipart/form-data">
                                <input type="file" class="span9" name="Input_Cuisineavatar" style="opacity:0; position:relative" id="Input_Cuisineavatar">
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
                            <input type="checkbox" id="WaterMarkerCheckbox">
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
        </div>

    </div>
    <div class="control-group text-center">
        <button type="button" id="CuisinePhotoUploading" class="mySubmit"  aria-hidden="true">Save</button>
    </div>





    <div id="Preview" class="modal hide fade" tabindex="-1" data-focus-on="input:first">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3>Photo Preivew</h3>
        </div>
        <div class="modal-body">
        <div class="text-center">
            <img id="PreviewCuisinePhoto">
        </div>

        </div>

    </div>



<?php else:?>
<?php endif?>