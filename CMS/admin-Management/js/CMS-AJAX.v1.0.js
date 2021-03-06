//CMS-AJAX.v1.0.js is a js file that contains basic functions and AJAX functions of CMS


$(document).ready(function(){
    var CurrentDomain=window.location.origin;
    /*******************************************Login Management**************************************/
     $('body').on('click','#loginSubmit',function(){
        var tmpLoginUserName=$('#LoginUserName').val();
        var tmpLoginUserPassword=$('#LoginUserPassword').val();

        if (tmpLoginUserName!=='' && tmpLoginUserPassword!==''){
            var tmp={};
            tmp['LoginUserName']=tmpLoginUserName;
            tmp['LoginUserPassword']=tmpLoginUserPassword;
            var request= $.ajax({
                url:'../BackEnd-controller/BackEnd-controller.php',
                type: "POST",
                cache: false,
                data:tmp,
                dataType: "html"
            });
            request.done(function(content){
               if(content==="Error"){

                    $('<div class="alert alert-error">Your User Name or Password is incorrect!</div>').insertBefore($('#loginSubmit')).fadeIn(200);
                    setTimeout(function(){$('.alert-error').fadeOut(); },3000);

                }
                else if (content==='Pass'){
                   window.location.href = '../../CMS/admin-Management/index.php';

               }


            });
        }
         else{


            $('<div class="alert alert-error">Please filling all fields</div>').insertBefore($('#loginSubmit')).fadeIn(200);
            setTimeout(function(){$('.alert-error').fadeOut(); },5000);

        }



     });








    /*************************************Basic Tab function switch*********************************************/
    $('body').on('click','#BasicInfo-clicked',function(){
        __hidenDiv();
        $(this).find('a').addClass('achieve');
        $('#basicInfo').fadeIn(200); //when #BasicInfo-clicked is clicked, the #basicInfo will be showing
    });


    $('body').on('click','#addsLocation-clicked',function(){
        __hidenDiv();
        $(this).find('a').addClass('achieve');
        $('#addsLocation').fadeIn(200); //when #addsLocation-clicked is clicked, the #addsLocation will be showing
    });

    $('body').on('click','#Tags-clicked',function(){
        __hidenDiv();
        $(this).find('a').addClass('achieve');
        $('#TagsManagement').fadeIn(200); //when #Tags-clicked is clicked, the #TagsManagement will be showing
    });

    $('body').on('click','#Admin-clicked',function(){
        __hidenDiv();
        $(this).find('a').addClass('achieve');
        $('#adminMangement').fadeIn(200); //when #Admin-clicked is clicked, the #adminMangement will be showing

    });
    $('body').on('click','#UserList-clicked',function(){
        __hidenDiv();
        $(this).find('a').addClass('achieve');
        $('#UserList').fadeIn(200); //when #UserList-clicked is clicked, the #UserList will be showing

    });
    $('body').on('click','#MailSetting-clicked',function(){
        __hidenDiv();
        $(this).find('a').addClass('achieve');
        $('#Mail_Setting').fadeIn(200); //when #Admin-clicked is clicked, the #Mail_Setting will be showing

    });

    $('body').on('click','#AddedRestaurants-clicked',function(){
        __hidenDiv();
        $(this).find('a').addClass('achieve');
        $('#addedRestaurant').fadeIn(200);// when #addsRestaurant-clicked is cliked, the #addedCuisines will be showing

    });

    $('body').on('click','#AddedCuisines-clicked',function(){
        __hidenDiv();
        $(this).find('a').addClass('achieve');
        $('#addedCuisines').fadeIn(200);// when #addedCuisines-clicked is cliked, the #addedCuisines will be showing

    });

    $('body').on('click','#MobileEndOnline-clicked',function(){
        __hidenDiv();
        $(this).find('a').addClass('achieve');
        $('#MobileEndOnline').fadeIn(200);// when #addedCuisines-clicked is cliked, the #addedCuisines will be showing

    });

    $('body').on('click','#ConfigureManagerAndBinded-clicked',function(){
        __hidenDiv();
        $(this).find('a').addClass('achieve');
        $('#ConfigureManagerAndBinded').fadeIn(200);// when #addedCuisines-clicked is cliked, the #addedCuisines will be showing
        AjaxViewManagerOrDeliveryTable({viewManagerTable:'viewManagerTable'},'#refreshManagerTable');

    });
    $('body').on('click','#ConfigureDelivererAndManagerBinded-clicked',function(){
        __hidenDiv();
        $(this).find('a').addClass('achieve');
        $('#ConfigureDeliververAndManager').fadeIn(200);// when #addedCuisines-clicked is cliked, the #addedCuisines will be showing
        AjaxViewManagerOrDeliveryTable({viewDelivererTable:'viewDelivererTable'},'#refreshDeliververTable');

    });

    $('body').on('click','#RegisterNewManagerOrDelivery-clicked',function(){
        __hidenDiv();
        $(this).find('a').addClass('achieve');
        $('#RegisterNewManager_Deliver').fadeIn(200);// when #addedCuisines-clicked is cliked, the #addedCuisines will be showing

    });

    $('body').on('click','#FeaturedManagement-clicked',function(){
        __hidenDiv();
        $(this).find('a').addClass('achieve');
        $('#FeaturedManagement').fadeIn(200);// when #addedCuisines-clicked is cliked, the #addedCuisines will be showing

    });



    function __hidenDiv(){
        $('#main-nav li').find('.Nav-list li a').removeClass('achieve');
        $('#initialPage').fadeOut(200); //hiding the initial page
        $('#basicInfo').fadeOut(200); //hiding the basicInfo page
        $('#addsLocation').fadeOut(200);//hiding the addsLocation page
        $('#TagsManagement').fadeOut(200);//hiding the tags page
        $('#adminMangement').fadeOut(200);//hiding the adminMangement page
        $('#UserList').fadeOut(200);//hiding the UserList page
        $('#Mail_Setting').fadeOut(200);//hiding the Mail_Setting page
        $('#addedRestaurant').fadeOut(200);//hiding the addsRestaurant page
        $('#addedCuisines').fadeOut(200);//hiding the addedCuisines page
        $('#ConfigureManagerAndBinded').fadeOut(200);//hiding the  $('#ConfigureManagerAndBinded')
        $('#ConfigureDeliververAndManager').fadeOut(200);//hiding the  $('#ConfigureManagerAndBinded')
        $('#MobileEndOnline').fadeOut(200);//hiding the $('#MobileEndOnline')
        $('#RegisterNewManager_Deliver').fadeOut(200);//hiding the $('#RegisterNewManager_Deliver')
        $('#FeaturedManagement').fadeOut(200);//hiding the $('#FeaturedManagement-clicked')

    }


    /************************************Basic setting **************************************************/
    $('body').on('click','#BasicInforSaving',function(){

        var SiteName=$('#SiteName').val();
        var ObjSiteNmae="SiteName";
        var SiteDesc=$('#SiteDescr').val();
        var ObjSiteDesc="SiteDescr";
        var SiteSiteUrl=$('#SiteUrl').val();
        var ObjSiteUrl="SiteSiteUrl";
        var SiteSiteEmail=$('#SiteEmail').val();
        var ObjSiteSiteEmail="SiteSiteEmail";
        var SiteSiteStatus=$('#SiteStatus').val();
        var ObjSiteSiteStatus="SiteSiteStatus";
        var SitePolicy=$('#SitePolicy').val();
        var ObjSitePolicy="SitePolicy";
        var DeliveryFee=$('#DeliveryFee').val();
        var ObjDeliveryFee="DeliveryFee"
        var TmpArray={};
        TmpArray[ObjSiteNmae]=SiteName;
        TmpArray[ObjSiteDesc]=SiteDesc;
        TmpArray[ObjSiteUrl]=SiteSiteUrl;
        TmpArray[ObjSiteSiteEmail]=SiteSiteEmail;
        TmpArray[ObjSiteSiteStatus]=SiteSiteStatus;
        TmpArray[ObjSitePolicy]=SitePolicy;
        TmpArray[ObjDeliveryFee]=DeliveryFee;


        BasicSettingAjax(TmpArray);//pass the array to ajax;
    });


    function BasicSettingAjax(dataObj){

        var request= $.ajax({
            url:'../BackEnd-controller/BackEnd-controller.php',
            type: "POST",
            cache: false,
            data:dataObj,
            dataType: "html"
        });
        request.done(function(content){

            if(content==="Saved successfully"){
                $('<div class="alert alert-info"><strong>Saved successfully</div>').insertBefore($('#BasicInforSaving')).fadeIn(200);
                setTimeout(function(){$('.alert-info').fadeOut(); },5000);
            }
            else if(content==="Error"){

                $('<div class="alert alert-error"><strong>You mush be filling all blank</div>').insertBefore($('#BasicInforSaving')).fadeIn(200);
                setTimeout(function(){$('.alert-error').fadeOut(); },5000);

            }


        });
    }

    /*******************************************Administrator Management**************************************/
        //cp pic into special folder and get return path



    function imageUpload(Input_AdministratorPhoto,dataset)
    {
        $('#submitPic').html('Submitting.....');

        $.ajaxFileUpload
        (
            {
                url:'../BackEnd-controller/AjaxImage-controller.php',
                secureuri:false,
                fileElementId:Input_AdministratorPhoto,
                dataType: 'html',
                data:dataset,
                success: function (data, status)
                {
                    $('#submitPic').html('done');
                    var tmpPath= $('#gobalPath').val();

                    var savedPath=tmpPath+data;
                        $('#AdministratorImagePath').removeClass('placeholder');
                        $('#AdministratorImagePath').val(savedPath);
                        $('<img class="img-circle" src='+tmpPath+data +'>').insertAfter($('#Input_AdministratorPhoto')).fadeIn(200);

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
        if($("#Input_AdministratorPhoto")[0].files[0]!==undefined){
            var file = $("#Input_AdministratorPhoto")[0].files[0];
            var fileName = file.name;
            var fileSize = file.size;
            var fileType = file.type;

            $('<label class="fileinfo">'+fileName+', '+ fileSize+' bytes FileType: ' +fileType+' </label>').insertAfter($('#submitPic')).fadeIn(200);

            var tmp={};
            tmp['Input_Photo']='Input_AdministratorPhoto';
            tmp['Mode_UserPic']='AdministratorPhoto';
            imageUpload('Input_AdministratorPhoto',tmp);



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


    //Ajax all data through the class and insert into database
    $('body').on('click','#SubmitAdministratorInfo',function(){
        var AdministratorID=$('#Input_AdministratorID').val();
        var AdministratorName=$('#Input_Administrator').val();
        var AdministratorPassword=$('#inputPassword').val();
        var AdministratorEmail=$('#Input_AdministratorEmail').val();
        var AdministratorPhone=$('#Input_AdministratorPhone').val();
        var AdministratorPhotoPath=$('#AdministratorImagePath').val();
        var AdministratorType=$('#Input_FixedAdministratorType').val();

        if (AdministratorName!=='' && AdministratorPassword!=='' && AdministratorEmail!=='' && AdministratorPhone!=='' && AdministratorPhotoPath!=='' && AdministratorType!==''){
            var tmpArray={};
            tmpArray['AdministratorID']=AdministratorID;
            tmpArray['AdministratorName']=AdministratorName;
            tmpArray['AdministratorPassword']=AdministratorPassword;
            tmpArray['AdministratorEmail']=AdministratorEmail;
            tmpArray['AdministratorPhone']=AdministratorPhone;
            tmpArray['AdministratorPhotoPath']=AdministratorPhotoPath;
            tmpArray['AdministratorType']=AdministratorType;
            AdminAjax(tmpArray);
        }
        else{

            $('<div class="alert alert-error"><strong>You mush be filling all blank</div>').insertBefore($('#SubmitAdministratorInfo')).fadeIn(200);
            setTimeout(function(){$('.alert-error').fadeOut(); },5000);

        }

    });


    function AdminAjax(dataObj){
        var request= $.ajax({
            url:'../BackEnd-controller/BackEnd-controller.php',
            type: "POST",
            cache: false,
            data:dataObj,
            dataType: "html"
        });
        request.done(function(content){

            if(content==="Updated successfully"){
                $('<div class="alert alert-info"><strong>Updated successfully</div>').insertBefore($('#SubmitAdministratorInfo')).fadeIn(200);
                setTimeout(function(){$('.alert-info').fadeOut(); },5000);
            }
            else if(content==="Updated Error"){

                $('<div class="alert alert-error"><strong>You mush be filling all blank</div>').insertBefore($('#SubmitAdministratorInfo')).fadeIn(200);
                setTimeout(function(){$('.alert-error').fadeOut(); },5000);

            }

        });

    }


    /*******************************************Tags**********************************************************/
        //define: if the adds element into the database, then sets parameter as 0

    function refreshTagslistAJAX(tableName,tagsName,buttonID){//this function only passes parameters to the controlloer and gets tag list back
        var dataObj={};
        dataObj['RefreshTagsTableName']=tableName;
        dataObj['RefreshTagsName']=tagsName;
        var request=$.ajax({
            url:'../BackEnd-controller/BackEnd-controller.php',
            type: "POST",
            cache: false,
            data:dataObj,
            dataType: "html"
        });
        request.done(function(Listcontent){
            $(buttonID).empty().append(Listcontent).fadeIn();

        });

    }

    function refreshTagsList(dataObj){
        if(dataObj['TagsTableName']==='CuisineTags'&& dataObj['TagsID']==='Availability'){
            refreshTagslistAJAX('CuisineTags','Availability','#CuisineAvailabilityTagsList');
        }
        else if(dataObj['TagsTableName']==='CuisineTags'&& dataObj['TagsID']==='Cuisine'){
            refreshTagslistAJAX('CuisineTags','Cuisine','#CuisineCuisineTagsList');
        }
        else if(dataObj['TagsTableName']==='CuisineTags'&& dataObj['TagsID']==='Type'){
            refreshTagslistAJAX('CuisineTags','Type','#CuisineTypeTagsList');
        }
        else if(dataObj['TagsTableName']==='CuisineTags'&& dataObj['TagsID']==='Price'){
            refreshTagslistAJAX('CuisineTags','Price','#CuisinePriceTagsList');
        }
    }
    function TagAjax(dataObj){
        var request = $.ajax({
            url:'../BackEnd-controller/BackEnd-controller.php',
            type: "POST",
            cache: false,
            data: dataObj,
            dataType: "html"
        });
        request.done(function(content){
            if(content==="Added successfully"){
                refreshTagsList(dataObj);

            }
            else if(content==="Deleted successfully"){
                refreshTagsList(dataObj);

            }

        });
    }


    function TmpArray(GetTagsIDValue,GetTagsValue,GetTagsTableName,GetDeleteCondiiton,GetIndexID){//common function
        //declare bleow code is related to which table you wanna inset to.
        var TagsID="TagsID";
        //gets the value that you wanna insert the table.
        var TagsValue="TagsValue";
        var TmpArray={};
        TmpArray[TagsID]=GetTagsIDValue;
        TmpArray[TagsValue]=GetTagsValue;
        TmpArray['TagsTableName']=GetTagsTableName;
        TmpArray['DeleteCondition']=GetDeleteCondiiton;
        TmpArray['IndexID']=GetIndexID;

        return TmpArray;


    }

    /***********************************************Delete Tags**************************************************/
    window.TmpDeleteArray={};//sets gobal function that is able to return the array while it is clicked
    $('body').on('click','.tagslist',function(){
        window.TmpDeleteArray={};//every time rest array
        var TagsListChildValue=$(this).children(':selected').val();
        var TagsTableName=$(this).children(':selected').attr('id');
        var TagsListParentID=$(this).attr('id');
        TmpDeleteArray['TagsID']=TagsListParentID;
        TmpDeleteArray['TagsValue']=TagsListChildValue;
        TmpDeleteArray['TagsTableName']=TagsTableName;
        TmpDeleteArray['DeleteCondition']="True";

        return window.TmpDeleteArray;
    });

//remove tags
    $('body').on('click','#RemoveCuisAvailabilityButton',function(){//remove Availability in Availability function
        window.TmpDeleteArray['IndexID']='CuisineTagesID';
        TagAjax(window.TmpDeleteArray);
    });
    $('body').on('click','#RemoveCuisCuisineButton',function(){//remove Availability in Cuisine function
        window.TmpDeleteArray['IndexID']='CuisineTagesID';

        TagAjax(window.TmpDeleteArray);
    });
    $('body').on('click','#RemoveCuisTypeButton',function(){//remove Availability in Type function
        window.TmpDeleteArray['IndexID']='CuisineTagesID';

        TagAjax(window.TmpDeleteArray);
    });
    $('body').on('click','#RemoveCuisPriceButton',function(){//remove Availability in Price function
        window.TmpDeleteArray['IndexID']='CuisineTagesID';
        TagAjax(window.TmpDeleteArray);
    });






    /***********************************************Add Tags*****************************************/


        //This containts Availability in Cuisine
    $('body').on('click','#AddCuisAvailabilityButton',function(){
        TagAjax(TmpArray('Availability',$('#InputCuisAvailability').val(),'CuisineTags','False','CuisineTagesID'));
    });

    //This containts Cuisine in Cuisine
    $('body').on('click','#AddCuisCuisineButton',function(){
        TagAjax(TmpArray('Cuisine',$('#InputCuisCuisine').val(),'CuisineTags','False','CuisineTagesID'));
    });
    //This containts Type in Cuisine
    $('body').on('click','#AddCuisTypeButton',function(){
        TagAjax(TmpArray('Type',$('#InputCuisType').val(),'CuisineTags','False','CuisineTagesID'));
    });
    //This containts Price in Cuisine
    $('body').on('click','#AddCuisPriceButton',function(){
        TagAjax(TmpArray('Price',$('#InputCuisPirce').val(),'CuisineTags','False','CuisineTagesID'));
    });


    /************************************Add Mail management**************************************************/
    $('body').on('click','#ConstructOfActiveMailButton',function(){
       var ConstructOfActiveMail=$('#ConstructOfActiveMail').val();
       var ConstructOfActiveMailContent=CKEDITOR.instances.ConstructOfActiveMailContent.getData();// get value of instance of Ckkeditor
       var TitleOfConstructOfActiveMail=$('#TitleOfConstructOfActiveMail').val();
        var tmpArray={};
       tmpArray['ConstructOfActiveMail']=ConstructOfActiveMail;
       tmpArray['ConstructOfActiveMailContent']=ConstructOfActiveMailContent;
       tmpArray['TitleOfConstructOfActiveMail']=TitleOfConstructOfActiveMail;
       tmpArray['UserMailActiveID']="ActivactionMail";
        var request= $.ajax({
            url:'../BackEnd-controller/BackEnd-controller.php',
            type: "POST",
            cache: false,
            data:tmpArray,
            dataType: "html"
        });
        request.done(function(content){
            if(content==="Saved Successful"){

                $('<div class="alert alert-info">Update Successed</div>').insertBefore($('#ConstructOfActiveMailButton')).fadeIn(200);
                setTimeout(function(){$('.alert-info').fadeOut(); },3000);

            }
            else if(content==='Error'){
                $('<div class="alert alert-error">Update Error</div>').insertBefore($('#ConstructOfActiveMailButton')).fadeIn(200);
                setTimeout(function(){$('.alert-error').fadeOut(); },3000);

            }



        });


    });



    /************************************Add Location blocks**************************************************/

    //upload the pic
    function LocationimageUpload(Input_LocationPhoto,dataset)
    {
        $('#LocationsubmitPic').html('Submitting.....');

        $.ajaxFileUpload
        (
            {
                url:'../BackEnd-controller/AjaxImage-controller.php',
                secureuri:false,
                fileElementId:Input_LocationPhoto,
                dataType: 'html',
                data:dataset,
                success: function (data, status)
                {
                    $('#LocationsubmitPic').html('done');
                    var tmpPath= $('#LocalHidePath').val();
                    var savedPath=tmpPath+data;
                    $('#LocationImagePath').removeClass('placeholder');
                    $('#LocationImagePath').val(savedPath);
                    $('#LocationIMG').attr("src",tmpPath+data);
                },
                error: function (data, status, e)
                {
                    alert(e);
                }
            }
        )

        return false;

    }




    $('body').on('click','#LocationsubmitPic',function() {
        if($("#Input_LocationPhoto")[0].files[0]!==undefined){
            var file = $("#Input_LocationPhoto")[0].files[0];
            var fileName = file.name;
            var fileSize = file.size;
            var fileType = file.type;

            $('<label class="fileinfo">'+fileName+', '+ fileSize+' bytes FileType: ' +fileType+' </label>').insertAfter($('#LocationsubmitPic')).fadeIn(200);
            var tmp={};
            tmp['Input_Photo']='Input_LocationPhoto';
            tmp['Mode_Location']='AdministratorPhoto';
            LocationimageUpload('Input_LocationPhoto',tmp);



        }
        else if($(this).html()==='done'){
            $('<label id="exeisted-alert" style="color:red">You already submited the head photo</label>').insertAfter($('#LocationsubmitPic')).fadeIn(200);
            setTimeout(function(){$('#exeisted-alert').fadeOut(); },5000);
            return false;

        }
        else
        {
            $('<label id="File-alert" style="color:red">Please select file first</label>').insertAfter($('#LocationsubmitPic')).fadeIn(200);
            setTimeout(function(){$('#File-alert').fadeOut(); },5000);



        }



    });




    $('body').on('click','#AddLocationButton',function(){//here is using click function instead of submit because of security
        var RootLocation= $("input[name='RootLocation']").val();
        var RootLocationPic=$("#LocationImagePath").val();
        var RootLocationID=$("input[name='RootLocationID']").val();
        var TemporaryArray={};
        TemporaryArray[RootLocationID]=RootLocation;
        var SubLocation=returnInputArray("SubLocation","SubLocationID");
        if (RootLocation!==""){
            var dataObj = {};
            dataObj["RootLocationID"]=RootLocationID;
            dataObj["RootLocation"]=RootLocation;
            dataObj["RootLocationPic"]=RootLocationPic;
            dataObj["SubLocation"]=SubLocation;

            Ajax('#AddLocationButton',dataObj);


        }
        else {

            $('<div class="alert alert-error"><strong>Root Location cannot be empty</strong></div>').insertBefore($('#AddLocationButton')).fadeIn(200);
            setTimeout(function(){
                $('.alert-error').fadeOut();

            },5000)
            $('#RootLocation').select();

        }



    });


    $('body').on('click','#AddMoreSubLocation',function(){
        $('<div class="control-group"><label class="control-label">Sub Location:</label><div class="controls"><input type="text" class="input-xlarge" name="SubLocation[]" placeholder="i.e: one of sub levels of locations" > <input type="text" class="input" name="SubLocationID[]" placeholder="XX: The sub location ID" ></div></div>').insertAfter('#MarkRootLocation').fadeIn(200);

    });

    $('body').on('click','.ChangeLocationButton_AddMore',function(){
        $('<div class="control-group"><div class="controls"><input type="text" class="input-xlarge" name="ChangeSubLocation[]" placeholder="i.e: one of sub levels of locations" > <input type="text" class="input" name="ChangeSubLocationID[]" placeholder="XX: The sub location ID" ></div></div>').insertAfter('.changeSubGroup:last').fadeIn(200);

    });

    function returnInputArray(inputArrayName,inputArrayID){
        var TemporaryArray1=[];
        var TemporaryArray2=[];
        var ReturnArray={};
        $('input[name="' + inputArrayName + '[]"]').each(function() {
            TemporaryArray1.push($(this).val());
        });

        $('input[name="' + inputArrayID + '[]"]').each(function() {
            TemporaryArray2.push($(this).val());
        });

        for (var i=0; i<TemporaryArray1.length;i++){
            ReturnArray[TemporaryArray2[i]]=TemporaryArray1[i];


        }

        return ReturnArray;

    }


    function Ajax(ContentId,dataInfo){//Add location AJAX

        $(ContentId).empty().append('<img src="../../assets/framework/img/ajax-loader.gif">').fadeIn();
        var request = $.ajax({
            url:'../BackEnd-controller/BackEnd-controller.php',
            type: "POST",
            cache: false,
            data: dataInfo,
            dataType: "html"

        });

        request.done(function(msg) {
            $(ContentId).empty().append("Add").fadeIn();
            if (msg==="Successed"){

                $('<div class="alert alert-info"><strong>Successed</strong></div>').insertBefore($('#AddLocationButton')).fadeIn(200);
                setTimeout(function(){$('.alert-info').fadeOut(); },5000);

                ReFreshLocationTable();


            }

            else if (msg==="Error"){

                $('<div class="alert alert-error"><strong>Cannot Added Location due to database error or replated data</strong></div>').insertBefore($('#AddLocationButton')).fadeIn(200);
                setTimeout(function(){$('.alert-error').fadeOut(); },5000);

            }
            else if(msg==="repeated"){

                $('<div class="alert alert-error"><strong>The location that you input cannot be repeated</strong></div>').insertBefore($('#AddLocationButton')).fadeIn(200);
                setTimeout(function(){$('.alert-error').fadeOut(); },5000);

            }

        });

        request.fail(function(jqXHR, textStatus) {

            $('<div class="alert alert-error"><strong>cannot process AJAX</strong></div>').insertBefore($(ContentId)).fadeIn(200);
            setTimeout(function(){
                $('.alert-error').fadeOut();

            },5000)
        });
    }


    function ReFreshLocationTable(){//only requests from successed Location AJAX

        //ajax loading table list of Location
        $('#LocationlistTable').empty().append('<img src="../../assets/framework/img/ajax-loader.gif">').fadeIn();

        var request= $.ajax({
            url:'../BackEnd-controller/BackEnd-controller.php',
            type: "POST",
            cache: false,
            data:{ReFreshList : "ReFreshLocation"},
            dataType: "html"
        });
        request.done(function(content){
            $('#LocationlistTable').empty().append(content);
        });

    }



//delete current record
    $('body').on('click','.delete',function(){
        var GetRootID=$(this).parent().parent().find('.GetLevelOneID').text();
        var GetSubID=$(this).parent().parent().find('.GetLevelTwoID').text();
        var dataObj = {};
        dataObj["GetDeleteRootLocationID"]=GetRootID;
        dataObj["GetDeleteSubLocationID"]=GetSubID;
        ModifyAndDeleteAjax(dataObj);


    });


    $('body').on('click','.ChangeLocationButton',function(){//here is using click function instead of submit because of security

        var GetID=$(this).attr('id');

        var ChangeRootLocation=$("#ChangeRootLocation").val();
        console.log(ChangeRootLocation);


        var ChangeRootLocationID=$("#ChangeRootLocationID").val();
        var TemporaryArray={};
        TemporaryArray[ChangeRootLocationID]=ChangeRootLocation;


        var ChangeSubLocation=returnInputArray("ChangeSubLocation","ChangeSubLocationID");
        var name1 = "ChangeRootLocation";
        var value1 =TemporaryArray;
        var name2 = "ChangeSubLocation";
        var value2 =ChangeSubLocation;
        var name3 = "GetID";
        var value3 =GetID;

        var dataObj = {};
        dataObj[name1]=value1;
        dataObj[name2]=value2;
        dataObj[name3]=value3;
       ModifyAndDeleteAjax(dataObj);



    });




    function ModifyAndDeleteAjax(dataObj){

        var request= $.ajax({
            url:'../BackEnd-controller/BackEnd-controller.php',
            type: "POST",
            cache: false,
            data:dataObj,
            dataType: "html"
        });
        request.done(function(content){
            if(content==="Deleted successfully"){
                $('<div class="alert alert-info"><strong>Delete successful</div>').insertAfter($('#LocationlistTable')).fadeIn(200);
                setTimeout(function(){$('.alert-info').fadeOut(); },5000);
                ReFreshLocationTable();
            }
            else if(content==="Modified successfully"){
                $('<br><div class="alert alert-info"><strong>Modify successful</div>').insertBefore($('#LocationlistTable')).fadeIn(200);
                setTimeout(function(){$('.alert-info').fadeOut(); },5000);
                $('.LocationModify').empty().fadeOut();
                ReFreshLocationTable();
            }
            else {
                $(content).insertBefore($('#LocationlistTable')).fadeIn(200);


            }

        });
    }



/*******************************************User list*************************************************/
Loading_more();
function Loading_more(){
    size_tr = $("#UserTableList>tbody>tr").size();
    x=3;
    $('#UserTableList>tbody>tr:lt('+x+')').show();
    $('#ShowMoreUsers').click(function () {
        x= (x+5 <= size_tr) ? x+5 : size_tr;
        $('#UserTableList>tbody>tr:lt('+x+')').show();
        if(x == size_tr){
            $('#ShowMoreUsers').hide();
        }
    });
}



//checkbox check and delete element


$('body').on('click','#UserListDelete',function(){
    var values = $('input:checkbox:checked.checkboxclass').map(function () {
        return this.value;//return each value
    }).get();
    var tmp={};
    tmp['DeleteUserID']=values;
   UserListAJAX(tmp,'#Input-Search');

});

//search user by email

  $('body').on('click','#UserListSearch',function(){
    if($('#Input-Search').val()!==''){
      var GetUserEmail=$('#Input-Search').val();
      var tmp={};
      tmp['GetUserEmail']=GetUserEmail;
      UserListAJAX(tmp,'#Input-Search');
    }
    else if($('#Input-Search').val()===''){

        var GetUserEmail=$('#Input-Search').val();
        var tmp={};
        tmp['GetUserEmail']='All';
        UserListAJAX(tmp,'#Input-Search');

    }


  });


    function UserListAJAX(dataObj,InfoID){//search and delete functions
        $('#TableListWrap').empty().append('<img src='+CurrentDomain+'/assets/framework/img/ajax-loader.gif>')
        var request= $.ajax({
            url:'../BackEnd-controller/BackEnd-controller.php',
            type: "POST",
            cache: false,
            data:dataObj,
            dataType: "html"
        });
        request.done(function(content){
                $('#TableListWrap').empty().append(content);
            Loading_more();
            });
    }
/***************************************************Restaurant registation****************************/
    $('body').on('submit','#MyRestaurant',function(e){
        var GetResturantEmail=$('#RestaruantEmail').val();
        var GetResturantPass=$('#RestarurantPassword').val();
        var RegisterStatus=1;
        var RegisterType="Restaturant";
        var tmp={};
        tmp['RegResturantEmail']=GetResturantEmail;
        tmp['RegGetResturantPass']=GetResturantPass;
        tmp['RegisterStatus']=1;
        tmp['RegisterType']=RegisterType;
        tmp['RegisterPicpathPrefix']=CurrentDomain;
        console.log(tmp);
        if(GetResturantEmail==='' || GetResturantPass===''){
            $('<div class="alert alert-error"><strong>Sorry, you have to fill all fields</div>').insertAfter($('#infozone')).fadeIn(200);
            setTimeout(function(){$('.alert-error').fadeOut(); },5000);
        }
        else{
        var request= $.ajax({
            url:CurrentDomain+'/CMS/BackEnd-controller/BackEnd-controller.php',
            type: "POST",
            cache: false,
            data:tmp,
            dataType: "html"
        });
        request.done(function(content){
            if(content==='Repeated UserMail'){
                $('<div class="alert alert-error"><strong>Sorry Repeated Mail address</div>').insertAfter($('#infozone')).fadeIn(200);
                setTimeout(function(){$('.alert-error').fadeOut(); },5000);
            }

            else if(content==='successed'){
                $('<div class="alert alert-info"><strong>added a new restaurant</div>').insertAfter($('#infozone')).fadeIn(200);
                setTimeout(function(){$('.alert-info').fadeOut(); },5000);
            }
            else if(content==='error'){
                $('<div class="alert alert-error"><strong>sorry, there is an error happended on database, please try it later</div>').insertAfter($('#infozone')).fadeIn(200);
                setTimeout(function(){$('.alert-error').fadeOut(); },5000);
            }

        });
        }


        return false;
    });




    /*****************************************Cop - Mobile end js******************************/

    /**
     * Register Manager or Deliverer
     */
    $('body').on('submit','#Register_Manager_Deliverer_form',function(e){
        event.preventDefault();
        var data = {};
        data['Manager_Deliverer_Register'] = 'yes';
        data['Manager_DeliverEmail'] = $('#Manager_DeliverEmail').val();
        data['Manager_DeliverPassword'] = $('#Manager_DeliverPassword').val();
        data['Manager_Deliver_Name'] = $('#Manager_Deliver_Name').val();
        data['Manager_Deliver_Type'] = $('.Manager_Deliver_selection').val();
        data['Manager_Deliver_Phone'] = $('#Manager_Deliver_Phone').val();
        RegisterManager_Deliverer_AJAX(data);
        return false;
    });


    /**
     * send register function
     *
     */
    function RegisterManager_Deliverer_AJAX(data){
        var request = $.ajax({
            url:'../BackEnd-controller/BackEnd-controller.php',
            type: "POST",
            cache: false,
            dataType: "json",
            data:data
        });

        request.done(function(data){
            if(data.status === 'successed'){
                refresh_query_table({'refreshManagerTable':'yes','refreshType':'Manager'},'.ManagerTable');
                refresh_query_table({'refreshManagerTable':'yes','refreshType':'Deliverer'},'.DeliververTable');
                $('<div class="alert alert-success"><strong>Operateion is sucessfully</div>').appendTo($('.DisplayForm')).fadeIn(200);
                setTimeout(function(){$('.alert-success').fadeOut(); },5000);

            }
            else if(data.status === 'failured'){
                $('<div class="alert alert-error"><strong>Sorry, repeat User registered info</div>').appendTo($('.DisplayForm')).fadeIn(200);
                setTimeout(function(){$('.alert-error').fadeOut(); },5000);
            }

        });
    }


    /**
     * ajax refresh the query table
     */

    function refresh_query_table(data,element){
        var request = $.ajax({
            url:'../BackEnd-controller/BackEnd-controller.php',
            type: "POST",
            cache: false,
            dataType: "html",
            data:data
        });

        request.done(function(data){
            $(element).fadeOut(500,function(){$(this).empty().append(data).fadeIn(500);});

        });
    }


    /**
     * Manager binding
     */


    $('.submitManager').on('click',function(){
        //input field
        var ManagerSelectID = $('.SelectionManagerID').val();
        //select LocationID
        var SelectedLocationID = $('.SelectLocationID').val();
        var managerAJAXVariable = {};

        managerAJAXVariable['managerAJAX'] = 'managerAJAX';
        managerAJAXVariable['ManagerSelectID'] = ManagerSelectID;
        managerAJAXVariable['SelectedLocationID'] = SelectedLocationID;
        managerAJAX(managerAJAXVariable);

    });

    /**
     * ajax submit ---- insert record
     */
    function managerAJAX(p){
        var request= $.ajax({
            url:'../BackEnd-controller/BackEnd-controller.php',
            type: "POST",
            cache: false,
            data:p,
            dataType: "json"
        });

        request.done(function(data){
            if(data.status === 'successed'){
                $('<div class="alert alert-success"><strong>Operateion is sucessfully</div>').insertAfter($('.input-append')).fadeIn(200);
                AjaxViewManagerOrDeliveryTable({viewManagerTable:'viewManagerTable'},'#refreshManagerTable');
                setTimeout(function(){$('.alert-success').fadeOut(); },5000);
            }
            if(data.status === 'failed'){
                $('<div class="alert alert-error"><strong>Sorry, Current Manager already been binded</div>').insertAfter($('.input-append')).fadeIn(200);
                setTimeout(function(){$('.alert-error').fadeOut(); },5000);
            }
        });
    }


    /**
     * Deliverer binding
     */
    $('.submitDeliverver').on('click',function(){
        var ManagerSelectID = $('._SelectionManagerID').val();
        //select Deliverer
        var DelivererSelectID = $('._SelectionDelivererID').val();
        var DelivererAJAXVariable = {};

        DelivererAJAXVariable['DelivererAJAX'] = 'DelivererAJAX';
        DelivererAJAXVariable['ManagerSelectID'] = ManagerSelectID;
        DelivererAJAXVariable['DelivererSelectID'] = DelivererSelectID;
        DelivererAJAX(DelivererAJAXVariable);

    });

    /**
     * ajax submit ---- insert record
     */
    function DelivererAJAX(p){
        var request= $.ajax({
            url:'../BackEnd-controller/BackEnd-controller.php',
            type: "POST",
            cache: false,
            data:p,
            dataType: "json"
        });

        request.done(function(data){
            if(data.status === 'successed'){
                $('<div class="alert alert-success"><strong>Operateion is sucessfully</div>').insertAfter($('.input-append')).fadeIn(200);
                AjaxViewManagerOrDeliveryTable({viewDelivererTable:'viewDelivererTable'},'#refreshDeliververTable');
                setTimeout(function(){$('.alert-success').fadeOut(); },5000);
            }
            if(data.status === 'failed'){
                $('<div class="alert alert-error"><strong>Sorry, Current Manager already been binded</div>').insertAfter($('.input-append')).fadeIn(200);
                setTimeout(function(){$('.alert-error').fadeOut(); },5000);
            }
        });
    }



    /**
     *
     */
    $('body').on('click','.deleteManagerOrDeliverer',function(){
        var GetIndexID = $(this).parent().parent().find('.ManagerOrDeliververID').text();
        var tmp = {};
        tmp['ManagerOrDelivererDelete'] = 'yes';
        tmp['GetIndexID'] = GetIndexID;
        tmp['DeleteType'] = 'User_Manager_Or_Deliverer';
        AjaxManagerDeletefunction(tmp,$(this).parent().parent());

    });

    /**
     * Deleteing current Manager that had been binded already
     */
    $('body').on('click','.deleteManager',function(){
        var GetIndexID = $(this).parent().parent().find('.IndexID').text();
        var tmp = {};
        tmp['ManagerOrDelivererDelete'] = 'yes';
        tmp['GetIndexID'] = GetIndexID;
        tmp['DeleteType'] = 'Delete_Manager_location';

        AjaxManagerDeletefunction(tmp,$(this).parent().parent());

    });


    /**
     * Deleting current Deliverer that had been binded already
     */

    $('body').on('click','.deleteDeliverer',function(){
        var GetIndexID = $(this).parent().parent().find('.IndexID').text();
        var tmp = {};
        tmp['ManagerOrDelivererDelete'] = 'yes';
        tmp['GetIndexID'] = GetIndexID;
        tmp['DeleteType'] = 'Delete_Deliverer_Manager_location';

        AjaxManagerDeletefunction(tmp,$(this).parent().parent());

    });

    /**
     * Ajax submit ---- delete
     */

    function AjaxManagerDeletefunction(tmp,getThis){

        var request = $.ajax({
            url:'../BackEnd-controller/BackEnd-controller.php',
            type: "POST",
            cache: false,
            dataType: "json",
            data:tmp
        });

        request.done(function(data){

            if(data.status === 'successed'){
                getThis.remove();
            }
            if(data.status === 'failed'){
                getThis.empty();
                $('<div class="alert alert-error"><strong>Sorry, system error, please contract to Admin</div>').appendTo(getThis).fadeIn(200);
                setTimeout(function(){$('.alert-error').fadeOut(); },5000);
            }

        });


    }

    /**
     * Ajax view the manager or delivery's table
     * @constructor
     */
    function AjaxViewManagerOrDeliveryTable(tmp,elementForDisplay){
        var request = $.ajax({
            url:'../BackEnd-controller/BackEnd-controller.php',
            type: "POST",
            cache: false,
            dataType: "html",
            data:tmp
        });

        request.done(function(data){
            $(elementForDisplay).empty().append(data);

        });
    }

/************************************** Management Featured **************************************/
   $('body').on('click','.FeatureCuisineActive',function(){

       var values = $('input:checkbox:checked.FeaturedCuisineCheckBox').map(function () {
           return this.value;//return each value
       }).get();
       //set up the new object array
        var containter = {};
       containter['ActiveFecture'] = 'yes';
       containter['FeatureCuisineIDArray'] = values;
       featuredAJAX(containter,'FecturendCusine');
   });


   $('body').on('click','.FeatureCuisineDelete',function(){
       var values = $('input:checkbox:checked.FeaturedCuisineCheckBox').map(function () {
           return this.value;//return each value
       }).get();
       var containter = {};
       containter['FectureDelete'] = 'yes';
       containter['FeatureCuisineIDArray'] = values;
       featuredAJAX(containter,'FecturendCusineDelete');
       console.log(containter);
   });







   $('body').on('click','.FeatureRestaurantActive',function(){

       var values = $('input:checkbox:checked.FeaturedRestaurantCheckBox').map(function () {
           return this.value;//return each value
       }).get();
       //set up the new object array
        var containter = {};
       containter['ActiveFecture'] = 'yes';
       containter['FeatureRestaurantIDArray'] = values;
       featuredAJAX(containter,'FecturendRestaurant');
   });


   $('body').on('click','.FeatureRestaurantDelete',function(){
       var values = $('input:checkbox:checked.FeaturedRestaurantCheckBox').map(function () {
           return this.value;//return each value
       }).get();
       var containter = {};
       containter['FectureDelete'] = 'yes';
       containter['FeatureRestaurantIDArray'] = values;
       featuredAJAX(containter,'FeatureRestaurantDelete');

   });




    function featuredAJAX(_p,_t){
        var request = $.ajax({
            url:'../BackEnd-controller/BackEnd-controller.php',
            type: "POST",
            cache: false,
            dataType: "html",
            data:_p
        });

        request.done(function(data){
            //append

            if(_t === 'FecturendCusine'){
                $('.Featured_cuisine_Management_table').empty().append(data);
            }

            if(_t === 'FecturendRestaurant'){
                $('.Featured_restaurant_Management_table').empty().append(data);
            }


            //delete

            if(_t === 'FecturendCusineDelete'){
                $('.Featured_cuisine_Management_table').empty().append(data);
            }

            if(_t === 'FeatureRestaurantDelete'){
                $('.Featured_restaurant_Management_table').empty().append(data);
            }

        });



    }










});