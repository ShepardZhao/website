<?php require_once '../CMS/GobalConnection.php';?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
    <h3 class="text-center">Sign Up with Email</h3>
</div>
<div class="modal-body">
    <form id="SignUpForm">

    <div class="control-group ">
    <input class="input-block-level RegSize" id="email" type="email" placeholder="E-mail">
    </div>

    <div class="control-group">
    <input class="input-block-level RegSize" id="password" type="password" placeholder="Password">
    </div>

    <div class="control-group">
    <input class="input-block-level RegSize" id="Repassword" type="password" placeholder="Re-Input Passowrd">
    </div>
    <div class="control-group">
        <input class="input-block-level RegSize" id="captcha" type="text" placeholder="Please input below text">
        <img src="<?php echo GlobalPath;?>/register/captcha_code_file.php?rand=<?php echo rand();?>" id='captchaimg'><a href='javascript: refreshCaptcha();'>Can't see it? click here</a>


    </div>
    <div class="input-prepend input-group">
         <div class="controls">
                <label class="checkbox ">
                    <input type="checkbox" id="RegisterAgreement"><a data-toggle="modal" href="#Argement"> Agree and read me</a>
                </label>
            </div>
        </div>
        <div id="Argement" class="modal hide fade" tabindex="-1" data-focus-on="input:first">
            <div class="modal-header">
                <h3>Data Use Policy</h3>
            </div>
            <div class="modal-body">
                <p><?php echo $BasicSettingClass->pushSettingData()['WebPolicy'];?></p>

            </div>
            <div class="control-group text-center">
                <button type="botton"  data-dismiss="modal" class="mySubmit"  aria-hidden="true">ok</button>
            </div>
        </div>

    <div class="control-group text-center">
    <button type="botton" class="mySubmit" id="mySubmit">Next</button>
    </div>

   </form>

</div>

<script type='text/javascript'>
    function refreshCaptcha()
    {
        var img = document.images['captchaimg'];
        img.src = img.src.substring(0,img.src.lastIndexOf("?"))+"?rand="+Math.random()*1000;
    }
</script>
