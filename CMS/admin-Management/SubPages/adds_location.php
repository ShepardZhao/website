<div id="addsLocation">
    <div class="row-fluid">
        <div class="span12">
            <div class="divhead"><h4><i class="icon-list-ul">  Please Added Location below</i><h4></div>
            <div class="basicInfo-box">
                <div class="form-horizontal">
                    <div class="control-group">
                        <label class="control-label" >Please Input Root Location:</label>
                        <div class="controls">
                            <input type="text"  id="RootLocation" class="input-xlarge" name="RootLocation" placeholder="i.e: Sydney Hospital">
                            <input type="text"  id="RootLocationID" class="input" name="RootLocationID" placeholder="RR:The Root Location ID">
                        </div>
                        <br>

                        <div class="control-group">
                            <label class="control-label">upload root location's photo</label>
                            <div class="controls">
                                <input type="text" style="position:absolute" id="LocationImagePath" placeholder="Broswer file">
                                <input type="hidden" id="LocalHidePath" value="<?php echo GlobalPath;?>">
                                <form id="LocationForm" method="POST" enctype="multipart/form-data">
                                    <img id="LocationIMG" data-src="holder.js/260x180" alt="260x180" style="float:right;width: 260px; height: 180px;" src="data:image/png;base64,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">
                                    <input type="file" name="Input_LocationPhoto" style="opacity:0; position:relative" id="Input_LocationPhoto">
                                    <br>
                                    <button type="button" id="LocationsubmitPic" class="btn">Upload</button>
                                </form>
                                <label>only png, gif, jpg are accepted</label>
                            </div>
                        </div>

                        <button id="AddMoreSubLocation" class="button" type="button">More</button>
                    </div>

                    <div class="alert alertFont">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>Notes:</strong>You have to upload the root photo first then Add Root Location, then You may be able to add second level of location below
                    </div>

                    <div id="MarkRootLocation" class="control-group">
                        <label class="control-label">Sub Location:</label>
                        <div class="controls">
                            <input type="text" class="input-xlarge" name="SubLocation[]" placeholder="i.e: one of sub levels of locations" >
                            <input type="text" class="input" name="SubLocationID[]" placeholder="XX: The sub location ID" >

                        </div>
                    </div>
                </div>

                <button id="AddLocationButton" class="button" type="button">Add</button>


            </div>

        </div>
    </div>
    <div class="row-fluid">
        <div class="span12"></div>
        <div id="LocationlistTable">
            <?php $LocationClass->CmsDisplay();?><!--Locaiton Class that displays the all location from the database-->
        </div>

    </div>


</div>