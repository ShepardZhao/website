<div id="basicInfo">
    <div class="row-fluid">
        <div class="span12">
            <div class="divhead"><h4><i class="fa fa-list-alt">  Basic System Management</i><h4></div>
            <div class="basicInfo-box">
                <div class="form-horizontal">

                    <div class="control-group">
                        <label class="control-label" >The Name Of website:</label>
                        <div class="controls">
                            <input type="text"  class="inputBg" id="SiteName" value="<?php echo $BasicSettingClass->pushSettingData()['WebTitle'];?>">
                        </div>
                    </div>



                    <div class="control-group">
                        <label class="control-label">The Description of WebSite:</label>
                        <div class="controls">
                            <textarea rows="3" id="SiteDescr"><?php echo $BasicSettingClass->pushSettingData()['WebDescription'];?></textarea>
                        </div>
                    </div>


                    <div class="control-group">
                        <label class="control-label">Site Url:</label>
                        <div class="controls">
                            <input type="text" id="SiteUrl" value="<?php echo $BasicSettingClass->pushSettingData()['WebUrl'];?>">
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Email:</label>
                        <div class="controls">
                            <input type="text" id="SiteEmail" value="<?php echo $BasicSettingClass->pushSettingData()['EMail'];?>">
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Policy:</label>
                        <div class="controls">
                            <textarea class="span12" style="height:100px" id="SitePolicy"><?php echo $BasicSettingClass->pushSettingData()['WebPolicy'];?></textarea>
                        </div>
                    </div>



                    <div class="control-group">
                        <label class="control-label">SiteStatus:</label>
                        <div class="controls">
                            <select id="SiteStatus" class="span2 inputBg">
                                <option>Running</option>
                                <option>Stop</option>
                            </select>
                        </div>
                    </div>
                    <button id="BasicInforSaving" class="button" type="button">Save</button>
                </div>



            </div>
        </div>

    </div>

</div>