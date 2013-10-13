<div class="row-fluid">
    <form id="AccountForm">
        <div class="span12 text-left">
            <h4 class="text-left">Account Management</h4>
            <div class="form-horizontal">

                <!--Account Email-->
                <div class="control-group">
                    <label class="control-label">Account Email:</label>
                    <div class="controls text-left">
                        <input type="email" class="span8" id="AccountEmail" value="<?php echo $UserAndRes[0]->UserMail;?>" disabled>
                    </div>
                </div>
                <!--Contact Name-->
                <div class="control-group">
                    <label class="control-label">Old Password:</label>
                    <div class="controls text-left">
                        <input type="password" class="span8" id="OldPassword">
                    </div>
                </div>
                <!--Contract Number-->
                <div class="control-group">
                    <label class="control-label">New Password:</label>
                    <div class="controls text-left">
                        <input type="password" class="span8" id="NewPassword" value="">
                    </div>
                </div>
            </div>
            <button id="AccountSubmit" class="button" type="submit">Submit</button>

        </div>
    </form>
</div>