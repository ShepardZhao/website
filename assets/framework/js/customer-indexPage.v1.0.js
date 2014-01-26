$(document).ready(function(){
    if (!window.location.origin) {
        window.location.origin = window.location.protocol + "//" + window.location.hostname + (window.location.port ? ':' + window.location.port: '');
    }
    //lazy image
    var isDisplay=true;
    window.CurrentDomain=window.location.origin;
 //common area
    //infformation display that whaterever message with error or waring or other things
   window.InformationDisplay=function (_content,_class){
    if(isDisplay){
    $('<div class="alert '+_class+'">'+_content+'</div>').fadeIn().appendTo($('.information-bar'));
       var getwidth=$('.information-bar').width()/2;
       $('.information-bar').css('margin-left','-'+ getwidth+'px');
       $('.information-bar').css('display','block');
       isDisplay=false;
    }
       setTimeout(function(){$('.'+_class).fadeOut();$('.information-bar').fadeOut(); isDisplay=true;},5000);
    }
//common window pop out
     function popup (popupName){
        var _scrollHeight = $(document).scrollTop(),//get offset distance from pop windows to body windows
            _windowHeight = $(window).height(),//get height from current windows
            _windowWidth = $(window).width(),//get width from current windows
            _popupHeight = popupName.height(),//get altitude
            _popupWeight = popupName.width();//get width
        _posiTop = (_windowHeight - _popupHeight)/2 + _scrollHeight;
        _posiLeft = (_windowWidth - _popupWeight)/2;
        popupName.css({"left": _posiLeft + "px","top":_posiTop + "px","display":"block"});
    }


 //common modal
    window.$modal=$('#ajax-modal');



    $(function(){

        var email_str=/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z]+$/;

//Froget password
        $('.ForgetPassword').on('click',function(){
            $('body').modalmanager('loading');
            setTimeout(function(){
                $modal.load(CurrentDomain+'/ForgetPasswrod/ForgetPassword.php', '', function(){
                    $modal.modal();
                });
            }, 1000);

        });

        $modal.on('click', '#GetPassword', function(){
            var email=$modal.find('#email').val();
            if(!email_str.test(email)){
                AjaxMessageError("alert-error","The format of mail is not correct!");
                return false;
            }

        });


        $('body').on('click','.AddedNewAddress',function(){
            $('body').modalmanager('loading');
            setTimeout(function(){
                $modal.load(CurrentDomain+'/CMS/customer-Management/SubPages/AddedNewAddress.php', '', function(){
                    $modal.modal();
                });
            }, 1000);

        });
     $modal.on('submit','#addNewAddressForm',function(e){
         var AddedUserID=$('#GetUserID').val();
         var AddedNickName=$('#AddedNickName').val();
         var AddedPhone=$('#AddedPhone').val();
         var AddedExactlyAddress=$('#AddedExactlyAddress').val();
         var AddedSubAddress=$('#AddedSubAddress').val();
         var AddedRootAddress=$('#AddedRootAddress').val();

         if(AddedPhone==='' || AddedRootAddress==='' || AddedExactlyAddress===''){
             AjaxMessageError("alert-error","You have to fill all fields");
             return false;
         }
         else{
             var AddedNewAddressData={};
             AddedNewAddressData['AddedUserID']=AddedUserID;
             AddedNewAddressData['AddedNickName']=AddedNickName;
             AddedNewAddressData['AddedPhone']=AddedPhone;
             AddedNewAddressData['AddedAddress']=AddedExactlyAddress+', '+AddedSubAddress+', '+AddedRootAddress;


             $('.address').empty().append('<img src='+CurrentDomain+'/assets/framework/img/ajax-loader.gif>').fadeIn();
             var request = $.ajax({
                 url: CurrentDomain+"/CMS/FrontEnd-controller/FrontEnd-controller.php",
                 type: "POST",
                 data:AddedNewAddressData,
                 dataType: "html"
             });

             request.done(function( msg ) {
                 if (msg==='Repeated Addressbook'){
                     AjaxMessageError("alert-error","Repeated Addressbook");
                      return false;
                 }
                 else {
                     AjaxMessageSuccess('alert-info','You have successfully added an new address!');
                     setTimeout(function(){$('#ajax-modal').modal('hide');},3000);
                     $('.address').empty().append(msg);
                     $('#switchArrow').find('.fa-arrow-circle-o-down').removeClass('fa-arrow-circle-o-down').addClass('fa-arrow-circle-o-right');

                 }
             });
             request.fail(function( jqXHR, textStatus ) {
                 alert( "Request failed: " + textStatus );
             });


         }


         return false;


     });





//register-ajax-modal

        $('#SignUp').on('click', function(){
            $('.initialDiv').fadeOut();
            // create the backdrop and wait for next modal to be triggered
            $('body').modalmanager('loading');

            setTimeout(function(){
                $modal.load(CurrentDomain+'/register/register.php', '', function(){
                    $modal.modal();
                });
            }, 1000);
        });

        $modal.on('submit', '#SignUpForm', function(e){
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
                tmpArray['RegisterPhotoPrefix']=CurrentDomain;
                console.log(tmpArray);
                AjaxRegisterProcess(tmpArray);


            }

        return false;

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
                url: CurrentDomain+"/CMS/FrontEnd-controller/FrontEnd-controller.php",
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

                    AjaxMessageError("alert-error","The Email your filled that already existed, if you have facebook acctount you can login in straight away.");
                    return false;
                }


            });

            request.fail(function( jqXHR, textStatus ) {
                alert( "Request failed: " + textStatus );
            });



        }



    });




    //initial pop windows
    popup($('.initialDiv'));


    //initial select root location
    $('body').on('click','.thumClick li',function(){
        $('.thumClick li').removeClass('SelectThumClick');
        $(this).addClass('SelectThumClick');

    });
    //initial select sub location
    $('body').on('click','.SubLocationGroup>li>a',function(){
        $('.SubLocationGroup>li>a').removeClass('Sublocation_style');
        $(this).addClass('Sublocation_style');

    });

    //select root location

    $('body').on('click','.thumClick>li',function(){
        window.ID=$(this).find('.hidenLocationID').attr('id');

    });

    //Select sub array

    $('body').on('click','.SubLocationGroup>li',function(){
        window.SubID=$(this).find('.sublocation_hiden').val();

    });


    //pass parameters to Feathured
    $('body').on('click','#SelectSubLocation',function(){
        $modal.modal('loading');
        window.location = CurrentDomain+'/Feathured?RootID='+ID+'&SubID='+SubID;

    });



    $('body').on('click','#SelectRootLocation',function(){
        var tmp={};
        tmp['RootIDSelection']=ID;
        $('.thumbnailsWrap').empty().append('<img src='+CurrentDomain+'/assets/framework/img/ajax-loader.gif>');
        var request = $.ajax({
            url: CurrentDomain+"/CMS/FrontEnd-controller/FrontEnd-controller.php",
            type: "POST",
            data:tmp,
            dataType: "html"
        });
        request.done(function( msg ) {

            $('.thumbnailsWrap').empty().append(msg);
        });

        request.fail(function( jqXHR, textStatus ) {
            alert( "Request failed: " + textStatus );
        });

    });


//jquery bootstrap hacks
    $('.dropdown-menu').find('#login-area').click(function (e) {
        e.stopPropagation();
    });

//jquery serach width change
    $(function(){setTimeout(onWidthChange,1);});

    function onWidthChange()
    {
        if( $(window).width() > 600 ) {
            $(function(){
                var width=$('.container-fluid').width();
                var serachWidth=width-555;
                $('.searchItem').width(serachWidth);
            });
        }
        setTimeout(onWidthChange,1);
    }


//normal user login
    $('#login-area').submit(function(e){
       $('#loginedInButton').empty().append('<img src="../assets/framework/img/ajax-loader.gif">');
        var LoginedInEmail=$('#inputEmail').val();
        var LoginedInPassword=$('#inputPassword').val();
        if(LoginedInEmail!=='' && LoginedInPassword!=='' ){
            var TmpArray={};
            TmpArray['LoginedInEmail']=LoginedInEmail;
            TmpArray['LoginedInPassword']=LoginedInPassword;

            AjaxRegisterProcess(TmpArray);

         }
        else if (LoginedInEmail==='' || LoginedInPassword==='' ){
            InfoAlert('#infoHead','Password or Mail cannot be empty!');
            $('#loginedInButton').empty().append('Submit');

        }



        function AjaxRegisterProcess(RegisterData){
            var request = $.ajax({
                url: CurrentDomain+"/CMS/FrontEnd-controller/FrontEnd-controller.php",
                type: "POST",
                data:RegisterData,
                dataType: "html"
            });
            request.done(function( msg ) {
                if(msg==='pass'){
                $('#loginedInButton').empty().append('Wait..');
                window.location.reload();//reload the page if the uer login
                }

                else if(msg==='NoMatch'){
                    $('#loginedInButton').empty().append('Submit');
                    InfoAlert('#infoHead','Sorry, Cannot find your Info');

                }



            });

            request.fail(function( jqXHR, textStatus ) {
                alert( "Request failed: " + textStatus );
            });
        }

        function InfoAlert(id,inform){
            $('<label class="alert alert-error" >'+inform+'</label>').insertBefore($(id)).fadeIn(200);
            setTimeout(function(){$('.alert-error').fadeOut(); },5000);

        }

        return false;

    });



});

$(window).load(function(){

    /***************************************Feature part************************************************/

    var TagAvailableWidth=getMaxLiWidth('.TagAvailable li');
    var TagCuisineWidth=getMaxLiWidth('.TagCuisine li');
    var TagTypeWidth=getMaxLiWidth('.TagType li');
    var TagPriceWidth=getMaxLiWidth('.TagPrice li');


    if (TagAvailableWidth>$('.TagAvailable').width()){
        $('#TagAvailablepPosition').fadeIn();
    }
    if (TagCuisineWidth>$('.TagCuisine').width()){
        $('#TagCuisinePosition').fadeIn();
    }
    if (TagTypeWidth>$('.TagType').width()){
        $('#TagTypePosition').fadeIn();
    }
    if (TagPriceWidth>$('.TagPrice').width()){
        $('#TagPricePosition').fadeIn();

    }


    //get total width
    function getMaxLiWidth(getli){
        var totalWidth=0;
        $(getli).each(function() {
            totalWidth += parseInt($(this).width());
        });
        return totalWidth;
    }

    //scroll down
    $('body').on('click','.fa-arrow-circle-o-down',function(){

        //TagAvailable
        if($(this).parent().parent().find('.TagAvailable')){
            $(this).parent().parent().find('.TagAvailable').animate({scrollTop  : "50px"},500);
        }
        //TagCuisine switch
        if($(this).parent().parent().find('.TagCuisine')){
            $(this).parent().parent().find('.TagCuisine').animate({scrollTop  : "50px"},500);
        }

        //TagType switch
        if($(this).parent().parent().find('.TagType')){
            $(this).parent().parent().find('.TagType').animate({scrollTop  : "50px"},500);
        }

        //TagPrice switch
        if($(this).parent().parent().find('.TagPrice')){
            $(this).parent().parent().find('.TagPrice').animate({scrollTop  : "50px"},500);
        }


    });


    //scroll up
    $('body').on('click','.fa-arrow-circle-o-up',function(){
        //TagAvailable
        if($(this).parent().parent().find('.TagAvailable')){
            $(this).parent().parent().find('.TagAvailable').animate({scrollTop  : "-43px"},500);
        }

        //TagCuisine switch
        if($(this).parent().parent().find('.TagCuisine')){
            $(this).parent().parent().find('.TagCuisine').animate({scrollTop  : "-43px"},500);
        }

        //TagType
        if($(this).parent().parent().find('.TagType')){
            $(this).parent().parent().find('.TagType').animate({scrollTop  : "-43px"},500);
        }

        //TagPrice
        if($(this).parent().parent().find('.TagPrice')){
            $(this).parent().parent().find('.TagPrice').animate({scrollTop  : "-43px"},500);
        }


    });






});



