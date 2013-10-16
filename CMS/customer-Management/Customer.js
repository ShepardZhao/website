$(document).ready(function(){
    var CurrentDomain=window.location.origin;


    // onready go to the tab requested in the page hash
    $(function(){setTimeout(gotoHashTab(),1000);});

    var gotoHashTab = function (customHash) {
        var hash = customHash || location.hash;
        var hashPieces = hash.split('?'),
            activeTab = $('[href=' + hashPieces[0] + ']');
        activeTab && activeTab.tab('show');
        setTimeout(gotoHashTab,1000);

    }
    gotoHashTab();
    // when the nav item is selected update the page hash
    $('.nav a').on('shown', function (e) {
        window.location.hash = e.target.hash;
    })

    // when a link within a tab is clicked, go to the tab requested
    $('.tab-pane a').click(function (event) {
        if (event.target.hash) {
            gotoHashTab(event.target.hash);
        }
    });



    /**************************************remove mybook address Ajax******************************/
    function RemoveAddressAddBookAJAX(data,infoid){
        var request = $.ajax({
            url: CurrentDomain+"/CMS/BackEnd-controller/BackEnd-controller.php",
            type: "POST",
            data:data,
            dataType: "html"
        });

        request.done(function( msg ) {
            if(msg==='Error'){
                $('<div class="alert alert-info">Data Base Error</div>').insertBefore($(infoid)).fadeIn(200);
                setTimeout(function(){$('.alert-info').fadeOut(); },3000);

            }
            else{
                $('.thumbnails').empty().append(msg);
                $('<div class="alert alert-info">Removed Successfully</div>').insertAfter($(infoid)).fadeIn(200);
                setTimeout(function(){$('.alert-info').fadeOut(); },3000);
            }


        });

        request.fail(function( jqXHR, textStatus ) {
            alert( "Request failed: " + textStatus );
        });




    }

    /**************************************Set Default mybook address Ajax******************************/
    function SetDeafultAddressAddBookAJAX(data,infoid){
        var request = $.ajax({
            url: CurrentDomain+"/CMS/BackEnd-controller/BackEnd-controller.php",
            type: "POST",
            data:data,
            dataType: "html"
        });

        request.done(function( msg ) {
            if(msg==='Error'){
                $('<div class="alert alert-info">Data Base Error</div>').insertBefore($(infoid)).fadeIn(200);
                setTimeout(function(){$('.alert-info').fadeOut(); },3000);

            }
            else{
                $('.thumbnails').empty().append(msg);
                $('<div class="alert alert-info">Successfully sets my default address book</div>').insertAfter($(infoid)).fadeIn(200);
                setTimeout(function(){$('.alert-info').fadeOut(); },3000);
            }
        });

        request.fail(function( jqXHR, textStatus ) {
            alert( "Request failed: " + textStatus );
        });




    }








    /****************************************Added mybook address Ajax*****************************/
    function AddressAddBookAJAX(data,infoid){
        var request = $.ajax({
            url: CurrentDomain+"/CMS/BackEnd-controller/BackEnd-controller.php",
            type: "POST",
            data:data,
            dataType: "html"
        });

        request.done(function( msg ) {
            if(msg==='Repeated Addressbook'){
                $('<div class="alert alert-info">You already added these info to your address book</div>').insertBefore($(infoid)).fadeIn(200);
                setTimeout(function(){$('.alert-info').fadeOut(); },3000);
            }

            else if(msg==='Error'){
                $('<div class="alert alert-info">Data Base Error</div>').insertBefore($(infoid)).fadeIn(200);
                setTimeout(function(){$('.alert-info').fadeOut(); },3000);

            }
            else{
                $('.thumbnails').empty().append(msg);
                $('<div class="alert alert-info">Added new info to My addressbook</div>').insertBefore($(infoid)).fadeIn(200);
                setTimeout(function(){$('.alert-info').fadeOut(); },3000);
            }


        });

        request.fail(function( jqXHR, textStatus ) {
            alert( "Request failed: " + textStatus );
        });
    }


    /****************************************proflie Ajax*****************************/
    function ProfileAJAX(data,infoid){
        var request = $.ajax({
            url: CurrentDomain+"/CMS/BackEnd-controller/BackEnd-controller.php",
            type: "POST",
            data:data,
            dataType: "html"
        });

        request.done(function( msg ) {

            if(msg==='Updated successfully'){
                $('<div class="alert alert-info">Updated successfully</div>').insertBefore($(infoid)).fadeIn(200);
                setTimeout(function(){$('.alert-info').fadeOut(); },3000);
            }
            else if (msg==='Successfully added myaddressbook'){

                $('<div class="alert alert-info">Added new record to your address book</div>').insertBefore($(infoid)).fadeIn(200);
                setTimeout(function(){$('.alert-info').fadeOut(); },3000);

            }
            else if(msg==='Changed password successfully'){
                $('<div class="alert alert-info">Changed Password successfully</div>').insertBefore($(infoid)).fadeIn(200);
                setTimeout(function(){$('.alert-info').fadeOut(); },3000);
            }
            else if(msg==='Updated error'){
                $('<div class="alert alert-info">Updated Error</div>').insertBefore($(infoid)).fadeIn(200);
                setTimeout(function(){$('.alert-info').fadeOut(); },3000);

            }
            else if(msg==='Repeated Addressbook'){
                $('<div class="alert alert-info">You already added these info to your address book</div>').insertBefore($(infoid)).fadeIn(200);
                setTimeout(function(){$('.alert-info').fadeOut(); },3000);
            }
            else if(msg==='fail'){

                $('<div class="alert alert-info">The old password is not match to your input</div>').insertBefore($(infoid)).fadeIn(200);
                setTimeout(function(){$('.alert-info').fadeOut(); },3000);
            }
            else if(msg==='Error'){
                $('<div class="alert alert-info">Data Base Error</div>').insertBefore($(infoid)).fadeIn(200);
                setTimeout(function(){$('.alert-info').fadeOut(); },3000);

            }


        });

        request.fail(function( jqXHR, textStatus ) {
            alert( "Request failed: " + textStatus );
        });




    }





    var GetCustomerUserID=$('#CustomerID').val();


    /***************************************Add My address book************************************/
    $('body').on('click','#AddressBookButton',function(){
        var AddNickName=$('#AddNickName').val();
        var AddPhone=$('#AddPhone').val();
        var AddAdress=$('#AddAdress').val();
        var AddSubLocation=$('#AddSubLocation').val();
        var AddRootLocation=$('#AddRootLocation').val();
        if(AddNickName===''||AddPhone==='' || AddAdress===''){
            $('<div class="alert alert-error">You have to fill all fields</div>').insertBefore($('#AddressBookButton')).fadeIn(200);
            setTimeout(function(){$('.alert-error').fadeOut(); },3000);
        }
        else{
            var tmp={};
            tmp['AddNickName']=AddNickName;
            tmp['AddPhone']=AddPhone;
            tmp['AddAdress']=AddAdress+', '+AddSubLocation+', '+AddRootLocation;
            tmp['GetCustomerUserID']=GetCustomerUserID;
            AddressAddBookAJAX(tmp,'#AddressBookButton');
        }
    });



    /****************************************Customer Profile************************/
//basic info updating
    $('body').on('click','#BasicCustomerButton',function(){
        var GetCustomerName=$('#CustomerName').val();
        var GetCustomerFirstName=$('#CustomerFirstName').val();
        var GetCustomerLastName=$('#CustomerLastName').val();
        var GetCustomerPhone=$('#CustomerPhone').val();
        var GetCustomerMail=$('#CustomerMail').val();
        var GetCustomerAddress=$('#CustomerAddress').val();
        var TempArray={};
        TempArray['GetCustomerUserID']=GetCustomerUserID;
        TempArray['GetCustomerName']=GetCustomerName;
        TempArray['GetCustomerFirstName']=GetCustomerFirstName;
        TempArray['GetCustomerLastName']=GetCustomerLastName;
        TempArray['GetCustomerPhone']=GetCustomerPhone;
        TempArray['GetCustomerMail']=GetCustomerMail;
        TempArray['GetCustomerAddress']=GetCustomerAddress;
        TempArray['Mode']='1';

        ProfileAJAX(TempArray,'#BasicCustomerButton');


    });
//Register User's password

    $('body').on('click','#ChangePasswordButton',function(){

        var GetOldPassword=$('#Old_Password').val();
        var GetNewPassword=$('#New_password').val();
        var TempArray={};
        TempArray['GetCustomerUserID']=GetCustomerUserID;
        TempArray['GetOldPassword']=GetOldPassword;
        TempArray['GetNewPassword']=GetNewPassword;
        TempArray['Mode']='2';
        ProfileAJAX(TempArray,'#ChangePasswordButton');
    });


    /*******************************************avatar upload**************************************/
        //cp pic into special folder and get return path

    function imageUpload(Input_Photo,dataset)
    {
        $('#submitPic').html('Submitting.....');

        $.ajaxFileUpload
        (
            {
                url:CurrentDomain+'/cms/BackEnd-controller/AjaxImage-controller.php',
                secureuri:false,
                fileElementId:Input_Photo,
                dataType: 'html',
                data:dataset,
                success: function (data, status)
                {
                    $('#submitPic').html('done');
                    var tmpPath= $('#gobalPath').val();

                    var savedPath=tmpPath+data;
                    $('#CustomerImagePath').removeClass('placeholder');
                    $('#CustomerImagePath').val(savedPath);
                    $('<img class="img-circle" src='+tmpPath+data +'>').insertAfter($('#Input_Customeravatar')).fadeIn(200);

                },
                error: function (data, status, e)
                {
                    alert(e);
                }
            }
        )

        return false;

    }




    $('body').on('click','#submitPic',function() {
        if($("#Input_Customeravatar")[0].files[0]!==undefined){
            var file = $("#Input_Customeravatar")[0].files[0];
            var fileName = file.name;
            var fileSize = file.size;
            var fileType = file.type;
            $('<label class="fileinfo">'+fileName+', '+ fileSize+' bytes FileType: ' +fileType+' </label>').insertAfter($('#submitPic')).fadeIn(200);

            var tmp={};
            tmp['Input_Photo']='Input_Customeravatar';
            tmp['Mode_UserPic']='CustomerPhoto';
            imageUpload('Input_Customeravatar',tmp);



        }
        else if($(this).html()==='done'){
            $('<label id="exeisted-alert" style="color:red">You already submited the head photo</label>').insertAfter($('#submitPic')).fadeIn(200);
            setTimeout(function(){$('#exeisted-alert').fadeOut(); },5000);
            return false;

        }
        else
        {
            $('<label id="File-alert" style="color:red">Please select file first</label>').insertAfter($('#submitPic')).fadeIn(200);
            setTimeout(function(){$('#File-alert').fadeOut(); },5000);



        }



    });



    //update the Photo path
    $('body').on('click','#avatarButton',function(){
        if($('#CustomerImagePath').length>0){
            var CustomerPhotoPath=$('#CustomerImagePath').val();
            var tmp={};
            tmp['GetCustomerUserID']=GetCustomerUserID;
            tmp['CustomerPhotoPath']=CustomerPhotoPath;
            tmp['Mode']='3';
            PhotoPathUpdatingAjax(tmp,'#avatarButton');

        }

        function PhotoPathUpdatingAjax(data,infoid){
            var request = $.ajax({
                url: CurrentDomain+"/CMS/BackEnd-controller/BackEnd-controller.php",
                type: "POST",
                data:data,
                dataType: "html"
            });

            request.done(function( msg ) {
                if(msg==='Error'){
                    $('<div class="alert alert-info">Data Base Error</div>').insertBefore($(infoid)).fadeIn(200);
                    setTimeout(function(){$('.alert-info').fadeOut(); },3000);

                }
                else{
                    $('<div class="alert alert-info">Your avatar has been updated</div>').insertBefore($(infoid)).fadeIn(200);
                    setTimeout(function(){$('.alert-info').fadeOut(); },3000);
                }


            });

            request.fail(function( jqXHR, textStatus ) {
                alert( "Request failed: " + textStatus );
            });



        }




    });









//get gobal radio id
    $('body').on('click','.radioStatus',function(){
        window.Getid=$(this).attr('id');

    });
//remove the addressbook card

    $('body').on('click','#AddressBookRemoveButton',function(){
        var TempArray={};
        TempArray['GetCustomerUserID']=GetCustomerUserID;
        TempArray['RemoveID']=Getid;
        RemoveAddressAddBookAJAX(TempArray,'.thumbnails');

    });

//Set selected addressbook as default
    $('body').on('click','#AddressBookDefaultButton',function(){

        var TempArray={};
        TempArray['GetCustomerUserID']=GetCustomerUserID;
        TempArray['SetDefault']=Getid;
        SetDeafultAddressAddBookAJAX(TempArray,'.thumbnails');


    });












});