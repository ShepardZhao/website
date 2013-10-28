$(document).ready(function(){
    //common variables
    var GetAccount=$('#HidenUserID').val();
    var getRestaurantID=$('#RestaruantID').val();
    //common modal
    var $modal=$('#ajax-modal');
    var $modalphoto=$('#ajax-modal-cuisine-photo');
    var tmpContainter;
    //image variables;
    var resizeOldWidth;
    var resizeOldHeight;


    /************************************** Cuisine phtoto uploading*************************************************/

    $('body').on('click','#submitCuisinePic',function() {
        if($("#Input_Cuisineavatar")[0].files[0]!==undefined){
            var file = $("#Input_Cuisineavatar")[0].files[0];
            var fileName = file.name;
            var fileSize = file.size;
            var fileType = file.type;
            $('<label class="fileinfo">'+fileName+', '+ fileSize+' bytes FileType: ' +fileType+' </label>').insertBefore($('#submitCuisinePic')).fadeIn(200);
            var tmp={};
            tmp['Input_Photo']='Input_Cuisineavatar';
            tmp['Mode_CuisinePic']='CuisinePhoto';
            CuisineimageUpload('Input_Cuisineavatar',tmp);

        }
        else if($(this).html()==='done'){
            InformationDisplay("Sorry, You already submited the avatar","alert-error");
            return false;

        }
        else
        {
            InformationDisplay("Sorry, Please select file first","alert-error");

        }



    });
    /*******************************************Cuisine avatar upload**************************************/
        //cp pic into special folder and get return path

    function CuisineimageUpload(Input_Photo,dataset)
    {
        $('#submitCuisinePic').html('Submitting.....');
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
                    //data that form AjaxImage-controller.php is string, it contains two urls
                    //by using split of jquery to spearate it as two array, 0 is absolute path, 1 is relative path
                    var urlArray=data.split(',');
                    $('#submitCuisinePic').html('done');
                    var tmpPath= $('#gobalPath').val();
                    var savedPath=tmpPath+urlArray[1];
                    $('#CuisineImagePath').removeClass('placeholder');
                    $('#absolutePath').val(urlArray[0]);//set up absolute path;
                    $('#encryptedName').val(urlArray[2]);//set up EncryptedName;
                    $('#CuisineImagePath').val(savedPath);
                    $('#showsCuisinePhoto').addClass('ClassCuisinePhoto');
                    $('.ClassCuisinePhoto').attr("src",savedPath);
                },
                error: function (data, status, e)
                {
                    alert(e);
                }
            }
        )

        return false;
    }



    /************************************** pic uploading modal*************************************************/

        //WaterMarker check
    $modalphoto.on('click','#WaterMarkerCheckbox',function(){
        if($(this).is(':checked')){
            $(this).val('yes');
            $('input[name=WaterMarkerPosition]').removeAttr('disabled');
        }
        else{
            $(this).val('no');
            $('input[name=WaterMarkerPosition]').attr('disabled','true');

        }


    });

    //position select
    window.GetWaterMarkerPosition='';
    $modalphoto.on('click','input[name=WaterMarkerPosition]',function(){
        window.GetWaterMarkerPosition=$(this).val();

    });
    $('body').on('click','.UploadCuisPhoto',function(){
        var getCuID=$(this).parent().parent().find('.button-delete').attr('id');
        $('body').modalmanager('loading');
        setTimeout(function(){
            $modalphoto.load(CurrentDomain+'/cms/business-Management/SubPages/DishesPack/PhotoUploading.php?CuID='+getCuID, '', function(){
                $modalphoto.modal();
            });
        }, 1000);
    });

    //crop and upload the image
    $modalphoto.on('click','#ConfrimSelection',function(e){
        if (parseInt($('#w').val())) {
           var resizeOldWidth=$('.ClassCuisinePhoto').css('width');
           var resizeOldHeight=$('.ClassCuisinePhoto').css('height');
            $('')
            var CuisineX=$('#x').val();
            var CuisineY=$('#y').val();
            var CuisineW=$('#w').val();
            var CuisineH=$('#h').val();
            var GetCurrentCuid=$('#GetCurrentCuid').val();
            var GetWaterMarkerCheckbox=$('#WaterMarkerCheckbox').val();
            var tmp={};
            tmp['WaterMarkerStatus']=$('#WaterMarkerCheckbox').val();
            tmp['WaterMarkerPositon']=GetWaterMarkerPosition;
            tmp['GetCurrentCuid']=GetCurrentCuid;
            tmp['resizeOldWidth']=resizeOldWidth;
            tmp['resizeOldHeight']=resizeOldHeight;
            tmp['CropedCuisine']="CropedCuisine";
            tmp['Mode_CuisinePic']="Mode_CuisinePic";
            tmp['CuisineOldImagePath']=$('#absolutePath').val();
            tmp['EncryptedName']=$('#encryptedName').val();
            tmp['CuisineX']=CuisineX;
            tmp['CuisineY']=CuisineY;
            tmp['CuisineW']=CuisineW;
            tmp['CuisineH']=CuisineH;
            CuisineCropImage(tmp);

            return true;
        }else{
            InformationDisplay("Sorry, Please select a crop region then press Save","alert-error");
            return false;}

    return false;
    });
    //CropImage uploading
    function CuisineCropImage(tmp){
        var request = $.ajax({
            url: CurrentDomain+"/CMS/BackEnd-controller/AjaxImage-controller.php",
            type: "POST",
            data:tmp,
            dataType: "html"
        });

        request.done(function( msg ) {

            $('#GetFinalPhotoPath').val($('#gobalPath').val()+$.trim(msg));
            $('#PreviewSelectedImage').removeAttr('disabled');
                $('#PreviewSelectedImage').click(function(){
                    if($(this).attr('disabled')===undefined){
                        $('#PreviewCuisinePhoto').attr('src',$('#gobalPath').val()+$.trim(msg));

                    }

                });
        });

        request.fail(function( jqXHR, textStatus ) {
            alert( "Request failed: " + textStatus );
        });

    }

//crop function
    $('body').on('mouseenter','.ClassCuisinePhoto',function(){

        $(this).Jcrop({
            maxSize: [ 223 , 0 ],
            minSize: [ 220 , 0 ],
            onSelect: updateCoords,
            bgFade: true, // use fade effect
            bgOpacity: .3 // fade opacity
        });
        function updateCoords(c)
        {
            $('#x').val(c.x);
            $('#y').val(c.y);
            $('#w').val(c.w);
            $('#h').val(c.h);
        };




    });


    $modalphoto.on('change','#Input_Cuisineavatar',function(){
        if($(this)[0].files[0]!==undefined){
            var file = $(this)[0].files[0];
            var fileName = file.name;
            $('#CuisineImagePath').val(fileName);
        }

    });


   //final cuisine photo uploading
    $modalphoto.on('click','#CuisinePhotoUploading',function(){
        if($('#CuisineImagePath').val()!==''){
            var tmp={};
            tmp['CuisinePhotoUploading']='CuisinePhotoUploading';
            tmp['CuisineCuid']=$('#GetCurrentCuid').val();
            tmp['CuisinePhotoPath']=$('#GetFinalPhotoPath').val();
            tmp['OldPhotoPath']=$('#absolutePath').val();
            var request = $.ajax({
                url: CurrentDomain+"/CMS/BackEnd-controller/BackEnd-controller.php",
                type: "POST",
                data:tmp,
                dataType: "html"
            });

            request.done(function( msg ) {
                if(msg==='You have successfully uploaded photo'){
                    $modalphoto.modal('loading');
                    setTimeout(function(){
                        $modalphoto
                            .modal('loading')
                            .find('.modal-body').empty()
                            .prepend("<div class='alert alert-success fade in'>" + msg + "</div>");

                    }, 1000);
                    setTimeout(function(){$('#ajax-modal-cuisine-photo').modal('hide'); CuisineAJAXList();},3000);
                }
                else if(msg==='Database Error'){
                    InformationDisplay("Sorry, Database Error","alert-error");


                }
            });

            request.fail(function( jqXHR, textStatus ) {
                alert( "Request failed: " + textStatus );
            });
        }
       else{
            InformationDisplay("Sorry, You cannot save the crop photo due empty file path","alert-error");
        }
        return false;

    });





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
   //change the order status that adds 1 from base
    $('body').on('click','.icon-caret-up-table',function(){
       var OrNumber=parseInt($(this).parent().find('h5').html());
       $(this).parent().find('h5').html(OrNumber+1);
   });
    //chage the order status that subs 1 from base
    $('body').on('click','.icon-caret-down-table',function(){
        var OrNumber=parseInt($(this).parent().find('h5').html());
        $(this).parent().find('h5').html(OrNumber-1);
    });

    //button that changes the order, but it will check replated order then impletes the rest of part
    $('body').on('click','#ChangeNewOrder',function(){
        var TotalIndex=$('#CusinesTable tbody tr').length;
        var tmp={};
        var passNewOrder={};
        var tmpStore=[];
        //save order only
        for (var x=0;x<TotalIndex;x++){
            tmpStore.push($('#CusinesTable tbody').find('tr').eq(x).find('td').eq(0).find('h5').html());
        }

        if(checkReplatedOrder(tmpStore)===1){

            InformationDisplay("Sorry, there is exeisting repleated order","alert-error");
        }
        else{
          for (var i=0;i<TotalIndex;i++){
           tmp[$('#CusinesTable tbody').find('tr').eq(i).find('.button-delete').attr('id')]=$('#CusinesTable tbody').find('tr').eq(i).find('td').eq(0).find('h5').html();
          }
            passNewOrder['UpdateCuisineOrder']='UpdateCuisineOrder';
            passNewOrder['ArrayOfCuisineOrder']=tmp;
            AJAXupdateCuisineOrder(passNewOrder);

        }

    //compare all order, if there is the replated one, then error displed
    function checkReplatedOrder(tmpStore){
        var nary=tmpStore.sort();
        var repleated=0;
        for(var i=0;i<tmpStore.length;i++){
            if (nary[i]==nary[i+1]){
                repleated=1;

            }

        }
        return repleated;

    }

    });

    //update cuisine's order
    function AJAXupdateCuisineOrder(getOrderArray){
        var request = $.ajax({
            url: CurrentDomain+"/CMS/BackEnd-controller/BackEnd-controller.php",
            type: "POST",
            data:getOrderArray,
            dataType: "html"
        });

        request.done(function( msg ) {
            if(msg==='1'){
                InformationDisplay("Sorry, Database error","alert-error");
            }
            else if(msg==='0'){
                InformationDisplay("The new order has been Successfully updated","alert-success");
                CuisineAJAXList();
            }

        });

        request.fail(function( jqXHR, textStatus ) {
            alert( "Request failed: " + textStatus );
        });
    }


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
        if(UpCurrentCuisineID!=='' && UpCurrentCuisineName!=='' && UpCurrentCuisineDes!=='' && UpCurrentCuisinePrice!=='' && UpCurrentCuisineAvali!=='' && CurrentAvaliTag!=='' && CurrentCusinTag!=='' && CurrentCusinTypeTag!=='' && CurrentCusinPriceTag !==''){
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

            CuisineAjax(tmp);

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
        var CurrentAvaliTag=$('#Availability').val();
        var CurrentCuisinePrice=$('#CuPrice').val();
        var CurrentCuisineAvali=$('#CuAvaliability').val();
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



    /*******************************************Restaurant avatar upload**************************************/
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

    $('body').on('change','#Input_Restaurantavatar',function(){
        if($("#Input_Restaurantavatar")[0].files[0]!==undefined){
            var file = $("#Input_Restaurantavatar")[0].files[0];
            var fileName = file.name;
            $('#RestaurantImagePath').val(fileName);
        }

    });



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
            InformationDisplay("Sorry, You already submited the head photo","alert-error");
            return false;

        }
        else
        {
            InformationDisplay("Sorry, Please select file first","alert-error");

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
                    InformationDisplay("Sorry, Data Base Error","alert-error");

                }
                else{
                    InformationDisplay("Your avatar has been updated","alert-success");
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
                SuccessInfo('Successfully updated','#MyRestaruantSubmit');

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
        InformationDisplay(content,"alert-info");
    }
    function ErrorInfo(content,id){
        InformationDisplay(content,"alert-error");
    }















    //time picker

    $('.TimePicker').timepicker();

    //tips
    $('#ChangeNewOrder').tooltip();

    //jquery bootstrap hacks
    $('body').on('click','.dropdown-menu li',function(e){
        e.stopPropagation();
    });

    //oricon-caret-up-table


});