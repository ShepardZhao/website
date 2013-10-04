//CMS-AJAX.v1.0.js is a js file that contains basic functions and AJAX functions of CMS


$(document).ready(function(){
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

    function __hidenDiv(){
        $('#main-nav li').find('.Nav-list li a').removeClass('achieve');
        $('#initialPage').fadeOut(200); //hiding the initial page
        $('#basicInfo').fadeOut(200); //hiding the basicInfo page
        $('#addsLocation').fadeOut(200);//hiding the addsLocation page
        $('#TagsManagement').fadeOut(200);//hiding the tags page
        $('#adminMangement').fadeOut(200);//hiding the adminMangement page
        $('#UserList').fadeOut(200);//hiding the UserList page
        $('#Mail_Setting').fadeOut(200);//hiding the Mail_Setting page
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
        var TmpArray={};
        TmpArray[ObjSiteNmae]=SiteName;
        TmpArray[ObjSiteDesc]=SiteDesc;
        TmpArray[ObjSiteUrl]=SiteSiteUrl;
        TmpArray[ObjSiteSiteEmail]=SiteSiteEmail;
        TmpArray[ObjSiteSiteStatus]=SiteSiteStatus;
        TmpArray[ObjSitePolicy]=SitePolicy;

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
        //RestaurantTags
        if(dataObj['TagsTableName']==='B2C.RestaurantTags'&& dataObj['TagsID']==='Availability'){
            refreshTagslistAJAX('B2C.RestaurantTags','Availability','#RestaurantAvailabilityTagsList');
        }
        else if(dataObj['TagsTableName']==='B2C.RestaurantTags'&& dataObj['TagsID']==='Cuisine'){
            refreshTagslistAJAX('B2C.RestaurantTags','Cuisine','#RestaurantCuisineTagsList');
        }
        //Cuisine
        else if(dataObj['TagsTableName']==='B2C.CuisineTags'&& dataObj['TagsID']==='Availability'){
            refreshTagslistAJAX('B2C.CuisineTags','Availability','#CuisineAvailabilityTagsList');
        }
        else if(dataObj['TagsTableName']==='B2C.CuisineTags'&& dataObj['TagsID']==='Cuisine'){
            refreshTagslistAJAX('B2C.CuisineTags','Cuisine','#CuisineCuisineTagsList');
        }
        else if(dataObj['TagsTableName']==='B2C.CuisineTags'&& dataObj['TagsID']==='Type'){
            refreshTagslistAJAX('B2C.CuisineTags','Type','#CuisineTypeTagsList');
        }
        else if(dataObj['TagsTableName']==='B2C.CuisineTags'&& dataObj['TagsID']==='Price'){
            refreshTagslistAJAX('B2C.CuisineTags','Price','#CuisinePriceTagsList');
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

//Restarurant
    $('body').on('click','#RemoveResAvailabilityButton',function(){//remove Availability in Restarurant function
        window.TmpDeleteArray['IndexID']='RestaurantTagsID';
        TagAjax(window.TmpDeleteArray);
    });

    $('body').on('click','#RemoveResCuisineButton',function(){//remove Cuisine in Restaruant function
        window.TmpDeleteArray['IndexID']='RestaurantTagsID';
        TagAjax(window.TmpDeleteArray);
    });

//Cuisine
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





    /***********************************************Add Restaruants Tags*****************************************/
        //This containts Availability in Restaruant
    $('body').on('click','#AddResAvailabilityButton',function(){

        TagAjax(TmpArray('Availability',$('#InputResAvailability').val(),'B2C.RestaurantTags','False','RestaurantTagsID'));
    });

    //This containts Cuisine in Restaruant
    $('body').on('click','#AddResCuisineButton',function(){

        TagAjax(TmpArray('Cuisine',$('#InputResCuisine').val(),'B2C.RestaurantTags','False','RestaurantTagsID'));
    });

    /***********************************************Add Cuisine Tags*****************************************/
        //This containts Availability in Cuisine
    $('body').on('click','#AddCuisAvailabilityButton',function(){
        TagAjax(TmpArray('Availability',$('#InputCuisAvailability').val(),'B2C.CuisineTags','False','CuisineTagesID'));
    });

    //This containts Cuisine in Cuisine
    $('body').on('click','#AddCuisCuisineButton',function(){
        TagAjax(TmpArray('Cuisine',$('#InputCuisCuisine').val(),'B2C.CuisineTags','False','CuisineTagesID'));
    });
    //This containts Type in Cuisine
    $('body').on('click','#AddCuisTypeButton',function(){
        TagAjax(TmpArray('Type',$('#InputCuisType').val(),'B2C.CuisineTags','False','CuisineTagesID'));
    });
    //This containts Price in Cuisine
    $('body').on('click','#AddCuisPriceButton',function(){
        TagAjax(TmpArray('Price',$('#InputCuisPirce').val(),'B2C.CuisineTags','False','CuisineTagesID'));
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


    $('body').on('click','#AddLocationButton',function(){//here is using click function instead of submit because of security


        var RootLocation= $("input[name='RootLocation']").val();
        var RootLocationID=$("input[name='RootLocationID']").val();
        var TemporaryArray={};
        TemporaryArray[RootLocationID]=RootLocation;
        var SubLocation=returnInputArray("SubLocation","SubLocationID");
        if (RootLocation!==""){
            var name1 = "RootLocation";
            var name2 = "SubLocation";
            var value2 =SubLocation;
            var dataObj = {};
            dataObj[name1]=TemporaryArray;
            dataObj[name2]=value2;
            console.log(dataObj);
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

                $('<div class="alert alert-error"><strong>Cannot Added Location</strong></div>').insertBefore($('#AddLocationButton')).fadeIn(200);
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

    //Modify current record
    $('body').on('click','.Modify',function(){
        var temGetID=$(this).attr('id');
        var dataObj = {};
        dataObj["GetModifyLocationID"]=temGetID;
        ModifyAndDeleteAjax(dataObj);
    });


//delete current record
    $('body').on('click','.delete',function(){
        var temGetID=$(this).attr('id');
        var dataObj = {};
        dataObj["GetDeleteLocationID"]=temGetID;
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







});