<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
    <h3 class="text-center">Sign Up with Email</h3>
</div>
<div class="modal-body">


    <div id="SignUpForm">

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
        <img src="register/captcha_code_file.php?rand=<?php echo rand();?>" id='captchaimg'><a href='javascript: refreshCaptcha();'>Can't see it? click here</a>


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
                <p>Information we receive and how it is used
                    Learn about the types of information we receive, and how that information is used.
                    Sharing and finding you on Facebook
                    Get to know the privacy settings that help you control your information on facebook.com.
                    Other websites and applications
                    Learn about things like social plugins and how information is shared with the games, applications and websites you and your friends use off Facebook.
                    How advertising and Sponsored Stories work
                    See how ads are served without sharing your information with advertisers, and understand how we pair ads with social context, such as newsfeed-style stories.
                    Cookies, pixels and other system technologies
                    Find out how cookies, pixels and tools (like local storage) are used to provide you with services, features and relevant ads and content.
                    Some other things you need to know
                    Learn how we make changes to this policy and more.</p>

            </div>
            <div class="control-group text-center">
                <button type="botton"  data-dismiss="modal" class="mySubmit"  aria-hidden="true">ok</button>
            </div>
        </div>

    <div class="control-group text-center">
    <button type="botton" class="mySubmit">Next</button>
    </div>

   </div>

</div>

<script type='text/javascript'>
    function refreshCaptcha()
    {
        var img = document.images['captchaimg'];
        img.src = img.src.substring(0,img.src.lastIndexOf("?"))+"?rand="+Math.random()*1000;
    }
</script>
