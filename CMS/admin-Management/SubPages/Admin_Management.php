<div id="adminMangement">
    <div class="row-fluid">
        <div class="span12">
            <div class="divhead"><h4><i class="fa fa-list-alt">  Administrator Management</i><h4></div>
            <div class="basicInfo-box">
                <div class="form-horizontal">
                    <div class="control-group">
                        <label class="control-label">Administrator ID:</label>
                        <div class="controls">
                            <input type="text" id="Input_AdministratorID" disabled value='<?php  echo $UserClass->ReadAdministraorInfo()['UserID'];?>' >
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Administrator Name:</label>
                        <div class="controls">
                            <input type="text" id="Input_Administrator" value='<?php  echo $UserClass->ReadAdministraorInfo()['UserName'];?>'>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Administrator Password:</label>
                        <div class="controls">
                            <input type="password" id="inputPassword" placeholder="Please input new password here">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Administrator Email:</label>
                        <div class="controls">
                            <input type="text" id="Input_AdministratorEmail" value="<?php echo $BasicSettingClass->pushSettingData()['EMail'];?>" disabled>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Administrator Phone:</label>
                        <div class="controls">
                            <input type="text" id="Input_AdministratorPhone" placeholder="Please input administrator's phone">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">User Type:</label>
                        <div class="controls">
                            <input type="text" id="Input_FixedAdministratorType" Value="Administrator" disabled>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Please upload Administrator's photo</label>
                        <div class="controls">
                            <input type="text" style="position:absolute" id="AdministratorImagePath" placeholder="Broswer file">
                            <input type="hidden" id="gobalPath" value="<?php echo GlobalPath;?>">

                            <form id="adminForm" method="POST" enctype="multipart/form-data">
                                <input type="file" name="Input_AdministratorPhoto" style="opacity:0; position:relative" id="Input_AdministratorPhoto">
                                <br>
                                <button type="button" id="submitPic" class="btn">Upload</button>
                            </form>
                            <label>*The photo will be used on comment, only png, gif, jpg are accepted</label>
                        </div>
                    </div>

                    <button id="SubmitAdministratorInfo" class="button" type="button">Submit</button>

                </div>

            </div>
        </div>

    </div>
</div>