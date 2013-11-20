<div class="row-fluid">
    <form id="contactForm">
        <div class="span12 text-center">
            <h4 class="text-left">Contact Name</h4>
            <div class="form-horizontal">
                <!--Contact Name-->
                <div class="control-group">
                    <label class="control-label">Contact Name*:</label>
                    <div class="controls text-left">
                        <input type="text" class="span8" id="ContactName">
                    </div>
                </div>
                <!--Contract Number-->
                <div class="control-group">
                    <label class="control-label">Contact Number*:</label>
                    <div class="controls text-left">
                        <input type="text" class="span8" id="CustomerName" value="">
                    </div>
                </div>
                <!--Contact Email-->
                <div class="control-group">
                    <label class="control-label">Email*:</label>
                    <div class="controls text-left">
                        <input type="email" class="span8" id="ContactEmail" value="<?php echo $UserAndRes[0]->UserMail;?>" disabled>
                    </div>
                </div>

                <!--Contact content-->
                <div class="control-group">
                    <label class="control-label">Content*:</label>
                    <div class="controls text-left">
                        <textarea class="span12" style="height:100px" id="ContactContext"></textarea>
                    </div>
                </div>


            </div>
        </div>
        <button id="ContactSubmit" class="button" type="submit">Submit</button>
    </form>
</div>