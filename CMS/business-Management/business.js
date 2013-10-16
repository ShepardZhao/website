$(document).ready(function(){
    var CurrentDomain=window.location.origin;
    var GetAccount=$('#HidenUserID').val();
    var getRestaurantID=$('#RestaruantID').val();
    //common modal
    var $modal=$('#ajax-modal');
    var tmpContainter;
    /******************************************Add second level of current cuisine****************/
    $('body').on('click','.AddSecondLevel',function(){

        var getCuID=$(this).attr('id');
        var getCuName=$(this).parent().parent().find('.CuName').attr('id');
        $('body').modalmanager('loading');
        setTimeout(function(){
            $modal.load(CurrentDomain+'/cms/business-Management/SubPages/DishesPack/SecondLevel.php?CuID='+getCuID+'&CuName='+getCuName, '', function(){
                $modal.modal();
                tmpContainter=$('#SecondLevelWrap').html();
            });
        }, 1000);

    });


    //basic function of sub level
    $modal.on('click','.subAddNewBotton',function(){
      if($('#SecondLevelCheckbox').is(':checked')){
        $('<div class="form-inline SubSecondstyle"><label>Name: <input type="text" class="SubSecondInput span8" name="SubLevelOfName[]" placeholder="i.e: extra cheese"> </label> <label> Price: <input type="text" class="SubSecondInputPrice" type="number" pattern="[0-9]+([\,|\.][0-9]+)?" name="SubLevelOfPrice[]" step="0.01" placeholder="i.e: $2"></label> <button class="button text-right button-delete SubSecondButton-delete" type="button">Delete</button></div>').insertAfter('.SecondLevelCheckbox').fadeIn();
      }
    });
    $modal.on('click','.SubSecondButton-delete',function(){
        $(this).parent().empty();
    });


    $modal.on('click','.addedNewTitle',function(){
        $('#SecondLevelWrap').empty().append(tmpContainter);

    });
    $modal.on('submit','#SecondLevelForm',function(e){
       var getSecondLevelNameAndPrice = returnInputArray('SubLevelOfName','SubLevelOfPrice');
       var getSecondTtile=$('.SecondTitle').val();
       var getCuid=$('#GetCuid').val();
       var tmp={};

       tmp['SecondLevelTitle']=getSecondTtile;
       tmp['PassCuid']=getCuid;
       tmp['SubSecondLevel']=getSecondLevelNameAndPrice;
       CuisineAjax(tmp);
       return false;
    });


    function returnInputArray(SubLevelOfName,SubLevelOfPrice){
        var TemporaryArray1=[];
        var TemporaryArray2=[];
        var PrepareArray={};
        var ReturnArray={};
        $('input[name="' + SubLevelOfName + '[]"]').each(function() {
            TemporaryArray1.push($(this).val());
        });
        $('input[name="' + SubLevelOfPrice + '[]"]').each(function() {
            TemporaryArray2.push($(this).val());
        });
        for (var i=0; i<TemporaryArray1.length;i++){
            PrepareArray['name']=TemporaryArray1[i];
            PrepareArray['price']=TemporaryArray2[i];
            ReturnArray['SubSecondLevel'+i]=PrepareArray;
            PrepareArray={};//clean the array
        }

        return ReturnArray;

    }





    /******************************************ajax list cuisine**********************************/
    CuisineAJAXList();

    function CuisineAJAXList(){
        var tmp={};
        tmp['ajaxCuisineList']='yes';
        $('#ajaxCusinesTable').empty().append('<div class="AjaxLoading"><img src='+CurrentDomain+'/assets/framework/img/ajax-loader.gif></div>').fadeIn();
        var request = $.ajax({
            url: CurrentDomain+"/CMS/BackEnd-controller/BackEnd-controller.php",
            type: "POST",
            data:tmp,
            dataType: "html"
        });

        request.done(function( msg ) {

            $('#ajaxCusinesTable').empty().append(msg).fadeIn();


        });

        request.fail(function( jqXHR, textStatus ) {
            alert( "Request failed: " + textStatus );
        });


    }




    /*******************************************Dishes setting************************************/
    //added dished by button AddedNewDish -- method is modal
    $('#AddedNewDish').on('click',function(){
        $('body').modalmanager('loading');
        setTimeout(function(){
            $modal.load(CurrentDomain+'/cms/business-Management/SubPages/DishesPack/addDishes.php', '', function(){
                $modal.modal();
            });
        }, 1000);


    });
    //delete current cuisine
    $('body').on('click','.button-delete',function(){
       var getCuid=$(this).attr('id');
        console.log(getCuid);
       tmp={};
       tmp['CuisineDeleteID']=getCuid;
        var TempParent=$(this).parent().parent().parent();

        var request = $.ajax({
            url: CurrentDomain+"/CMS/BackEnd-controller/BackEnd-controller.php",
            type: "POST",
            data:tmp,
            dataType: "html"
        });

        request.done(function( msg ) {
            if (msg==='Delete Successful'){


                TempParent.empty().append('<td colspan="8"><div class="alert alert-warning">'+msg+'</div></td>');
                setTimeout(function(){TempParent.remove(); CuisineAJAXList(); },3000);


            }
            else if(msg==='Current Order is available'){
                CuisineAjax(CuisineArray);
            }

        });

        request.fail(function( jqXHR, textStatus ) {
            alert( "Request failed: " + textStatus );
        });







    });


    /******************************************Cuisine order controller****************************/
    $(".modal").on('shown', function() {
      $(this).find("#CuName").focus();
    });


    $modal.on('blur','#CuName',function(){
        if($(this).val()===''){
            $(this).focus();
        }
        else{
            $modal.find("#TitleOfSecondLevel").html($(this).val());


        }
    });

    $modal.on('blur','#CuDescr',function(){
        if($(this).val()===''){
            $(this).focus();
        }
    });

    $modal.on('blur','#CuPrice',function(){
        if($(this).val()===''){
            $(this).focus();
        }
    });

    $modal.on('click','.minbutton', function(){
        var getMinCusOrder=parseInt($modal.find('.NumberOfOrder').val());
        var minCusOrder=getMinCusOrder-1;
        $modal.find('.NumberOfOrder').val(minCusOrder);
        return false;
    });

    $modal.on('click','.plusbutton', function(){
        var getPlusCusOrder=parseInt($modal.find('.NumberOfOrder').val());
        var plusCusOrder=getPlusCusOrder + 1;
        $modal.find('.NumberOfOrder').val(plusCusOrder);
        return false;
    });



//This function is doing the order check, if there is any order in matched then return error
    function OrderCheckAJAX(GetCurrentOrder,CuisineArray){
        var tmp={};
        tmp['GetOrginalOrder']=GetCurrentOrder;
        var request = $.ajax({
            url: CurrentDomain+"/CMS/BackEnd-controller/BackEnd-controller.php",
            type: "POST",
            data:tmp,
            dataType: "html"
        });

        request.done(function( msg ) {
            if (msg==='Repeated Order'){
                $modal.find('.NumberOfOrder').focus();
                $('<span class="RepeatedOrder">  Sorry, Current Order has been repeated</span>').insertAfter($('.plusbutton'));
                setTimeout(function(){$('.RepeatedOrder').fadeOut(); },3000);

            }
            else if(msg==='Current Order is available'){
                CuisineAjax(CuisineArray);
            }

        });

        request.fail(function( jqXHR, textStatus ) {
            alert( "Request failed: " + textStatus );
        });

    }


    /******************************************Modifiy current dish********************************/
    $modal.on('submit','#SumitModifyDishForm',function(e){
        var UpCurrentCuisineID=$('#UpCurrentCuisineID').val();
        var UpCurrentCuisineName=$('#UpCuName').val();
        var UpCurrentCuisineDes=$('#UpCuDescr').val();
        var UpCurrentCuisinePrice=$('#UpCuPrice').val();
        var UpCurrentCuisineAvali=$('#UpCuAvaliability').val();
        var CurrentAvaliTag=$('#Availability').val();
        var CurrentCusinTag=$('#Cuisine').val();
        var CurrentCusinTypeTag=$('#Type').val();
        var CurrentCusinPriceTag=$('#Price').val();
        var CurrentCusinOrder=$('.NumberOfOrder').val();
        if(UpCurrentCuisineID!=='' && UpCurrentCuisineName!=='' && UpCurrentCuisineDes!=='' && UpCurrentCuisinePrice!=='' && UpCurrentCuisineAvali!=='' && CurrentAvaliTag!=='' && CurrentCusinTag!=='' && CurrentCusinTypeTag!=='' && CurrentCusinPriceTag !=='' && CurrentCusinOrder!==''){
            var tmp={};
            tmp['UpCurrentCuisineID']=UpCurrentCuisineID;
            tmp['UpCurrentCuisineName']=UpCurrentCuisineName;
            tmp['UpCurrentCuisineDes']=UpCurrentCuisineDes;
            tmp['UpCurrentCuisinePrice']=UpCurrentCuisinePrice;
            tmp['UpCurrentCuisineAvali']=UpCurrentCuisineAvali;
            tmp['CurrentAvaliTag']=CurrentAvaliTag;
            tmp['CurrentCusinTag']=CurrentCusinTag;
            tmp['CurrentCusinTypeTag']=CurrentCusinTypeTag;
            tmp['CurrentCusinPriceTag']=CurrentCusinPriceTag;
            tmp['CurrentCusinOrder']=CurrentCusinOrder;

            OrderCheckAJAX(CurrentCusinOrder,tmp);

        }
        else {
            AjaxMessageError('alert-error','You have to fill all fields');

        }
        return false;

    });




    /******************************************Submit a new dish***********************************/
    $modal.on('submit','#AddNewDishForm', function(e){
        var CurrentResID=$('#CurrentResID').val();
        var CurrentCuisineName=$('#CuName').val();
        var CurrentCuisineDes=$('#CuDescr').val();
        var CurrentCuisinePrice=$('#CuPrice').val();
        var CurrentCuisineAvali=$('#CuAvaliability').val();
        var CurrentAvaliTag=$('#Availability').val();
        var CurrentCusinTag=$('#Cuisine').val();
        var CurrentCusinTypeTag=$('#Type').val();
        var CurrentCusinPriceTag=$('#Price').val();
        var CurrentCusinOrder=$('.NumberOfOrder').val();

        if(CurrentResID!=='' && CurrentCuisineName!=='' && CurrentCuisineDes!=='' && CurrentCuisinePrice!=='' && CurrentCuisineAvali!=='' && CurrentAvaliTag!=='' && CurrentCusinTag!=='' && CurrentCusinTypeTag!=='' && CurrentCusinPriceTag !=='' && CurrentCusinOrder!==''){
           var tmp={};
            tmp['CurrentResID']=CurrentResID;
            tmp['CurrentCuisineName']=CurrentCuisineName;
            tmp['CurrentCuisineDes']=CurrentCuisineDes;
            tmp['CurrentCuisinePrice']=CurrentCuisinePrice;
            tmp['CurrentCuisineAvali']=CurrentCuisineAvali;
            tmp['CurrentAvaliTag']=CurrentAvaliTag;
            tmp['CurrentCusinTag']=CurrentCusinTag;
            tmp['CurrentCusinTypeTag']=CurrentCusinTypeTag;
            tmp['CurrentCusinPriceTag']=CurrentCusinPriceTag;
            tmp['CurrentCusinOrder']=CurrentCusinOrder;
            //doing the order check first then run addnewdishe function
            OrderCheckAJAX(CurrentCusinOrder,tmp);

        }
        else {
            AjaxMessageError('alert-error','You have to fill all fields');

        }


        return false;

    });



function CuisineAjax(data){

    var request = $.ajax({
        url: CurrentDomain+"/CMS/BackEnd-controller/BackEnd-controller.php",
        type: "POST",
        data:data,
        dataType: "html"
    });

    request.done(function( result ) {
        if(result==='Error'){
            AjaxMessageError('alert-error','Submit Error, please contact to admin');
        }
        else{
            AjaxMessageSuccess('alert-success',result);
            setTimeout(function(){$('#ajax-modal').modal('hide'); CuisineAJAXList();},3000);

        }


    });

    request.fail(function( jqXHR, textStatus ) {
        alert( "Request failed: " + textStatus );
    });


}


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

    /********************************************EditCusine****************************************/
    $('body').on('click','.EditCusine',function(){
        var Cuid=$(this).attr('id');
        $('body').modalmanager('loading');
        setTimeout(function(){
            $modal.load(CurrentDomain+'/cms/business-Management/SubPages/DishesPack/EditDishes.php?CUID='+Cuid, '', function(){
                $modal.modal();
            });
        }, 1000);


    });

    $('body').on('click','#click-Dishes',function(){

        CuisineAJAXList();

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


    //tips
    $('#ChangeNewOrder').tooltip();


});