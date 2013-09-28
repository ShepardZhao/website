$(document).ready(function(){


//register-ajax-modal
    $(function(){
        var $modal = $('#register-ajax-modal');

        $('#SignUp').on('click', function(){
            $('.initialDiv').fadeOut();
            // create the backdrop and wait for next modal to be triggered
            $('body').modalmanager('loading');

            setTimeout(function(){
                $modal.load('register/register.php', '', function(){
                    $modal.modal();
                });
            }, 1000);
        });

        $modal.on('click', '.mySubmit', function(){
            var email_str=/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z]+$/;
            var password_str=/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,20}$/;
            var email=$modal.find('#email').val();
            var passowrd=$modal.find('#password').val();
            var renpassword=$modal.find('#Repassword').val();
            var captcha=$modal.find('#captcha').val();
            if(!email_str.test(email)){
                AjaxMessageError("alert-error","The format of mail is not correct!");
                return false;
            }



            if (passowrd==="" || renpassword===""){
                AjaxMessageError("alert-error","The password cannot be empty!");
                return false;


            }
            else if(passowrd!=renpassword){
                AjaxMessageError("alert-error","The password does not match!");
                return false;

            }
            else if(password.length>20||passowrd.length<8){

                AjaxMessageError("alert-error","The password's lenght shoule be between 8 and 20");
                return false;


            }
            else if(renpassword.length>20||renpassword.length<8){

                AjaxMessageError("alert-error","The password's lenght shoule be between 8 and 20");
                return false;

            }
            else if(!password_str.test(password) && !password_str.test(renpassword)){

                AjaxMessageError("alert-error","The password has to have including numeric, capital letter and samll letter");
                return false;

            }
            else if(captcha===''){

                AjaxMessageError("alert-error","captcha cannot be empty");
                return false;

            }
            else if(!$("#RegisterAgreement").is(':checked')){

                AjaxMessageError("alert-error","You are not yet agreeing with our Register Policy!");
                return false;

            }
            else {

                var tmpArray={};
                tmpArray['RegisterUserMail']=email;
                tmpArray['RegisterUserPassWord']=renpassword;
                tmpArray['RegisterCaptcha']=captcha;
                AjaxRegisterProcess(tmpArray);


            }



        });
        function AjaxMessageError(className,info){

            $modal.modal('loading');
            setTimeout(function(){
                $modal
                    .modal('loading')
                    .find('.modal-body')
                    .prepend("<div class='alert " + className + " fade in'>" + info + "<button type='button' class='close' data-dismiss='alert'>x</button></div>");
            }, 1000);

        }

        function AjaxMessageSuccess(className,info){

            $modal.modal('loading');
            setTimeout(function(){
                $modal
                    .modal('loading')
                    .find('.modal-body').empty()
                    .prepend("<div class='alert " + className + " fade in'>" + info + "</div>");

            }, 1000);

        }
        function AjaxRegisterProcess(RegisterData,className,info){
            var request = $.ajax({
                url: "CMS/FrontEnd-controller/FrontEnd-controller.php",
                type: "POST",
                data:RegisterData,
                dataType: "html"
            });

            request.done(function( msg ) {
                if(msg==='Captcha Error'){
                    AjaxMessageError("alert-error","The Captcha are not match");
                    return false;

                }

                else if(msg==='Register Done'){
                    AjaxMessageSuccess('alert-info','Please Check your Email to active your account!');


                }
                else if(msg==='Repeated UserMail'){

                    AjaxMessageError("alert-error","The Email your filled that already existed");
                    return false;
                }


            });

            request.fail(function( jqXHR, textStatus ) {
                alert( "Request failed: " + textStatus );
            })



        }



    });




    //initial pop windows
    popup($('.initialDiv'));
    function popup(popupName){
        var _scrollHeight = $(document).scrollTop(),//get offset distance from pop windows to body windows
            _windowHeight = $(window).height(),//get  height from current windows
            _windowWidth = $(window).width(),//get width from current windows
            _popupHeight = popupName.height(),//get altitude
            _popupWeight = popupName.width();//get width
        _posiTop = (_windowHeight - _popupHeight)/2 + _scrollHeight;
        _posiLeft = (_windowWidth - _popupWeight)/2;
        popupName.css({"left": _posiLeft + "px","top":_posiTop + "px","display":"block"});
    }




//jquery bootstrap hacks
    $('.dropdown-menu').find('form').click(function (e) {
        e.stopPropagation();
    });








});



