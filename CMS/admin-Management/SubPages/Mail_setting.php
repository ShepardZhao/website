<div id="Mail_Setting">
    <div class="row-fluid">
        <div class="span12">
            <div class="divhead"><h4><i class="fa fa-list-alt">  The construct of User's valid Email</i><h4></div>
            <div class="basicInfo-box">
                <input class="input-xlarge" id='ConstructOfActiveMail' type="text" disabled value="<?php echo $BasicSettingClass->pushSettingData()['EMail'];?>">
                <input class="input-xxlarge" id='TitleOfConstructOfActiveMail' type="text" value="<?php echo $MailsettingClass->GetMailContentViaParam('ActivactionMail')['UserMailTitle'];?>" placeholder="Please put title here (i.e: Please Click below link to complete activation)">
                <br>
                <textarea class="ckeditor" cols="80" id="ConstructOfActiveMailContent" name="ConstructOfActiveMailContent" rows="10"><?php echo $MailsettingClass->GetMailContentViaParam('ActivactionMail')['UserMailConstructer'];?></textarea>
                <script type="text/javascript">
                    CKEDITOR.replace('ConstructOfActiveMailContent');//active the Ckeditor plugs via element
                </script>
                <br>
                <div class="alert alertFont">This part only build the construction of User's Mail that works on when user completed registertion and needed mail to valid</div>
                <button id="ConstructOfActiveMailButton" class="button" type="button">Submit</button>

            </div>
        </div>
    </div>
</div>