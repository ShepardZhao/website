$(document).ready(function(){
    var CurrentDomain=window.location.origin;
    var GetAccount=$('#HidenUserID').val();
    var getRestaurantID=$('#RestaruantID').val();


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
                    $('#RestaurantImagePath').removeClass('placeholder');
                    $('#RestaurantImagePath').val(savedPath);
                    $('#RestaruantPic').attr("src",savedPath);
                    $('#RestaruantPic').css("margin-top","-125px");


                },
                error: function (data, status, e)
                {
                    alert(e);
                }
            }
        )

        return false;

    }
    //temp upload

    $('body').on('click','#submitPic',function() {
        if($("#Input_Restaurantavatar")[0].files[0]!==undefined){
            var file = $("#Input_Restaurantavatar")[0].files[0];
            var fileName = file.name;
            var fileSize = file.size;
            var fileType = file.type;
            $('<label class="fileinfo">'+fileName+', '+ fileSize+' bytes FileType: ' +fileType+' </label>').insertAfter($('#submitPic')).fadeIn(200);

            var tmp={};
            tmp['Input_Photo']='Input_Restaurantavatar';
            tmp['Mode_RestaurantPic']='RestaurantPhoto';
            imageUpload('Input_Restaurantavatar',tmp);



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




    //Restaurant photo uploading
    $('body').on('click','#UploadRestaurantPhoto',function(){
        if($('#RestaurantImagePath').length>0){
            var CustomerPhotoPath=$('#RestaurantImagePath').val();
            var tmp={};
            tmp['RestaruantUID']=GetAccount;
            tmp['RestaruantID']=getRestaurantID;
            tmp['RestaruantPhotoPath']=CustomerPhotoPath;
            PhotoPathUpdatingAjax(tmp,'#UploadRestaurantPhoto');

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




    //setting up the restaruant info
    $('body').on('submit','#MyRestaurant',function(e){
        //Get my restaurant ID
        var getRestauranName=$('#RestarurantName').val();
        var getDetailAddress=$('#RestarurantAddress').val();
        var getRootAddress=$('.MyResRootAddress').val();
        var getFinalAddress=getDetailAddress+','+getRootAddress;
        var getContactName=$('#RestarurantContactName').val();
        var getContactNumber=$('#RestarurantContactNumber').val();
        var getAvailabilityTag=$('#Availability').val();
        var getCuisineTag=$('#Cuisine').val();
        //opening hour
        var Sunday="Sunday";
        var Monday="Monday";
        var Tuesday="Tuesday";
        var Wednesday="Wednesday";
        var Thursday="Thursday";
        var Friday="Friday";
        var Saturday="Saturday";

        var OpenSunday=$('#SunFrom').val()+'-'+$('#SunTo').val();
        var OpenMonday=$('#MonFrom').val()+'-'+$('#MonTo').val();
        var OpenTuesday=$('#TueFrom').val()+'-'+$('#TueTo').val();
        var OpenWednesday=$('#WedFrom').val()+'-'+$('#WedTo').val();
        var OpenThursday=$('#ThFrom').val()+'-'+$('#ThTo').val();
        var OpenFriday=$('#FriFrom').val()+'-'+$('#FriTo').val();
        var OpenSaturday=$('#SatFrom').val()+'-'+$('#SatTo').val();
        var OpenHour={};
        OpenHour[Sunday]=OpenSunday;
        OpenHour[Monday]=OpenMonday;
        OpenHour[Tuesday]=OpenTuesday;
        OpenHour[Wednesday]=OpenWednesday;
        OpenHour[Thursday]=OpenThursday;
        OpenHour[Friday]=OpenFriday;
        OpenHour[Saturday]=OpenSaturday;



//prepare to Ajax
        var MyRestaurant={};
        MyRestaurant['MyRestaurantEdit']="MyRestaurantEdit";
        MyRestaurant['MyResUID']=GetAccount;
        MyRestaurant['MyResID']=getRestaurantID;
        MyRestaurant['MyResName']=getRestauranName;
        MyRestaurant['MyResAddress']=getFinalAddress;
        MyRestaurant['MyResContactName']=getContactName;
        MyRestaurant['MyResContactNumber']=getContactNumber;
        MyRestaurant['MyResAvailabilityTag']=getAvailabilityTag;
        MyRestaurant['MyResCuisineTag']=getCuisineTag;
        MyRestaurant['MyResOpeningHours']=OpenHour;
        MyRestaurant['MyResReview']=0;

if(getDetailAddress==='' || getContactName==='' || getContactNumber==='' || getAvailabilityTag==='' || getCuisineTag===''){
    ErrorInfo('Sorry, you have to fill all fields','#MyRestaruantSubmit');

}
else{
        var request = $.ajax({
            url: CurrentDomain+"/CMS/BackEnd-controller/BackEnd-controller.php",
            type: "POST",
            data:MyRestaurant,
            dataType: "html"
        });
        request.done(function( msg ) {
            if(msg==='Successed'){
                SuccessInfo(msg,'#MyRestaruantSubmit');

            }
            else {
                ErrorInfo('Sorry, The database ERROR','#MyRestaruantSubmit');

            }

        });

        request.fail(function( jqXHR, textStatus ) {
            alert( "Request failed: " + textStatus );
        });
}
        return false;
    });



    //change the password
    $('body').on('submit','#AccountForm',function(e){
        var GetOldPassword=$('#OldPassword').val();
        var GetNewPassword=$('#NewPassword').val();
        var tmp={};
        tmp['BusAccount']=GetAccount;
        tmp['BusOldPassword']=GetOldPassword;
        tmp['BusNewPassword']=GetNewPassword;

        if(GetOldPassword==='' || GetNewPassword===''){
            ErrorInfo('Sorry, you have to fill all fields','#AccountSubmit');
        }
        else{
            ajaxSubmit(tmp);
        }
        return false;
    });

    function ajaxSubmit(data){
        var request = $.ajax({
            url: CurrentDomain+"/CMS/BackEnd-controller/BackEnd-controller.php",
            type: "POST",
            data:data,
            dataType: "html"
        });
        request.done(function( msg ) {
            if(msg==='Changed password successfully'){
                SuccessInfo(msg,'#AccountSubmit');
            }
            else{
                ErrorInfo(msg,'#AccountSubmit');
            }

        });

        request.fail(function( jqXHR, textStatus ) {
            alert( "Request failed: " + textStatus );
        });
    }

    function SuccessInfo(content,id){
        $('<label class="alert alert-info" >'+content+'</label>').insertBefore($(id)).fadeIn(200);
        setTimeout(function(){$('.alert-info').fadeOut(); },5000);
    }
    function ErrorInfo(content,id){
        $('<label class="alert alert-error" >'+content+'</label>').insertBefore($(id)).fadeIn(200);
        setTimeout(function(){$('.alert-error').fadeOut(); },5000);


    }

    //time picker

    $('.TimePicker').timepicker();




});