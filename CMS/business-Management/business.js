$(document).ready(function(){
    //common variables
    var GetAccount=$('#HidenUserID').val();
    var getRestaurantID=$('#RestaruantID').val();
    //common modal
    var $modal=$('#ajax-modal');
    var $modalphoto=$('#ajax-modal-cuisine-photo');
    //image variables;
    var resizeOldWidth;
    var resizeOldHeight;
    var tmpWrapContainter="<div class='row-fluid'><div class='span12'><div class='form-horizontal'><div class='control-group SecondTitleWrap'><label class='control-label SecondLevelModalLabel'>Title: </label><div class='controls text-left SecondLevelModalControl'><input type='text' class='span9 SecondTitle' name='SecondLevelTitle[]' placeholder='Second level dishs type. i.e: pizza base'> <button class='button text-right button-delete SecondLevelButton-delete' type='button'>Delete</button></div><br><label class='checkbox SecondLevelCheckbox'><input type='checkbox' id='SecondLevelCheckbox'>Multiple choice</label><div class='form-inline SubSecondstyle'><label>Name: <input type='text' class='SubSecondInput span8' name='SubLevelOfName[]' placeholder='i.e: extra cheese'> </label> <label> Price: <input class='SubSecondInputPrice' type='number' pattern='[0-9]+([\,|\.][0-9]+)?' name='SubLevelOfPrice[]' step='0.01' placeholder='i.e: $2.00'></label> <button class='button text-right button-delete SubSecondButton-delete' type='button'>Delete</button></div><div class='row-fluid AddNewButtonZone'><div class='span12 text-center'><button class='button subbutton subAddNewBotton'  type='button'>Add New</button></div></div></div><label class='alert alert-info'>Note: If you want to add new name and pric for current title, please click 'Add New' with bule button </label> </div></div></div>";
    var tmpNameAndPriceContainter='<div class="form-inline SubSecondstyle"><label>Name: <input type="text" class="SubSecondInput span8" name="SubLevelOfName[]" placeholder="i.e: extra cheese"> </label> <label> Price: <input type="text" class="SubSecondInputPrice" type="number" pattern="[0-9]+([\,|\.][0-9]+)?" name="SubLevelOfPrice[]" step="0.01" placeholder="i.e: $2.00"></label> <button class="button text-right button-delete SubSecondButton-delete" type="button">Delete</button></div>';



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
            $('#showsCuisinePhoto').attr('src','').fadeOut(1000);
            if($('#progress_bar').hasClass('hide')){$('#progress_bar').fadeIn(1000).removeClass('hide');}

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
                url:CurrentDomain+'/CMS/BackEnd-controller/AjaxImage-controller.php',
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
                    $('#showsCuisinePhoto').addClass('ClassCuisinePhoto').fadeIn(1000);
                    $('#progress_bar').hide();
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
            $modalphoto.load(CurrentDomain+'/CMS/business-Management/SubPages/DishesPack/PhotoUploading.php?CuID='+encodeURIComponent(getCuID), '', function(){
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
            dataType: "json"
        });

        request.done(function( msg ) {
            window.CuisinePicWidth = msg.CuisinePicWidth;
            window.CuisinePicHeight = msg.CuisinePicHeight;
            $('#GetFinalPhotoPath').val($('#gobalPath').val()+$.trim(msg.CuisinePicPath));
            $('#PreviewSelectedImage').removeAttr('disabled');
            $('#PreviewSelectedImage').click(function(){
                if($(this).attr('disabled')===undefined){
                    $('#PreviewCuisinePhoto').attr('src',$('#gobalPath').val()+$.trim(msg.CuisinePicPath));
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
            tmp['CuisinePicWidth'] = CuisinePicWidth;
            tmp['CuisinePicHeight'] = CuisinePicHeight;

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

    /******************************************Manage second level of current cuisine****************/
    $('body').on('click','.AddSecondLevel',function(){ //AddSecondLevel
        var getCuID=$(this).attr('id');
        var getCuName=$(this).parent().parent().find('.CuName').attr('id');
        $('body').modalmanager('loading');
        setTimeout(function(){
            $modal.load(CurrentDomain+'/CMS/business-Management/SubPages/DishesPack/SecondLevelAdded.php?CuID='+encodeURIComponent(getCuID)+'&CuName='+encodeURIComponent(getCuName), '', function(){
                $modal.modal();
            });
        }, 1000);

    });

    $('body').on('click','.EditSecondLevel',function(){ //EditSecondLevel
        var getCuID=$(this).attr('id');
        var getCuName=$(this).parent().parent().parent().parent().parent().find('.CuName').attr('id');
        $('body').modalmanager('loading');
        setTimeout(function(){
            $modal.load(CurrentDomain+'/CMS/business-Management/SubPages/DishesPack/EditSecondLevel.php?CuID='+encodeURIComponent(getCuID)+'&CuName='+encodeURIComponent(getCuName), '', function(){
                $modal.modal();
            });
        }, 1000);

    });


    //delete inside of second level of cuisine
    $modal.on('click','.SubSecondButton-delete',function(){
        //obtain current unique id
        if($(this).parent().parent().parent().parent().parent().find('.UpdateKey').length>0){
            var getUnique=$(this).parent().parent().parent().parent().parent().find('.UpdateKey').val();
            var getName=$(this).parent().find('.SubSecondInput').val();
            var getPrice=$(this).parent().find('.SubSecondInputPrice').val();
            var tmp={};
            tmp['DeleteInsideSecondLevel']='set';
            tmp['getUniqueID']=getUnique;
            tmp['InsideName']=getName;
            tmp['InsidePrice']=getPrice;

            var request = $.ajax({
                url: CurrentDomain+"/CMS/BackEnd-controller/BackEnd-controller.php",
                type: "POST",
                data:tmp,
                dataType: "html"
            });

            request.done(function( result ) {
                InformationDisplay(result,"alert-success");
                CuisineAJAXList();
            });

            request.fail(function( jqXHR, textStatus ) {
                alert( "Request failed: " + textStatus );
            });
        }
    });




    //delete current second level
    $modal.on('click','.SecondLevelButton-delete',function(){
        $(this).parent().parent().parent().parent().parent().remove();//remove and empty current sub box
        //if currently is adding new record, then false, otherwise return true
        if($(this).parent().parent().parent().parent().parent().find('.UpdateKey').length>0){
            var value=$(this).parent().parent().parent().parent().parent().find('.UpdateKey').val();
            var tmp={};
            tmp['SecondLevelWrapDelete']=value;
            var request = $.ajax({
                url: CurrentDomain+"/CMS/BackEnd-controller/BackEnd-controller.php",
                type: "POST",
                data:tmp,
                dataType: "html"
            });

            request.done(function( result ) {
                InformationDisplay(result,"alert-waring");
                CuisineAJAXList();
            });

            request.fail(function( jqXHR, textStatus ) {
                alert( "Request failed: " + textStatus );
            });
        }

    });


    //basic function of sub level
    $modal.on('click','.subAddNewBotton',function(){
            $(tmpNameAndPriceContainter).fadeIn().insertBefore($(this).parent().parent().parent().find('.AddNewButtonZone'));
    });
    //delete function of sub level
    $modal.on('click','.SubSecondButton-delete',function(){
        $(this).parent().empty();
    });

    //add a new title
    $modal.on('click','.addedNewTitle',function(){
        $(tmpWrapContainter).appendTo($('#SecondLevelWrap'));

    });

    //submit the form with add new second level
    $modal.on('click','#AddSecondLevelForm',function(e){

        var getCount=$('.SecondTitleWrap').length;//get current length of second titles
        var tmp={};//second level includs titles and sub contents
        var passtmp={};//includes Current CuisineID and tmp;
        //loop and fill into array
        for (var i=0; i<getCount;i++){
            if($('.SecondTitleWrap').eq(i).find('.SecondTitle').val()!==''){
                if($('.SecondTitleWrap').eq(i).find('#SecondLevelCheckbox').is(':checked')){
                    tmp[$('.SecondTitleWrap').eq(i).find('.SecondTitle').val()]=returnInputArray(i,'MultiChoice','SubLevelOfName','SubLevelOfPrice');
                }
                else {
                    tmp[$('.SecondTitleWrap').eq(i).find('.SecondTitle').val()]=returnInputArray(i,'Radio','SubLevelOfName','SubLevelOfPrice');

                }
            }
            else{
                InformationDisplay("Sorry, You have to fill at least one Title below","alert-error");
                return false;
            }
        }
        var getCuid=$('#GetCuid').val();

        passtmp['SetUpSecondLevel']="Setup";
        passtmp['PassCuid']=getCuid;
        passtmp['SecondLevelTitleAndContent']=tmp;
        CuisineAjax(passtmp);
        return false;
    });


    //submit the form with update second level
    $modal.on('click','#UpdateSecondLevelForm',function(e){

        var getCount=$('.SecondTitleWrap').length;//get current length of second titles
        var tmp={};//second level includs titles and sub contents
        var passtmp={};//includes Current CuisineID and tmp;
        //loop and fill into array
        for (var i=0; i<getCount;i++){
            if($('.SecondTitleWrap').eq(i).find('.SecondTitle').val()!==''){
                if($('.SecondTitleWrap').eq(i).find('#SecondLevelCheckbox').is(':checked')){
                tmp[$('.SecondTitleWrap').eq(i).find('.SecondTitle').val()]=returnInputArray(i,'MultiChoice','SubLevelOfName','SubLevelOfPrice');
                }
                else {
                tmp[$('.SecondTitleWrap').eq(i).find('.SecondTitle').val()]=returnInputArray(i,'Radio','SubLevelOfName','SubLevelOfPrice');

                }
              }
            else{
                InformationDisplay("Sorry, You have to fill at least one Title below","alert-error");
                return false;
            }
        }
        var getCuid=$('#GetCuid').val();

        passtmp['updateSetUpSecondLevel']="Setup";
        passtmp['updatePassCuid']=getCuid;
        passtmp['updateKey']=ReturnUpdateKey("UpdateKey");
        passtmp['updateSecondLevelTitleAndContent']=tmp;
        CuisineAjax(passtmp);
        return false;
    });
    function ReturnUpdateKey(UpdateKey){
        var Temp=[];
        $('input[name="' + UpdateKey + '[]"]').each(function() {
            Temp.push($(this).val());
        });
        return Temp;
    }


    function returnInputArray(i,condition,SubLevelOfName,SubLevelOfPrice){
        var TemporaryArray1=[];
        var TemporaryArray2=[];
        var PrepareArray={};
        var ReturnArray={};
        var FinalResturn={};
        $('.SecondTitleWrap').eq(i).find('input[name="' + SubLevelOfName + '[]"]').each(function() {
            TemporaryArray1.push($(this).val());
        });
        $('.SecondTitleWrap').eq(i).find('input[name="' + SubLevelOfPrice + '[]"]').each(function() {
            TemporaryArray2.push($(this).val());
        });
        for (var i=0; i<TemporaryArray1.length;i++){
            PrepareArray['name']=TemporaryArray1[i];
            PrepareArray['price']=TemporaryArray2[i];
            ReturnArray['SubSecondLevel'+i]=PrepareArray;

            PrepareArray={};//clean the array
        }
        FinalResturn[condition]=ReturnArray;
        return FinalResturn;

    }





    /******************************************ajax list cuisine**********************************/
    CuisineAJAXList();

    function CuisineAJAXList(){
        var tmp={};
        tmp['ajaxCuisineList']='yes';
        tmp['GetCurrentResID']=$('#RestaruantID').val();
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
            $modal.load(CurrentDomain+'/CMS/business-Management/SubPages/DishesPack/addDishes.php', '', function(){
                $modal.modal();
                //select tags
                $("#Availability").chosen({no_results_text: "Oops, nothing found!"});
                $("#Cuisine").chosen({no_results_text: "Oops, nothing found!"});
                $("#Type").chosen({no_results_text: "Oops, nothing found!"});
                $("#Price").chosen({no_results_text: "Oops, nothing found!", max_selected_options: 1});
            });
        }, 1000);
    });
    //delete current cuisine
    $('body').on('click','.button-delete',function(){
        var getCuid=$(this).attr('id');
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
    function OrderCheckAJAX(GetCurrentOrder,CurrentResID,CuisineArray){
        var tmp={};
        tmp['GetOrginalOrder']=GetCurrentOrder;
        tmp['GetOrginalResID']=CurrentResID;
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
        var UpCurrentCuisinePrice=parseFloat($('#UpCuPrice').val()).toFixed(2);
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
        var CurrentCuisinePrice=parseFloat($('#CuPrice').val()).toFixed(2);
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
            tmp['CurrentCusinOrder']=parseInt(CurrentCusinOrder);
            //doing the order check first then run addnewdishe function
            OrderCheckAJAX(CurrentCusinOrder,CurrentResID,tmp);

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
            $('.modal-footer').empty();
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
            $modal.load(CurrentDomain+'/CMS/business-Management/SubPages/DishesPack/EditDishes.php?CUID='+encodeURIComponent(Cuid), '', function(){
                $modal.modal();
                //select tags
                $("#Availability").chosen({no_results_text: "Oops, nothing found!"});
                $("#Cuisine").chosen({no_results_text: "Oops, nothing found!"});
                $("#Type").chosen({no_results_text: "Oops, nothing found!"});
                $("#Price").chosen({no_results_text: "Oops, nothing found!",max_selected_options: 1});

            });
        }, 1000);


    });

    $('body').on('click','#click-Dishes',function(){

        CuisineAJAXList();

    });

    $('body').on('click','#click-Promotion',function(){

        PromotionAJAXList();

    });



    /*******************************************Restaurant avatar upload**************************************/
        //cp pic into special folder and get return path

    function imageUpload(Input_Photo,dataset)
    {
        $('#submitPic').html('Submitting.....');
        $.ajaxFileUpload
        (
            {
                url:CurrentDomain+'/CMS/BackEnd-controller/AjaxImage-controller.php',
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



    //MyRestaruant chosen
    $("#MyRestaruant-Availability").chosen({width: "100%",no_results_text: "Oops, nothing found!"});
    $("#MyRestaruant-Cuisine").chosen({width: "100%",no_results_text: "Oops, nothing found!"});
    //setting up the restaruant info
    $('body').on('submit','#MyRestaurant',function(e){
        //Get my restaurant ID
        var getRestauranName=$('#RestarurantName').val();
        var getDetailAddress=$('#RestarurantAddress').val();
        var getRootAddress=$('.MyResRootAddress').val();
        var getContactName=$('#RestarurantContactName').val();
        var getContactNumber=$('#RestarurantContactNumber').val();
        var getAvailabilityTag=$('#MyRestaruant-Availability').val();
        var getCuisineTag=$('#MyRestaruant-Cuisine').val();
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
        MyRestaurant['MyResDestailAddress']=getDetailAddress;
        MyRestaurant['MyRootAddress']=getRootAddress;
        MyRestaurant['MyResContactName']=getContactName;
        MyRestaurant['MyResContactNumber']=getContactNumber;
        MyRestaurant['MyResAvailabilityTag']=getAvailabilityTag;
        MyRestaurant['MyResCuisineTag']=getCuisineTag;
        MyRestaurant['MyResOpeningHours']=OpenHour;
        MyRestaurant['MyResRating']=0;
        MyRestaurant['MyResReview']=0;
        if(getDetailAddress==='' || getContactName==='' || getContactNumber==='' || getAvailabilityTag===null || !getCuisineTag===null){
            ErrorInfo('Sorry, you have to fill all fields');
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
                    SuccessInfo('Successfully updated');

                }
                else {
                    ErrorInfo('Sorry, The database ERROR');

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
            ErrorInfo('Sorry, you have to fill all fields');
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
                SuccessInfo(msg);
            }
            else{
                ErrorInfo(msg);
            }

        });

        request.fail(function( jqXHR, textStatus ) {
            alert( "Request failed: " + textStatus );
        });
    }

    function SuccessInfo(content){
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


   /***************************************** ADDED TO PROMOTION ************************************/
    $('body').on('click','.addedtoPromotion',function(){
        InformationDisplay('Warning, this function is for adding current cuisine into the list of promotion, and it will be charged after we contact to you',"alert-warning");
        var Tmp = {};
        var GetFeatureID = $(this).parent().find('.button-delete').attr('id');
        Tmp['Featured'] = 'Yes';
        Tmp['FeaturedType'] = 'Cuisine';
        Tmp['FeaturedID'] = GetFeatureID;
        PromotionAjax(Tmp,$(this),true);


    });


    $('body').on('click','#Applyfor',function(){
        InformationDisplay('Warning, this function is for adding current Restaurant into the list of promotion, and it will be charged after we contact to you',"alert-warning");
        var Tmp = {};
        var GetFeatureID = $('#RestaruantID').val();
        Tmp['Featured'] = 'Yes';
        Tmp['FeaturedType'] = 'Restaurant';
        Tmp['FeaturedID'] = GetFeatureID;
        PromotionAjax(Tmp,$(this),false);
    });


    function PromotionAjax(p,GetThis,condition){
        var request = $.ajax({
            url: CurrentDomain+"/CMS/BackEnd-controller/BackEnd-controller.php",
            type: "POST",
            data:p,
            dataType: "json"
        });
        request.done(function( msg ) {
           if (msg.status === 'successed'){
               if(condition){
               GetThis.remove();
               }
               else{
                   GetThis.fadeOut(500,function(){$(this).empty(); $(this).text('Pending...').fadeIn();});
               }
           }
           else if(msg.status === 'failured'){
               InformationDisplay('Error',"alert-error");


           }

        });

        request.fail(function( jqXHR, textStatus ) {
            alert( "Request failed: " + textStatus );
        });
    }
    /******************************************ajax list promotion**********************************/

    function PromotionAJAXList(){
        var tmp={};
        tmp['ajaxPromotionList']='yes';
        tmp['GetCurrentResID']=$('#RestaruantID').val();
        $('#ajaxPromotionTable').empty().append('<div class="AjaxLoading"><img src='+CurrentDomain+'/assets/framework/img/ajax-loader.gif></div>').fadeIn();
        var request = $.ajax({
            url: CurrentDomain+"/CMS/BackEnd-controller/BackEnd-controller.php",
            type: "POST",
            data:tmp,
            dataType: "html"
        });

        request.done(function( msg ) {

            $('#ajaxPromotionTable').empty().append(msg).fadeIn();


        });

        request.fail(function( jqXHR, textStatus ) {
            alert( "Request failed: " + textStatus );
        });


    }

    /***************************************** Requesting deleting ----cuisine********************************/
    $('body').on('click','.Requesting-delete',function(){
        var RequestingDeleteID = $(this).attr('id');
        var GetThis = $(this);
        PromotionRequestionDelete(RequestingDeleteID,GetThis.text('Requesting to Cancel'));
    });


    /***************************************** Requesting deleting ----Restaurant********************************/
    $('body').on('click','.RestPromotion-cancel',function(){
        var GetThis = $(this);
        var RequestingDeleteID = GetThis.attr('id');
        GetThis.parent().empty().append('<button class="button" type="button">Requesting to Cancel ...</button>');
        PromotionRequestionDelete(RequestingDeleteID,null);

    });


    function PromotionRequestionDelete(ReID,GetThisFunction){

        var request = $.ajax({
            url: CurrentDomain+"/CMS/BackEnd-controller/BackEnd-controller.php",
            type: "POST",
            data:{RequestingDeleteID:ReID},
            dataType: "json"
        });

        request.done(function( msg ) {
            if(msg.status === 'successed'){
                InformationDisplay('Warning! your have requesting to cancel a promotion from your promotion list',"alert-warning");
                GetThisFunction;
            }

        });

        request.fail(function( jqXHR, textStatus ) {
            alert( "Request failed: " + textStatus );
        });

    }


});


